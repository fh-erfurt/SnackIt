<?php

require_once __DIR__ . '/../helper/functions.php';
require_once __DIR__ . '/../models/product.class.php';


class Filter
{
    public static function applyFilter($products)
    {

        // filter name
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $nameToFilter = strtolower($_GET['name']);
            $filterByName = function ($product) use ($nameToFilter) {
                return strpos(strtolower($product->ProdName), $nameToFilter) !== FALSE;
            };
            $products = array_filter($products, $filterByName);
        }

        // filter price
        if (isset($_GET['minPrice']) && is_numeric($_GET['minPrice'])) {
            $minPrice = $_GET['minPrice'];
            $filterByMinPrice = function ($product) use ($minPrice) {
                return floatval($product->Price) >= floatval($minPrice);
            };
            $products = array_filter($products, $filterByMinPrice);
        }
        if (isset($_GET['maxPrice']) && is_numeric($_GET['maxPrice'])) {
            $maxPrice = $_GET['maxPrice'];
            $filterByMaxPrice = function ($product) use ($maxPrice) {
                return floatval($product->Price) <= floatval($maxPrice);
            };
            $products = array_filter($products, $filterByMaxPrice);
        }

        // filter onStock
        if (isset($_GET['onStock'])) {
            $filterByOnStock = function ($product) {
                return intval($product->OnStock) > 0;
            };
            $products = array_filter($products, $filterByOnStock);
        }
        return $products;
    }
}
