<?php
/*
namespace si\models;
require_once __DIR__.'/baseModel.class.php';

class Account extends \si\models\baseModel{

    const TABLENAME = 'Account';
    private $data;

    public function _constuctAcc($firstname, $lastname, $email, $addressID, $role, $password = null){

        $this->data['Firstname'] = $firstname;
        $this->data['Lastname'] = $lastname;
        $this->data['Email'] = $email;
        $this->data['AddressId'] = $addressId;
        $this->data['Role'] = $role;
        if($password !== null)
        {
            $this->data['Password'] = $password;
        }
    }
    public function _getAcc($key)
    {
        if(isset($this->data[$key]))
        {
            return $this->data[$key];
        }
    }

    public function _setAcc($key, $value)
    {
        $this->data[$key] = $value;
    }

    public static function getAccountIDByEmail($email)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($email))
            {
                // TODO: check if email is safe to use in SQL Statement
                $sql = 'SELECT AccountID FROM ' . self::tablename() . ' WHERE Email = ' . $db->quote($email) . ';';
    
                $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);

                if(!empty($result['AccountID']))
                {
                    return $result['AccountID'];
                }   
            }
            return null;
            
        }
        catch(\PDOException $e)
        {
            die('Select statement failed: ' . $e->getMessage());
        }
    }

    public static function getAccountById($id)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($id))
            {
                // TODO: check if id is safe to use in SQL Statement
                $sql = 'SELECT Firstname, Lastname, Email, AddressId, Role FROM ' . self::tablename() . ' WHERE AccountID = ' . $db->quote($id) . ';';
    
                $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);

                if(!empty($result['Email']))
                {
                    $user = new User($result['Firstname'], $result['Lastname'], $result['Email'], $result['AddressId'], $result['Role']);
                    $user->userId = $id;
                    return $user;
                }   
            }
            return null;
            
        }
        catch(\PDOException $e)
        {
            die('Select statement failed: ' . $e->getMessage());
        }
    }

    public static function validateUser($email, $password)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($email) && !empty($password))
            {
                // TODO: check if email is safe to use in SQL Statement
                $sql = 'SELECT Email, Password FROM ' . self::tablename() . ' WHERE Email=' . $db->quote($email) . ';';
    
                $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);

                if(!empty($result['Email']))
                {
                    // user with email exists
                    // now check password
                    return password_verify($password, $result['Password']);
                }   
            }
            return FALSE;
            
        }
        catch(\PDOException $e)
        {
            die('Select statement ('.$sql.') failed: ' . $e->getMessage());
        }
    }

    public function insert()
    {
        $db = $GLOBALS['db'];
        try
        { 
            //check if user with this email exists in DB
            if(User::getUserIdByEmail($email))
            {
                return false;
            }

            $sql = 'INSERT INTO ' . self::tablename() . '(Firstname, Lastname, Email, Password, AddressId, Role) VALUES (:Firstname, :Lastname, :Email, :Password, :AddressId, :Role);'; 
            $statement = $db->prepare($sql);
            $statement->bindParam(':Firstname', $this->Firstname);
            $statement->bindParam(':Lastname', $this->Lastname);
            $statement->bindParam(':Email', $this->Email);
            $statement->bindParam(':Password', password_hash($this->Password, PASSWORD_DEFAULT));
            $statement->bindParam(':AddressId', $this->AddressId);
            $statement->bindParam(':Role', $this->Role);

            $statement->execute();
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error inserting user: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $db = $GLOBALS['db'];
        try
        { 
            // if user changed his E-Mail it should not be used by another user already
            // if user didn't change his E-Mail the corresponding userId should match
            $checkId = User::getUserIdByEmail($this->Email);
            if($checkId != null && $checkId != $this->AccountID)
            {
                return false;
            }

            //if user does not change password it should be null
            $addPassword = '';
            if(isset($this->Password) && $this->Password != null)
            {
                $addPassword ='Password = :Password, ';
            }
            $sql = 'UPDATE ' . self::tablename() . ' SET Firstname = :Firstname, Lastname = :Lastname, Email = :Email, '.$addPassword.'AddressId = :AddressId, Role = :Role WHERE AccountID = :AccountID;'; 
            $statement = $db->prepare($sql);
            $statement->bindParam(':Firstname', $this->Firstname);
            $statement->bindParam(':Lastname', $this->Lastname);
            $statement->bindParam(':Email', $this->Email);
            if(isset($this->Password) && $this->Password != null)
            {
                $statement->bindParam(':Password', password_hash($this->Password, PASSWORD_DEFAULT));
            }
            $statement->bindParam(':AddressId', $this->AddressId);
            $statement->bindParam(':Role', $this->Role);
            $statement->bindParam(':AccountID', $this->AccountID);

            $statement->execute();
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error updating user: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'DELETE FROM ' . self::tablename() . ' WHERE Email=' . $db->quote($this->Email) . ';';
            $db->exec($sql);
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error deleting user: ' . $e->getMessage());
        }
    }
}