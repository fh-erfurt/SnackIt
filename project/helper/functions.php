<?php

/////////////////////////////////////////////
//ACCOUNT FUNCTIONS:
/////////////////////////////////////////////
    
	//Validates the login
    function validateAccount($email, $password) 
    {
		echo "TEST";
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($email) && !empty($password))
            {
                echo "TEST";
                // TODO: check if email is safe to use in SQL Statement
                $sql = 'SELECT Email, Password FROM ' . 'account' . ' WHERE Email=' . $db->quote($email) . ';';
    
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

    function getAccountIdByEmail($email)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($email))
            {
                // TODO: check if email is safe to use in SQL Statement
                $sql = 'SELECT AccountID FROM ' . 'account' . ' WHERE Email = ' . $db->quote($email) . ';';
    
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
	
	
	function insertnewAccount($email, $password, $password2, $firstname, $lastname, $country,
											$zipcode, $city, $street, $number)
	{
		$db = $GLOBALS['db'];
       try
       {
		   $addressId = $this->queryAddressId($country, $zipcode, $city, $street, $number);
           if($addressId !== false)
            {
                //address found
                if(empty($this->data['addressId']))
                {
                    $sql = 'INSERT INTO ' . Account . '(FirstName, LastName, Email, Password, AddressId) VALUES' ($firstname, :state, :zipcode, :city, :street, :number); 
                }
            }
            else
            {
                // no address in DB -> insert new adress

                $sql = 'INSERT INTO ' . self::tablename() . '(country, state, zipcode, city, street, number) VALUES (:country, :state, :zipcode, :city, :street, :number)'; 
                $statement = $db->prepare($sql);
                $statement->bindParam(':country', $this->country);
                $statement->bindParam(':state', $this->state);
                $statement->bindParam(':zipcode', $this->zipcode);
                $statement->bindParam(':city', $this->city);
                $statement->bindParam(':street', $this->street);
                $statement->bindParam(':number', $this->number);

                $statement->execute();

                // set the new addressId
                $addressId = $this->queryAddressId();
                if($addressId !== false)
                {
                    $this->data['addressId'] = $addressId;
                }
            }
            return true;
            
       }
       catch(\PDOException $e)
       {
            die('Select statement failed: ' . $e->getMessage());
       }
		
		
	}
	
	 private function queryAddressId($country, $zipcode, $city, $street, $number)
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'SELECT addressId FROM '. self::tablename() . 
            ' WHERE Country = ' . $db->quote($country) . 
            ' AND Zipcode = '   . $db->quote($zipcode) . 
            ' AND City = '      . $db->quote($city) . 
            ' AND Street = '    . $db->quote($street) . 
            ' AND Number = '    . $db->quote($number) . ';'; 
            
            $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);

            if(!empty($result['addressId']))
            {
                return $result['addressId'];
            }
            return false;
        }
        catch(\PDOException $e)
        {
            die('Select statement failed: ' . $e->getMessage());
        }
        
    }
	
	

?>