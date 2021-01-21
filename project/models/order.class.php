<?php
// GROß UND KLEINSCHREIBUNG MUSS NOCH AN DB ANGEPASST WERDEN
namespace si\models;

require_once 'models/basemodel.class.php';
require_once 'models/product.class.php';

class Order extends BaseModel{

    const TABLENAME = 'Orders';
    const P_T_O_TABLENAME = 'Product_to_Order';
    private $data;

    public function __construct($userId, $status=0, $addressId=null, $firstname=null, $lastname=null)
    {
        $this->data['userId'] = $userId;
        $this->data['addressId'] = $addressId;
        $this->data['firstname'] = $lastname;
        $this->data['addressId'] = $addressId;
        $this->data['status'] = $status;
        $this->data['products'] = [];
    }
    
    public function __get($key)
    {
        if(isset($this->data[$key]))
        {
            return $this->data[$key];
        }
    }

    public static function getOrderById($id)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($id))
            {
                $sql = 'SELECT userId, status, addressId, firstname, lastname FROM ' . self::tablename() . ' WHERE orderId = ' . $db->quote($id) . ';';
    
                $result = $db->query($sql)->fetch();

                if(!empty($result['userId']))
                {
                    $order = new Order($result['userId'], $result['status'], $result['addressId'], $result['firstname'], $result['lastname']);
                    $order->data['orderId'] = $id;
                    $order->loadProducts();
                    return $order;
                }   
            }
            return null;
            
        }
        catch(\PDOException $e)
        {
            die('Select statement failed: ' . $e->getMessage());
        }
    }

    public static function getShoppingCartByUserId($userId)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($userId))
            {
                $sql = 'SELECT orderId, status, addressId, firstname, lastname status FROM ' . self::tablename() . ' WHERE userId = ' . $db->quote($userId) . ' AND status = 0;';
    
                $result = $db->query($sql)->fetch();

                if(!empty($result['orderId']))
                {
                    $order = new Order($userId, $result['status'], $result['addressId'], $result['firstname'], $result['lastname']);
                    $order->data['orderId'] = $result['orderId'];
                    $order->loadProducts();
                    return $order;
                }   
            }
            return null;
        }
        catch(\PDOException $e)
        {
            die('Select statement failed: ' . $e->getMessage());
        }
    }

    public static function getOrdersByUserId($userId)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($userId))
            {
                $sql = 'SELECT orderId, status, addressId, firstname, lastname status FROM ' . self::tablename() . ' WHERE userId = ' . $db->quote($userId) . ';';
    
                $result = $db->query($sql)->fetchAll();

                $orders = [];
                if(!empty($result))
                {
                    foreach($result as $row)
                    {
                        $order = new Order($userId, $row['status'], $row['addressId'], $row['firstname'], $row['lastname']);
                        $order->data['orderId'] = $row['orderId'];
                        $order->loadProducts();
                        $orders[]=$order;
                    }
                }   
                return $orders;
            }
            return null;
        }
        catch(\PDOException $e)
        {
            die('Select statement failed: ' . $e->getMessage());
        }
    }

    /**
     * This function fills the Product_to_Order table with the given products and loads the products into the order object
     * The products parameter should be an associative array with key=productId and value=count
     * return TRUE if products were successfully added,
     *        FALSE if order has no orderID or the parameter is not an array
     */
    public function addProducts($products)
    {
        if(!isset($this->data['orderId']) || !is_array($products))
        {
            return false;
        }
        
        $db = $GLOBALS['db'];

        try
        {
            $sqlUpdate = 'UPDATE ' . self::P_T_O_TABLENAME . ' SET productCount = :productCount WHERE orderId = :orderId AND productId = :productId;'; 
            $sqlInsert = 'INSERT INTO ' . self::P_T_O_TABLENAME . '(orderId, productId, productCount) VALUES (:orderId, :productId, :productCount)'; 
            $update = $db->prepare($sqlUpdate);
            $insert = $db->prepare($sqlInsert);
            var_dump($products);
            foreach($products as $productId => $productCount)
            {
                $oldProductCount = intval($this->getProductCountByProductId($productId));
                if($oldProductCount > 0)
                {
                    $newProductCount = $oldProductCount + intval($productCount);
                    $update->bindParam(':orderId', $this->data['orderId']);
                    $update->bindParam(':productId', $productId);
                    $update->bindParam(':productCount', $newProductCount);
                    $update->execute();
                }
                else
                {
                    $insert->bindParam(':orderId', $this->data['orderId']);
                    $insert->bindParam(':productId', $productId);
                    $insert->bindParam(':productCount', $productCount);
                    $insert->execute();
                }
            }
            $this->loadProducts();
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error inserting products to order: ' . $e->getMessage());
        }
    }

    public function loadProducts()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'SELECT productId, productCount FROM ' . self::P_T_O_TABLENAME . ' WHERE orderId = ' . $db->quote($this->orderId) . ';';
            $result = $db->query($sql)->fetchAll();

            if(!empty($result))
            {
                $this->data['products'] = [];
                foreach($result as $row)
                {
                    $this->data['products'][] = [
                        'product' => Product::getProductById($row['productId']),
                        'count' => $row['productCount']];
                }
            }
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error loading order products: ' . $e->getMessage());
        }
    }

    /**
     * search in the associated products for the specified product
     * return product object if it is found
     *        null if not found
     */
    public function getProductById($productId)
    {
        $products = $this->data['products'];
        if(is_array($products))
        {
            foreach($products as $productContainer)
            {
                if($productContainer['product']->productId == $productId) return $productContainer['product'];
            }
        }
        return null;
    }

    /**
     * search in the associated products for the specified product
     * return product count if it is found
     *        0 if not found
     */
    public function getProductCountByProductId($productId)
    {
        $products = $this->data['products'];
        if(is_array($products))
        {
            foreach($products as $productContainer)
            {
                if($productContainer['product']->productId == $productId) return $productContainer['count'];
            }
        }
        return 0;
    }

    public function getProductCount()
    {
        $count = 0;
        foreach($this->data['products'] as $productContainer)
        {
            $count += intval($productContainer['count']);
        }
        return $count;
    }
    
    public function insert()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'INSERT INTO ' . self::tablename() . ' (userId, status, addressId, firstname, lastname) VALUES (:userId, :status, :addressId, :firstname, :lastname);'; 
            $statement = $db->prepare($sql);
            $statement->bindParam(':userId', $this->data['userId']);
            $statement->bindParam(':addressId', $this->data['addressId']);
            $statement->bindParam(':firstname', $this->data['firstname']);
            $statement->bindParam(':lastname', $this->data['lastname']);
            $statement->bindParam(':status', $this->data['status']);

            $statement->execute();

            $orderId = $db->lastInsertId();
            $this->data['orderId'] = $orderId;
            return true;
        }
        catch(\PDOException $e)
        {
            if($e->getCode() == 'IM001')
            {
                // TODO: implement alternative way to get inserted ID
                die('The database does not support "lastInsertId()": ' . $e->getMessage());
            }
            die('Error inserting order: ' . $e->getMessage());
        }
    }

    /*public function delete()
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'DELETE FROM ' . self::tablename() . ' WHERE orderID=' . $this->orderId . ';';
            $db->exec($sql);
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error deleting order: ' . $e->getMessage());
        }
    }*/

}