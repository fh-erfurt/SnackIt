<?php

namespace si\models;
require_once 'basemodel.class.php';

class User extends BaseModel
{

    const TABLENAME = 'Account';
    private $data;

    public function __construct($firstname, $lastname, $email, $addressId, $role, $password = null)
    {
        $this->data['AccountID'] = $accountID;
        $this->data['Firstname'] = $firstname;
        $this->data['Lastname'] = $lastname;
        $this->data['Email'] = $email;
        $this->data['Role'] = $role;
        $this->data['AddressID'] = $addressID;
        if($password !== null)
        {
            $this->data['Password'] = $password;
        }
    }

    //TODO: customize functions
    public function __get($key)
    {
        if(isset($this->data[$key]))
        {
            return $this->data[$key];
        }
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public static function getUserIdByEmail($email)
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

    public static function getUserById($id)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($id))
            {
                // TODO: check if id is safe to use in SQL Statement
                $sql = 'SELECT Firstname, Lastname, Email, AddressID, Role FROM ' . self::tablename() . ' WHERE AccountID = ' . $db->quote($id) . ';';
    
                $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);

                if(!empty($result['Email']))
                {
                    $user = new User($result['Firstname'], $result['Lastname'], $result['Email'], $result['AddressID'], $result['Role']);
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

    // returns TRUE if email and password are correct, FALSE otherwise
    public static function validateUser($email, $password)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($email) && !empty($password))
            {
                // TODO: check if email is safe to use in SQL Statement
                $sql = 'SELECT Email, password FROM ' . self::tablename() . ' WHERE Email=' . $db->quote($email) . ';';
    
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

    /**
     * returns true if insert was successful, false if user with this email exists in DB
     */
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

            $sql = 'INSERT INTO ' . self::tablename() . '(firstname, lastname, email, password, addressID, role) VALUES (:firstname, :lastname, :email, :password, :addressID, :role);'; 
            $statement = $db->prepare($sql);
            $statement->bindParam(':firstname', $this->firstname);
            $statement->bindParam(':lastname', $this->lastname);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':password', password_hash($this->password, PASSWORD_DEFAULT));
            $statement->bindParam(':addressID', $this->addressId);
            $statement->bindParam(':role', $this->role);

            $statement->execute();
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error inserting user: ' . $e->getMessage());
        }
    }
    /**
     * returns true if update was successful
     */
    public function updateAddressId()
    {
        $db = $GLOBALS['db'];
        try
        { 
            $sql = 'UPDATE ' . self::tablename() . ' SET addressId = :addressId WHERE email = :email;'; 
            $statement = $db->prepare($sql);
            $statement->bindParam(':addressId', $this->addressId);
            $statement->bindParam(':email', $this->email);

            $statement->execute();
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error updating user adressId: ' . $e->getMessage());
        }
    }

    /**
     * returns true if update was successful, false if user changed his email and that email already exists in DB
     */
    public function update()
    {
        $db = $GLOBALS['db'];
        try
        { 
            // if user changed his E-Mail it should not be used by another user already
            // if user didn't change his E-Mail the corresponding userId should match
            $checkId = User::getUserIdByEmail($this->email);
            if($checkId != null && $checkId != $this->accountId)
            {
                return false;
            }

            //if user does not change password it should be null
            $addPassword = '';
            if(isset($this->password) && $this->password != null)
            {
                $addPassword ='password = :password, ';
            }
            $sql = 'UPDATE ' . self::tablename() . ' SET firstname = :firstname, lastname = :lastname, email = :email, '.$addPassword.'addressId = :addressId, role = :role WHERE accountId = :accountId;'; 
            $statement = $db->prepare($sql);
            $statement->bindParam(':firstname', $this->firstname);
            $statement->bindParam(':lastname', $this->lastname);
            $statement->bindParam(':email', $this->email);
            if(isset($this->password) && $this->password != null)
            {
                $statement->bindParam(':password', password_hash($this->password, PASSWORD_DEFAULT));
            }
            $statement->bindParam(':addressId', $this->addressId);
            $statement->bindParam(':role', $this->role);
            $statement->bindParam(':accountId', $this->userId);

            $statement->execute();
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error updating account: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'DELETE FROM ' . self::tablename() . ' WHERE email=' . $db->quote($this->email) . ';';
            $db->exec($sql);
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error deleting user: ' . $e->getMessage());
        }
    }

    private function exist()
    {
        $db = $GLOBALS['db'];
        try
        {
            if(isset($this->userId))
            $sql = 'SELECT accountId FROM ' . self::tablename() . ' WHERE email=' . $db->quote($this->email) . ';';
            $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);
            if(!empty($result['accountId']))
            {
                return true;
            }
            return false;
        }
        catch(\PDOException $e)
        {
            die('Select statement ('.$sql.') failed' . $e->getMessage());
        }
    }
}