 <?//todo Helper sind noch nicht erstellt
 require_once 'models/order.class.php';
 use models\Order;
 
 function saveShoppingCart()
{
    $shoppingCart = Order::getShoppingCartByUserId($_SESSION['userId']);
    if(isset($_SESSION['shoppingCart']))
    {
        if($shoppingCart == null)
        {
            $shoppingCart = new Order($_SESSION['userId']);
            $shoppingCart->insert();
        }
        $shoppingCart->addProducts($_SESSION['shoppingCart']);
        unset($_SESSION['shoppingCart']);
    };
    if($shoppingCart != null)
    { 
        $_SESSION['shoppingCartId'] = $shoppingCart->orderId;
        $_SESSION['shoppingCartCount'] = $shoppingCart->getProductCount();
    }
}
 
 
 function containsNull($array)
{
    foreach($array as $key => $element)
    {
        if($element == null)
        {
            return true;
        }
    }
    return false;
}
 
 
 
 ?>