<?php

/////////////////////////////////////////////
//ACCOUNT FUNCTIONS:
/////////////////////////////////////////////
    
	//Validates the login
    function validateAccount($email, $password) 
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($email) && !empty($password))
            {
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
	
	function getAccountDataById($AccountID)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($AccountID))
            {
                // TODO: check if email is safe to use in SQL Statement
                $sql = 'SELECT * FROM account JOIN address on account.AddressId = address.AddressId WHERE AccountID = ' . $db->quote($AccountID) .';';
    
                $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);

                return $result;
                  
            }
            return null;
            
        }
        catch(\PDOException $e)
        {
            die('Select statement failed: ' . $e->getMessage());
        }
    }
	
	//inserts the new account into the db //NEEDS TESTING
	function insertnewAccount($email, $password, $password2, $firstname, $lastname, $country,
											$zipcode, $city, $street, $number)
	{
		$db = $GLOBALS['db'];
       try
       {
		   $addressId = queryAddressId($country, $zipcode, $city, $street, $number);
		   $password = password_hash($password, PASSWORD_DEFAULT);
		   $Emailexists = null;
		   
		   $sql = 'SELECT Email FROM '. 'account' . 
            ' WHERE Email = ' . $db->quote($email) .';';
		   
		   $Emailexists = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);
		   
		   if($Emailexists != null)
		   {
			   return 'Account mit der Email schon vorhanden';
           }		   
		   elseif($addressId !== false && $Emailexists == null)
            {
				
                //address found
                $sql = 'INSERT INTO ' . 'account' . '(FirstName, LastName, Email, Password, AddressId) VALUES  (:firstname, :lastname, :email, :password, :addressId)';
                $statement = $db->prepare($sql);
                $statement->bindParam(':firstname', $firstname);               
                $statement->bindParam(':lastname', $lastname);
                $statement->bindParam(':email', $email);
                $statement->bindParam(':password', $password);
                $statement->bindParam(':addressId', $addressId);

                $statement->execute(); 
        
            }
            else 
            {
                // no address in DB -> insert new adress
                $sql = 'INSERT INTO ' . 'address' . '(Country, Zipcode, City, Street, Number) VALUES  (:country, :zipcode, :city, :street, :number)'; 
                $statement = $db->prepare($sql);
                $statement->bindParam(':country', $country);               
                $statement->bindParam(':zipcode', $zipcode);
                $statement->bindParam(':city', $city);
                $statement->bindParam(':street', $street);
                $statement->bindParam(':number', $number);

                $statement->execute();

                // set the new addressId
                $addressId = queryAddressId($country, $zipcode, $city, $street, $number);
                
                
					
                    $sql = 'INSERT INTO ' . 'account' . '(FirstName, LastName, Email, Password, AddressId) VALUES  (:firstname, :lastname, :email, :password, :addressId)';
                    $statement = $db->prepare($sql);
                    $statement->bindParam(':firstname', $firstname);               
                    $statement->bindParam(':lastname', $lastname);
                    $statement->bindParam(':email', $email);
                    $statement->bindParam(':password', $password);
                    $statement->bindParam(':addressId', $addressId);
    
                    $statement->execute();
                
            }
			$_SESSION['loggedIn'] = true;
            $_SESSION['AccountID'] = getAccountIdByEmail($email);
			header('Location: index.php');
		   }
		   catch(\PDOException $e)
			{
            die('Select statement failed in insertnewAccount: ' . $e->getMessage());
			}          
    }
       
		
		
	
	
    //gives the addressid of the address
	function queryAddressId($country, $zipcode, $city, $street, $number)
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'SELECT AddressId FROM '. 'address' . 
            ' WHERE Country = ' . $db->quote($country) . 
            ' AND Zipcode = '   . $db->quote($zipcode) . 
            ' AND City = '      . $db->quote($city) . 
            ' AND Street = '    . $db->quote($street) . 
            ' AND Number = '    . $db->quote($number) . ';'; 
            
            $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);

            if(!empty($result['AddressId']))
            {
                return $result['AddressId'];
            }
            return false;
        }
        catch(\PDOException $e)
        {
            die('Select statement failed in queryAddressId: ' . $e->getMessage());
        }
        
    }
	
    //looks up if there is a Null value in the array
	function containsNullValue($array)
{
    foreach($array as $key => $value)
    {
        if($value == null)
        {
            return true;
        }
    }
    return false;
}

?>