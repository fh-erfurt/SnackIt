<?php
// GROß UND KLEINSCHREIBUNG MUSS NOCH AN DB ANGEPASST WERDEN
namespace si\models;

require_once 'models/basemodel.class.php';
require_once 'models/property.class.php';

class Product extends BaseModel
{
    const PRODUCT_TYPES = [
		'featured' => 0,
        'snacks' => 1,
        'drinks' => 2, 
        'other' => 99 ];
    const TABLENAME = 'Product';
    const P_H_P_TABLENAME = 'Product_has_Property';
    private $data;
    private $properties;

    public function __construct($name, $price, $prodType, $onStock = 0)
    {
        $this->data['ProdName'] = $name;
        $this->data['Price'] = $price;
        $this->data['ProdType'] = $prodType;
        $this->data['OnStock'] = $onStock;
    }

    //TODO customize functions

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
     * searches for the product with specific id in database.
     * returns Product if it exists, null otherwise
     */
    public static function getProductById($id)
    {
        $db = $GLOBALS['db'];
        $product = null;

        try
        {
            $sql = 'SELECT ProductID, ProdName, Price, ProdType, OnStock FROM ' . self::tablename() . ' WHERE ProductID = ' . $db->quote($id) . ';';
            $result = $db->query($sql)->fetch();

            if(!empty($result))
            {
                $product = new Product($result['name'], $result['price'], $result['prodType'], $result['onStock']);
                $product->productId = $result['productId'];
                $product->loadProperties();
            }
            return $product;
        }
        catch(\PDOException $e)
        {
            die('Error recieving product with id "' . $id . '": ' . $e->getMessage());
        }
    }

    public static function getFeaturedProducts()
    {
		
        $featuredProperty = array('featured' => null);
        return Product::getProductsWithProperties($featuredProperty, true);
    }

    /**
     * $properties should be an assosiative array containing the type of the property as the key and their value as the value.
     * returns all products with the given properties (type and value)
     * if $searchWithoutValue is set to true, the value is ignored, so the function returns all products containing the properties with the given type
     */
    public static function getProductsWithProperties($properties, $searchWithoutValue = false)
    {
        if(!is_array($properties) || empty($properties))
        {
            return null;
        }
		
        $db = $GLOBALS['db'];
		
        $products = [];

        try
        {
			
            $sql = 'SELECT prod.ProductID, prod.ProdName, prod.Price, prod.ProdType, prod.OnStock FROM ' . self::tablename() . 
            ' prod JOIN '. self::P_H_P_TABLENAME . ' php, ' . Property::TABLENAME . 
            ' prop WHERE prod.ProductID = php.ProductID AND php.PropertyID = prop.PropertyID';

            foreach($properties as $type => $value)
            {
                $sql .= ' AND prop.Type = ' . $db->quote($type);
                if($searchWithoutValue === false)
                {
                    $sql .= ' AND prop.Value = ' . $db->quote($value);
                }
            }
            $sql .= ';';
			
            $result = $db->query($sql)->fetchAll();
			
            if(!empty($result)) 
            {
				
                foreach($result as $row)
                {
					
                    $product = new Product($row['ProdName'], $row['Price'], $row['ProdType'], $row['OnStock']);
                    $product->productId = $row['ProductID'];
                    $product->loadProperties();
                    $products[] = $product;
					
                }
            }
            return $products;
        }
        catch(\PDOException $e)
        {
            die('Error recieving products with specific properties: ' . $e->getMessage());
        }
    }

    public static function getProductsByType($type)
    {
        $db = $GLOBALS['db'];
        $products = [];

        try
        {
            $sql = 'SELECT ProductID, ProdName, Price, ProdType, OnStock FROM ' . self::tablename() . ' WHERE ProdType = ' . self::PRODUCT_TYPES[$type] . ';';
            $result = $db->query($sql)->fetchAll();

            if(!empty($result))
            {
                foreach($result as $row)
                {
                    $product = new Product($row['ProdName'], $row['Price'], $row['ProdType'], $row['OnStock']);
                    $product->productId = $row['ProductID'];
                    $product->loadProperties();
                    $products[] = $product;
                }
            }
            return $products;
        }
        catch(\PDOException $e)
        {
            die('Error recieving all products of type "' . $type . '": ' . $e->getMessage());
        }
    }

