<?php

require_once __DIR__ . '/baseModel.class.php';
require_once __DIR__ . '/property.class.php';

class Product extends \si\models\baseModel
{
    const PRODUCT_TYPES = [
        'Snacks' => 0,
        'Drinks' => 1,
        'Bundles' => 2,
    ];
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

    public function __get($key)
    {
        if (isset($this->data[$key])) {
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

        try {
            $sql = 'SELECT productId, ProdName, Price, ProdType, OnStock FROM product WHERE productId = ' . $db->quote($id) . ';';
            $result = $db->query($sql)->fetch();

            if (!empty($result)) {
                $product = new Product($result['ProdName'], $result['Price'], $result['ProdType'], $result['OnStock']);
                $product->productId = $result['productId'];
                //$product->loadProperties();
            }
            return $product;
        } catch (\PDOException $e) {
            die('Error recieving product with id "' . $id . '": ' . $e->getMessage());
        }
    }


    public static function getProductsByType($type)
    {
        $db = $GLOBALS['db'];
        $products = [];

        try {
            $sql = 'SELECT productId, ProdName, Price, ProdType, OnStock FROM product WHERE ProdType = ' . $type . ';';
            $result = $db->query($sql)->fetchAll();

            if (!empty($result)) {
                foreach ($result as $row) {
                    $product = new Product($row['ProdName'], $row['Price'], $row['ProdType'], $row['OnStock']);
                    $product->productId = $row['productId'];
                    $product->loadProperties();
                    $products[] = $product;
                }
            }
            return $products;
        } catch (\PDOException $e) {
            die('Error recieving all products of type "' . $type . '": ' . $e->getMessage());
        }
    }

    /**
     * returns the productId which belongs to the combination of name and prodType
     */
    private function queryProductId()
    {
        $db = $GLOBALS['db'];
        try {
            $sql = 'SELECT productId FROM ' . self::tablename() .
                ' WHERE name = '    . $db->quote($this->name) .
                ' AND prodType = '  . $db->quote($this->prodType) . ';';

            $result = $db->query($sql)->fetch();

            if (!empty($result['productId'])) {
                return $result['productId'];
            }
            return false;
        } catch (\PDOException $e) {
            die('Select statement failed: ' . $e->getMessage());
        }
    }

    /**
     * returns true if insert was successful, false if product already exists with name and prodType
     */
    public function insert()
    {
        $db = $GLOBALS['db'];
        try {
            //check if this product already exists in DB
            $productId = $this->queryproductId();
            if ($productId !== false) {
                return false;
            }

            $sql = 'INSERT INTO ' . self::tablename() . ' (ProdName, Price, ProdType, OnStock) VALUES (:ProdName, :Price, :ProdType, :OnStock);';
            $statement = $db->prepare($sql);
            $statement->bindParam(':ProdName', $this->ProdName);
            $statement->bindParam(':Price', $this->Price);
            $statement->bindParam(':ProdType', $this->ProdType);
            $statement->bindParam(':OnStock', $this->OnStock);

            $statement->execute();

            // set the new productId
            $productId = $this->queryproductId();
            if ($productId !== false) {
                $this->data['productId'] = $productId;
            }
            return true;
        } catch (\PDOException $e) {
            die('Error inserting product: ' . $e->getMessage());
        }
    }



    public function getProperty($type)
    {
        if (isset($this->properties[$type])) {
            return $this->properties[$type];
        }
        return null;
    }

    public function getAllProperties()
    {
        return $this->properties;
    }

    public function loadProperties()
    {
        $db = $GLOBALS['db'];
        try {
            $sql = 'SELECT p.propertyId, p.Type, p.Name, p.Value FROM ' . Property::TABLENAME . ' p JOIN ' . self::P_H_P_TABLENAME .
                ' php ON p.propertyId = php.propertyId AND php.productId = ' . $db->quote($this->productId) . ';';
            $result = $db->query($sql)->fetchAll();

            if (!empty($result)) {
                $this->properties = null;
                foreach ($result as $row) {
                    $property = new Property($row['Type'], $row['Name'], $row['Value']);
                    $property->propertyId = $row['propertyId'];
                    if (isset($this->properties[$row['Type']])) {
                        if (!is_array($this->properties[$row['Type']])) {
                            $this->properties[$row['Type']] = array($this->properties[$row['Type']]);
                        }
                        $this->properties[$row['Type']][] = $property;
                    } else {
                        $this->properties[$row['Type']] = $property;
                    }
                }
            }
            return true;
        } catch (\PDOException $e) {
            die('Error reloading product properties: ' . $e->getMessage());
        }
    }

    public function getProductsByPropType($type, $prodType)
    {
        $db = $GLOBALS['db'];
        try {
            $sql = 'SELECT * FROM product Join product_has_property on product.productId = product_has_property.productId
             join property on product_has_property.propertyId = property.propertyId where property.Type =' . $db->quote($type) . ' and product.ProdType = ' . $db->quote($prodType) . ';';
            $result = $db->query($sql)->fetchAll();
            if (!empty($result)) {
                foreach ($result as $row) {
                    $product = new Product($row['ProdName'], $row['Price'], $row['ProdType'], $row['OnStock']);
                    $product->productId = $row['productId'];
                    $product->loadProperties();
                    $products[] = $product;
                }
            }
            return $products;
        } catch (\PDOException $e) {
            die('Error reloading product properties: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        $db = $GLOBALS['db'];
        try {
            $sql = 'DELETE FROM ' . self::tablename() . ' WHERE productId=' . $db->quote($this->productId) . ';';
            $db->exec($sql);
            return true;
        } catch (\PDOException $e) {
            die('Error deleting product: ' . $e->getMessage());
        }
    }
}
