<?php



require_once __DIR__.'/baseModel.class.php';
require_once __DIR__.'/product.class.php';

class Order extends si\models\baseModel{

    const TABLENAME = 'Orders';
    const P_T_O_TABLENAME = 'Product_to_Order';
    private $data;
 

    public function __construct($accountId ,$status=0, $addressId=null, $firstname=null, $lastname=null)
    {
        $this->data['AccountID'] = $accountId;
        $this->data['addressId'] = $addressId;
        $this->data['firstname'] = $firstname;
        $this->data['lastname'] = $lastname;
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

    public static function getOrderById($orderId)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($orderId))
            {
                $sql = 'SELECT AccountID, Status, AddressID, Firstname, Lastname FROM Orders WHERE OrderID = ' . $db->quote($orderId) . ';';
    
                $result = $db->query($sql)->fetch();

                if(!empty($result['AccountID']))
                {
                    $order = new Order($result['AccountID'], $result['Status'], $result['AddressID'], $result['Firstname'], $result['Lastname']);
                    $order->data['OrderID'] = $orderId;
                    $order->loadProducts($orderId);
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

    public static function getShoppingCartByAccountId($accountId)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($accountId))
            {
                $sql = 'SELECT OrderID, Status, AddressID, Firstname, Lastname FROM Orders WHERE AccountID = ' . $db->quote($accountId) . ' AND status = 0;';
    
                $result = $db->query($sql)->fetch();

                if(!empty($result['orderId']))
                {
                    $order = new Order($accountId, $result['status'], $result['addressId'], $result['firstname'], $result['lastname']);
                    $order->data['orderId'] = $result['orderId'];
                    $order->loadProducts($orderId);
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

    public static function getOrdersByAccountId($accountId)
    {
        $db = $GLOBALS['db'];
        try
        {
            if(!empty($accountId))
            {
                $sql = 'SELECT OrderID, Status, AddressID, Firstname, Lastname FROM Orders WHERE AccountID = ' . $db->quote($accountId) . ';';
    
                $result = $db->query($sql)->fetchAll();

                $orders = [];
                if(!empty($result))
                {
                    foreach($result as $row)
                    {
                        $order = new Order($accountId, $row['status'], $row['addressId'], $row['firstname'], $row['lastname']);
                        $order->data['orderId'] = $row['orderId'];
                        $order->loadProducts($orderId);
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

    /*
     * This function fills the Product_to_Order table with the given products and loads the products into the order object
     * The products parameter should be an associative array with key=productId and value=count
     * return TRUE if products were successfully added,
     *        FALSE if order has no orderID or the parameter is not an array
     */
    public function addProducts($products)
    {
        if(!isset($this->data['OrderID']) || !is_array($products))
        {
            return false;
        }
        
        $db = $GLOBALS['db'];

        try
        {
            $sqlUpdate = 'UPDATE Product_to_Order SET ProductCount = :productCount WHERE OrderID = :orderId AND ProductID = :productId;'; 
            $sqlInsert = 'INSERT INTO Product_to_Order (OrderID, ProductID, ProductCount) VALUES (:orderId, :productId, :productCount)'; 
            
      
            foreach($products as $productId => $productCount)
            {
                $oldProductCount = intval($this->getProductCountByProductId($productId));
                if($oldProductCount > 0)
                {
                    $update = $db->prepare($sqlUpdate);
                    $newProductCount = $oldProductCount + intval($productCount);
                    $update->bindParam(':orderId', $this->data['OrderID']);
                    $update->bindParam(':productId', $productId);
                    $update->bindParam(':productCount', $newProductCount);
                    $update->execute();
                }
                else
                {
                    
                    $insert = $db->prepare($sqlInsert);
                    $insert->bindParam(':orderId', $this->data['OrderID']);
                    $insert->bindParam(':productId', $productId);
                    $insert->bindParam(':productCount', $productCount);
                    $insert->execute();
                }
            }
            $this->loadProducts($this->data['OrderID']);
            return true;
        }
        catch(\PDOException $e)
        {
            die('Error inserting products to order: ' . $e->getMessage());
        }
        
    }

   
    public function loadProducts($orderId)
    {
        $db = $GLOBALS['db'];
        try
        {
            $sql = 'SELECT ProductID, ProductCount FROM Product_to_Order WHERE OrderID = ' . $db->quote($orderId) . ';';
            $result = $db->query($sql)->fetchAll();

            if(!empty($result))
            {
                $this->data['products'] = [];
                foreach($result as $row)
                {
                    $this->data['products'][] = [
                        'product' => Product::getProductById($row['ProductID']),
                        'count' => $row['ProductCount']
                    ];
                }
            }
            else
            {
                $this->data['products'][]=[
                    'product' => 'leer',
                    'count' => 99
                ];
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
    public function getProductCountByProductId($ProductID)
    {
        $products = $this->data['products'];
        if(is_array($products))
        {
            foreach($products as $productContainer)
            {
                if($productContainer['product']->productId == $ProductID) return $productContainer['count'];
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
            $sql = 'INSERT INTO Orders (AccountID, Status, AddressID, Firstname, Lastname) VALUES (:accountId, :status, :addressId, :firstname, :lastname);'; 
            $statement = $db->prepare($sql);
            $statement->bindParam(':accountId', $this->data['AccountID']);
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