<?php

//todo pass den scheiß an

require_once __DIR__.'/baseModel.class.php';

class Property extends si\models\baseModel{

    const SPECIAL_PROPERTIES = [
        'mainPicture',  // picture, that should be shown in product list
        'pictures',     // pictures, which should be shown additionally to mainPicture on the item page
        'featured'      // if product has this property, it should be shown on index page 
    ];
    const TABLENAME = 'Property';
    private $data;

    public function __construct($type, $name, $value)
    {
        $this->data['type'] = $type;
        $this->data['name'] = $name;
        $this->data['value'] = $value;
    }

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

    /**
     * This function inserts the property into the database and sets its 'propertyId'
     * if the property already exists, only the attribute 'propertyId' is set
     */
    public function insertIfNotExist()
    {
        $db = $GLOBALS['db'];
        try
        {
            $propertyId = $this->queryPropertyId();

            if($propertyId !== false)
            {
                if(empty($this->data['propertyId']))
                {
                    $this->data['propertyId'] = $propertyId;
                }
            }
            else
            {
                $sql = 'INSERT INTO ' . self::tablename() . '(type, name, value) VALUES (:type, :name, :value)'; 
                $statement = $db->prepare($sql);
                $statement->bindParam(':type', $this->type);
                $statement->bindParam(':name', $this->name);
                $statement->bindParam(':value', $this->value);

                $statement->execute();

                // set the new propertyId
                $propertyId = $this->queryPropertyId();
                if($propertyId !== false)
                {
                    $this->data['propertyId'] = $propertyId;
                }
            }
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error inserting property: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'DELETE FROM ' . self::tablename() . ' WHERE propertyId=' . $db->quote($this->propertyId) . ';';
            $db->exec($sql);
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error deleting property: ' . $e->getMessage());
        }
    }

    public function toArray()
    {
        return $this->data;
    }

    /**
     * returns the productId which belongs to the combination of name and prodType
     */
    private function queryPropertyId()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'SELECT propertyId FROM '. self::tablename() . 
            ' WHERE type = '    . $db->quote($this->type) . 
            ' AND `value` = '  . $db->quote($this->value) . ';'; 
            
            $result = $db->query($sql)->fetch();

            if(!empty($result['productId']))
            {
                return $result['productId'];
            }
            return false;
        }
        catch(\PDOException $e)
        {
            die('Select statement failed: ' . $e->getMessage());
        }
    }
}