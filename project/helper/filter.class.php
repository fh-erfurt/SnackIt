<?php

namespace de\pc4u\helper;

require_once __DIR__.'/../models/account.class.php';
require_once __DIR__.'/../models/address.class.php';
require_once __DIR__.'/../models/product.class.php';
use si\models\Account;
use si\models\Address;
use si\models\Product;

class Filter{

    /**
     * return the Filter to be displayed
     * the return value is an assiative array in the following form:
     *  'maxprice' : maximum price of the products
     *  'minprice' : minimum price of the products
     *  'filter : {
     *      key of array: type of property
     *      value of array: {
     *          'name': property name
     *          'type': property type 
     *          'items' : {
     *              property id: property value
     *          }
     *      }
     *  }
     */
    public static function getFilterByCategory($category)
    {
        $searchProperties = \parse_ini_file('config/searchProperties.ini', true);
        if(isset($searchProperties[$category]))
        {
            if($category == 'featured')
            {
                $products = Product::getFeaturedProducts();
            }
            else
            {
                $products = Product::getProductsByType($category);
            }
            if(count($products) == 0)
            {
                return null;
            }

            $getPrice = function($products) { return $products->price; };
            $minPrice = min(array_map($getPrice,$products));
            $maxPrice = max(array_map($getPrice,$products));

            foreach($searchProperties[$category] as $name => $filterType)
            {
                if($name == 'productType')
                {
                    $productTypes = \parse_ini_file('config/productTypeMapping.ini');
                    $filter[$name] = $productTypes;
                }
                else
                {
                    $filter[$name]['filterType'] = $filterType;
                    $filter[$name]['name'] = is_array($products[0]->getProperty($name))? $products[0]->getProperty($name)[0]->name : $products[0]->getProperty($name)->name;
                    $filter[$name]['type'] = is_array($products[0]->getProperty($name))? $products[0]->getProperty($name)[0]->type : $products[0]->getProperty($name)->type;
                    foreach($products as $product)
                    {
                        // get all propertyIds and values of the specific type
                        if(is_array($product->getProperty($name)))
                        {
                            foreach($product->getProperty($name) as $property)
                            {
                                if(!isset($filter[$name]['items'][$property->propertyId]))
                                {
                                    $filter[$name]['items'][$property->propertyId] = $property->value;
                                }
                            }
                        }
                        else
                        {
                            if(!isset($filter[$name]['items'][$product->getProperty($name)->propertyId]))
                            {
                                $filter[$name]['items'][$product->getProperty($name)->propertyId] = $product->getProperty($name)->value;
                            }
                        }
                    }
                }
            }

            $result['minPrice'] = $minPrice;
            $result['maxPrice'] = $maxPrice;
            $result['filter'] = $filter ?? null;
            return $result;
        }
        else
        {
            return null;
        }
    }

    /**
     * applies the filter specified by GET Parameter
     * returns a filtered product list of the given product list
     */
    public static function applyFilter($products)
    {
        // filter name
        if(isset($_GET['name']) && $_GET['name'] != '')
        {
            $nameToFilter = $_GET['name'];
            $filterByName = function($product) use($nameToFilter)
            {
                return (strpos(strtolower($product->name), $nameToFilter) !== FALSE);
            };
            $products = array_filter($products, $filterByName);
        }

        // filter price
        if(isset($_GET['minPrice']) && is_numeric($_GET['minPrice']))
        {
            $minPrice = $_GET['minPrice'];
            $filterByMinPrice = function($product) use($minPrice)
            {
                return floatval($product->price) >= floatval($minPrice);
            };
            $products = array_filter($products, $filterByMinPrice);
        }
        if(isset($_GET['maxPrice']) && is_numeric($_GET['maxPrice']))
        {
            $maxPrice = $_GET['maxPrice'];
            $filterByMaxPrice = function($product) use($maxPrice)
            {
                return floatval($product->price) <= floatval($maxPrice);
            };
            $products = array_filter($products, $filterByMaxPrice);
        }

        // filter productType
        if(isset($_GET['productType']))
        {
            $prodTypes = $_GET['productType'];
            if(!is_array($prodTypes))
            {
                $prodTypes = array($prodTypes);
            }
            $typeToId = function($type)
            {
                return Product::PRODUCT_TYPES[$type];
            };
            $prodTypes = array_map($typeToId, $prodTypes);
            $filterByType = function($product) use($prodTypes)
            {
                return in_array($product->prodType, $prodTypes);
            };
            $products = array_filter($products, $filterByType);
        }

        // filter onStock
        if(isset($_GET['onStock']))
        {
            $filterByOnStock = function($product)
            {
                return intval($product->onStock) > 0;
            };
            $products = array_filter($products, $filterByOnStock);
        }
        
        // filter searchProperties
        $searchProperties = \parse_ini_file('config/searchProperties.ini');
        foreach($_GET as $filterName => $filterValue)
        {
            // check if $_GET parameter is in the search properties
            if(array_key_exists($filterName, $searchProperties))
            {
                $filterFunction = function ($product) use ($filterName, $filterValue)
                {
                    $property = $product->getProperty($filterName);
                    if($property !== null)
                    {
                        if(is_array($property))
                        {
                            $result = false;
                            foreach($property as $prop)
                            {
                                debug('check ' . $prop->type);
                                if(is_array($filterValue))
                                {
                                    debug('check ' . $prop->type . ' is in array');
                                    if(in_array($prop->propertyId, $filterValue))
                                    {
                                        debug($prop->type . ' is in array');
                                        $result = true;
                                        break;
                                    }
                                }
                                else
                                {
                                    debug('check ' . $prop->type . ' is value');
                                    if($prop->propertyId == $filterValue)
                                    {
                                        debug($prop->type . ' is value');
                                        $result = true;
                                        break;
                                    }
                                }
                            }
                            return $result;
                        }
                        else
                        {
                            debug('check ' . $property->type);
                            if(is_array($filterValue)) return in_array($property->propertyId, $filterValue);
                            else return ($property->propertyId == $filterValue);
                        }
                    }
                    return false;
                };
                $products = array_filter($products, $filterFunction);
            }
        }
        return $products;
    }
}