    /**
     * returns true if insert was successful, false if product already exists with name and prodType
     */
    public function insert()
    {
        $db = $GLOBALS['db'];
        try
        {  
            //check if this product already exists in DB
            $productId = $this->queryProductId();
            if($productId !== false)
            {
                return false;
            }

            $sql = 'INSERT INTO ' . self::tablename() . ' (ProdName, Price, ProdType, OnStock) VALUES (:name, :price, :prodType, :onStock);'; 
            $statement = $db->prepare($sql);
            $statement->bindParam(':name', $this->name);
            $statement->bindParam(':price', $this->price);
            $statement->bindParam(':prodType', $this->prodType);
            $statement->bindParam(':onStock', $this->onStock);

            $statement->execute();

            // set the new productId
            $productId = $this->queryProductId();
            if($productId !== false)
            {
                $this->data['addressId'] = $addressId;
            }
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error inserting product: ' . $e->getMessage());
        }
    }

    /**
     * returns true if property is added successful, false otherwise
     * Reasons for returning false:
     * - this product has no ID and therefore is not saved in database yet
     * - property is already added
     */
    public function addProperty($type, $name, $value)
    {
        //check if product has an ID
        if(empty($this->productId))
        {
            return false;
        }

        // check if property is already attached to this product
        if(isset($this->properties[$type]) && $this->properties[$type] == $value)
        {
            return false;
        }

        // insert Property
        $property = new Property($type, $name, $value);
        $property->insertIfNotExist();

        // attach property to product in database
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'INSERT INTO ' . self::P_H_P_TABLENAME . ' (ProductID, PropertyID) VALUES (:productId, :propertyId);';

            $statement = $db->prepare($sql);
            $statement->bindParam(':productId', $this->productId);
            $statement->bindParam(':propertyId', $property->propertyId);

            $statement->execute();

            //attaching Property to product as attribute
            $this->propertyies[$name] = $value;

            return true;
        }
        catch(\PDOException $e)
        {
            die('Error adding Property "' . $name . '" to product "' . $this->name . '". Error Message: ' . $e->getMessage());
        }
    }

    public function addProperties($propertyArray)
    {
        foreach($propertyArray as $name => $value)
        {
            $this->addProperty($name,$value);
        }
    }

    public function removeProperty($name, $value)
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'DELETE php FROM ' . self::P_H_P_TABLENAME . 'php JOIN ' . Property::TABLENAME . 
                   ' p ON p.PropertyID = php.PropertyID WHERE p.ProductName =' . $db->quote($name) . ' AND p.Value = ' . $db->quote($value) . ' AND php.ProductID = ' . $db->quote($this->productId) . ';';
            $db->exec($sql);

            unset($this->properties[$name]);

            return true;
        }
        catch(\PDOException $e)
        {
            die('Error removing property: ' . $e->getMessage());
        }
    }

    public function getProperty($type)
    {
        if(isset($this->properties[$type]))
        {
            return $this->properties[$type];
        }
        return null;
    }

    public function getAllProperties()
    {
        return $this->properties;
    }

    /**
     * retrieves all Properties of this product from database for use with functions like 'getProperty' and 'getAllProperties'
     */
    public function loadProperties()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'SELECT p.PropertyID, p.Type, p.Name, p.Value FROM ' . Property::TABLENAME . ' p JOIN ' . self::P_H_P_TABLENAME . 
                   ' php ON p.PropertyID = php.PropertyID AND php.ProductID = ' . $db->quote($this->productId) . ';';
            $result = $db->query($sql)->fetchAll();

            if(!empty($result))
            {
                $this->properties = null;
                foreach($result as $row)
                {
                    $property = new Property($row['Type'], $row['Name'], $row['Value']);
                    $property->propertyId = $row['PropertyID'];
                    if(isset($this->properties[$row['Type']]))
                    {
                        if(!is_array($this->properties[$row['Type']]))
                        {
                            $this->properties[$row['Type']] = array($this->properties[$row['Type']]);
                        }
                        $this->properties[$row['Type']][] = $property;
                    }
                    else
                    {
                        $this->properties[$row['Type']] = $property;
                    }
                }
            }
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error reloading product properties: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'DELETE FROM ' . self::tablename() . ' WHERE ProductID=' . $db->quote($this->productId) . ';';
            $db->exec($sql);
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error deleting product: ' . $e->getMessage());
        }
    }

    public function toArray()
    {
        $arr = $this->data;
        foreach($this->properties as $type => $property)
        {
            if(is_array($property))
            {
                foreach($property as $prop)
                {
                    $arr['properties'][$type][] = $prop->toArray();
                }
            }
            else
            {
                $arr['properties'][$type] = $property->toArray();
            }
        }
        return $arr;
    }

    /**
     * returns the productId which belongs to the combination of name and prodType
     */
    private function queryProductId()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'SELECT ProductID FROM '. self::tablename() . 
            ' WHERE name = '    . $db->quote($this->name) . 
            ' AND ProdType = '  . $db->quote($this->prodType) . ';'; 
            
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