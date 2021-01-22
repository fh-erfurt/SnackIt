<?php

namespace dwp\controller;

require_once __DIR__.'/../models/product.class.php';
require_once __DIR__.'/../models/property.class.php';
require_once __DIR__.'/../models/order.class.php';
require_once __DIR__.'/../helper/filter.class.php';
use si\models\Product;
use si\models\Property;
use si\models\Order;
use si\helper\Filter;

class ProductsController extends si\core\Controller
{

    /**
     * this action shows all products belonging to one type of products
     */
	public function actionList()
	{
        $productType = $_GET['t'] ?? null;

        // check if product type exists
        if($productType === null || !array_key_exists(strtolower($productType), Product::PRODUCT_TYPES))
        {
            header('Location: index.php');
        }

        
        $products = Product::getProductsByType(strtolower($productType));
        $filter = Filter::getFilterByCategory(strtolower($productType));
        
        // apply filter to product list
        if(isset($_GET['applyFilter']))
		{  
			$products = Filter::applyFilter($products);
        }

        // dynamically load products
        if(isset($_GET['ajax']))
        {
            $productCount = $_GET['productCount'];
            $products = array_slice($products, $productCount, 10);
            $productArray = [];
            foreach($products as $product)
            {
                $productArray[] = $product->toArray();
            }
            $result['productCount'] = $productCount;
            $result['products'] = $productArray;
            $result = json_encode($result);
            echo $result;
            exit(0);
        }

        // get the correct title for the product type
        $productTypes = \parse_ini_file('config/productTypeMapping.ini');
        if(isset($productTypes[$productType]))
        {
            $productTypeTitle = $productTypes[$productType];
        }
        else
        {
            $productTypeTitle = $productType;
        }
        
        // filter pages
        $container = filterProductsByPages($products);

        $this->_params['title'] = 'SI | ' . $productTypeTitle;
        $this->_params['products'] = $container['products'];
        $this->_params['pageTitle'] = $productTypeTitle;
        $this->_params['maxPage'] = $container['maxPage'];
        $this->_params['page'] = $container['page'];
        $this->_params['getParameters'] = $container['getParameters'];
        $this->_params['css'][] = 'products';
        $this->_params['js'][] = 'products';
        if($filter != null)
        {
            $this->_params['minPrice'] = $filter['minPrice'];
            $this->_params['maxPrice'] = $filter['maxPrice'];
            $this->_params['filter'] = $filter['filter'];
        }
    }
    
    /**
     * this action shows one product in detail
     */
    public function actionItem()
    {
        $productId = $_GET['id'] ?? null;
        $productId = htmlspecialchars($productId);
        $product = Product::getProductById($productId);
        
        //check if product exists
        if($product === null)
        {
            header('Location: index.php');
        }

        //when the 'In Den Einkaufswagen' button is clicked
        if(isset($_POST['addToCart']))
        {
            if(intval($_POST['count']) > 0)
            {
                // if user is logged in, use shopping cart stored in database
                if($_SESSION['loggedIn'] === true)
                {
                    if(isset($_SESSION['shoppingCartId']))
                    {
                        $shoppingCart = Order::getOrderById($_SESSION['shoppingCartId']);
                    }
                    else
                    {
                        $shoppingCart = new Order($_SESSION['userId']);
                        $shoppingCart->insert();
                        $_SESSION['shoppingCartId'] = $shoppingCart->orderId;
                    }
                    $products[$productId] = intval($_POST['count']);
                    $shoppingCart->addProducts($products);
                }
                else
                {
                    $shoppingCart = isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : array();
                    if(array_key_exists($productId, $shoppingCart))
                    {
                        $shoppingCart[$productId] = intval($shoppingCart[$productId]) + intval($_POST['count']);
                    }
                    else
                    {
                        $shoppingCart[$productId] = intval($_POST['count']);
                    }
                    $_SESSION['shoppingCart'] = $shoppingCart;
                }
                $_SESSION['shoppingCartCount'] += intval($_POST['count']);
                header('Location: index.php?a=shoppingCart');
                exit(0);
            }
        }
        
        $properties = $product->getAllProperties();

        // load all pictures in an array
        $mainImage = isset($properties['mainPicture']) && !is_array($properties['mainPicture']) ? $properties['mainPicture'] : 'placeholder.png';
        $imageProperties[] = $mainImage;
        $extraImages = isset($properties['pictures']) ? $properties['pictures'] : null;
        if ($extraImages !== null)
        {
            $imageProperties = array_merge($images, $extraImages);
        }
        $images = array();
        foreach($imageProperties as $imageProperty)
        {
            $images[] = $imageProperty->value;
        }

        //load all properties in array which should be shown in product view
        $propertyBlacklist = Property::SPECIAL_PROPERTIES;
        foreach($properties as $propertyType => $property)
        {
            //ignore all blacklisted properties
            if(!in_array($propertyType, $propertyBlacklist))
            {
                if(is_array($property))
                {
                    if(count($property) > 0)
                    {
                        $propName = $property[0]->name;
                        $shownProperties[$propName] = '';
                        foreach($property as $prop)
                        {
                            $shownProperties[$propName] .= ', ' . $prop->value;
                        }
                        $shownProperties[$propName] = substr($shownProperties[$propName], 2);
                    }
                }
                else
                {
                    $shownProperties[$property->name] = $property->value;
                }
            }
        }

        //check how many items of that product we have and set an appropiate variable
        $criticalStock = 5;
        if(intval($product->onStock) > $criticalStock)
        {
            $onStockState = 'available';
        }
        else if (intval($product->onStock) > 0)
        {
            $onStockState = 'lowOnStock';
        }
        else
        {
            $onStockState = 'outOfStock';
        }
        

        $this->_params['title'] = 'SI | ' . $product->name;
        $this->_params['product'] =  $product;
        $this->_params['images'] = $images;
        $this->_params['properties'] = $shownProperties;
        $this->_params['css'][] = 'product';
        $this->_params['onStockState'] = $onStockState;


    }

    

}