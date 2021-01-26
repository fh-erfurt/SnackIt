 <?//todo Helper sind noch nicht erstellt
 require_once 'models/order.class.php';
 use si\models\Order;
 
 function filterProductsByPages($products)
{
    // get max page
    $productsPerPage = (isset($_GET['productsPerPage']) && ctype_digit($_GET['productsPerPage']) && intval($_GET['productsPerPage']) > 0) ? intval($_GET['productsPerPage']) : 25;
    $maxPage = intdiv(count($products),intval($productsPerPage)) + 1;

    // get current page
    if(isset($_GET['applyPpP']) && ctype_digit($_GET['applyPpP']) && intval($_GET['applyPpP']) > 0 && intval($_GET['applyPpP']) <= $maxPage)
    {
        $page = intval($_GET['applyPpP']);
    }
    if(isset($_GET['back']) && ctype_digit($_GET['back']) && intval($_GET['back']) > 0)
    {
        $page = intval($_GET['back']);
    }
    else if (isset($_GET['forward']) && ctype_digit($_GET['forward']) && intval($_GET['forward']) <= $maxPage)
    {
        $page = intval($_GET['forward']);
    }
    else if (isset($_GET['goToPage']) && ctype_digit($_GET['toPage']) && intval($_GET['toPage']) > 0 && intval($_GET['toPage']) <= $maxPage)
    {
        $page = intval($_GET['toPage']);
    }
    else
    {
        $page = 1;
    }

    // filter product count to be shown
    if(count($products) > $productsPerPage * ($page-1))
    {
        $products = array_slice($products, $productsPerPage * ($page-1), $productsPerPage);
    }

    // set get parameter for page form
    $blacklist = ['forward', 'back', 'toPage', 'GoToPage', 'productsPerPage', 'applyPpP'];
    foreach($_GET as $key => $value)
    {
        if(!in_array($key, $blacklist))
        {
            $getParameters[$key] = $value;
        }
    }

    $result['page'] = $page;
    $result['maxPage'] = $maxPage;
    $result['productsPerPage'] = $productsPerPage;
    $result['getParameters'] = $getParameters ?? null;
    $result['products'] = $products;
    return $result;
}
 
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