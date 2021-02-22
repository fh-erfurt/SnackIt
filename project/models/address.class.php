<?php



require_once __DIR__ . '/baseModel.class.php';

class Address
{

    const TABLENAME = 'Address';
    private $data;

    public function __construct($country, $state, $zipcode, $city, $street, $number)
    {
        $this->data['country'] = $country;
        $this->data['state'] = $state;
        $this->data['zipcode'] = $zipcode;
        $this->data['city'] = $city;
        $this->data['street'] = $street;
        $this->data['number'] = $number;
    }

    public function __get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
    }

    public static function getAddressById($id)
    {
        $db = $GLOBALS['db'];
        try {
            if (!empty($id)) {
                $sql = 'SELECT country, state, zipcode, city, street, number FROM Address WHERE addressId = ' . $db->quote($id) . ';';

                $result = $db->query($sql)->fetch();

                if (!empty($result['country'])) {
                    $address = new Address($result['country'], $result['state'], $result['zipcode'], $result['city'], $result['street'], $result['number']);
                    return $address;
                }
            }
            return null;
        } catch (\PDOException $e) {
            die('Select statement failed: ' . $e->getMessage());
        }
    }

    /**
     * This function inserts the adress with all its attributes into the database and sets its 'addressId'
     * if the address already exists, only the attribute 'addressId' is set
     */
    public function insertIfNotExist()
    {
        $db = $GLOBALS['db'];
        try {
            $addressId = $this->queryAddressId();

            if ($addressId !== false) {
                //address found
                if (empty($this->data['addressId'])) {
                    // set the addressId of this object
                    $this->data['addressId'] = $addressId;
                }
            } else {
                // no address in DB -> insert new adress

                $sql = 'INSERT INTO Address(country, state, zipcode, city, street, number) VALUES (:country, :state, :zipcode, :city, :street, :number)';
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
                if ($addressId !== false) {
                    $this->data['addressId'] = $addressId;
                }
            }
            return true;
        } catch (\PDOException $e) {
            die('Error inserting address: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        $db = $GLOBALS['db'];
        try {
            $sql = 'DELETE FROM Address WHERE adressId=' . $this->adressId . ';';
            $db->exec($sql);
            return true;
        } catch (\PDOException $e) {
            die('Error deleting address: ' . $e->getMessage());
        }
    }

    /**
     * checks in database if the address with its attributes exists
     * if it exists, the addressId is returned, otherwise false is returned
     */
    private function queryAddressId()
    {
        $db = $GLOBALS['db'];
        try {
            $sql = 'SELECT addressId FROM Address 
             WHERE country = ' . $db->quote($this->country) .
                ' AND state = '     . $db->quote($this->state) .
                ' AND zipcode = '   . $db->quote($this->zipcode) .
                ' AND city = '      . $db->quote($this->city) .
                ' AND street = '    . $db->quote($this->street) .
                ' AND number = '    . $db->quote($this->number) . ';';

            $result = $db->query($sql)->fetch(\PDO::FETCH_ASSOC);

            if (!empty($result['addressId'])) {
                return $result['addressId'];
            }
            return false;
        } catch (\PDOException $e) {
            die('Select statement failed: ' . $e->getMessage());
        }
    }
}
