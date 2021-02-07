<?php

namespace dwp\controller;

//require_once __DIR__.'/../models/user.class.php';
require_once __DIR__.'/../models/address.class.php';
require_once __DIR__.'/../models/product.class.php';
require_once __DIR__.'/../models/order.class.php';
require_once __DIR__.'/../helper/filter.class.php';
//use models\User.class.php;
use si\models\Address;
use si\models\Product;
use si\models\Order;
use si\helper\Filter;

class PagesController extends Controller
{

	public function actionIndex()
	{

		if($this->loggedIn())
		{
			// TODO: Retrieve account which is logged in
			
			// TODO: Set the correct name of the current user here
			$this->setParam('name', 'unkown');

			// TODO: retrieve and set the marks of the current user
			$this->setParam('marks', []);

		}
		else
		{
			header('Location: index.php?c=accounts&a=login');
		}

	}

	public function actionLogin()
	{
		// store error message
		$errMsg = null;

		// retrieve inputs 
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

		// check user send login field
		if(isset($_POST['submit']))
		{

			// TODO: Validate input first
			// TODO: Check login values with database accounts
			// TODO: Store useful variables into the session like account and also set loggedIn = true
			

			// if there is no error reset mail
			if($errMsg === null)
			{
				$username = '';
			}

		}

		// set param email to prefill login input field
		$this->setParam('username', $username);
		$this->setParam('errMsg', $errMsg);
	}

	public function actionSignup()
	{
		// store error message
		$errMsg = null;

		// TODO: Handle Inputfields for account

		// check user send login field
		if(isset($_POST['submit']))
		{

			// TODO: Validate and create account in database if possible
			

			// if there is no error reset mail
			if($errMsg === null)
			{
				// TODO: Redirect to login
			}

		}

		$this->setParam('errMsg', $errMsg);

		// TODO: Set params for account
		
	}

	public function actionExams()
	{
		// TODO: Check user is logged in
		
		// store error message
		$errMsg = null;

		// TODO: Handle Inputfields

		// check form sent
		if(isset($_POST['submit']))
		{

			// TODO: Validate input
			

			// if there is no error reset mail
			if($errMsg === null)
			{
				// TODO: reset input
			}

		}

		$this->setParam('errMsg', $errMsg);

		// TODO: Set params needed params like all exams with result
		$this->setParam('exams', []);
	}

	public function actionLogout()
	{
		session_destroy();
		header('Location: index.php?c=pages&a=login');
	}
	
	public function actionAgb()
	{
	}
	
	public function actionStartseite()
	{
	}
	
	public function actionList()
	{
		
	}
	
	public function actionSnacks()
	{
		$this->params['title'] = 'SnackIt - Alles was du brauchst!';

		$products = Product::getFeaturedProducts();
		
		$filter = Filter::getFilterByCategory('featured');
		
		if(isset($_GET['applyFilter']))
		{
			$products = Filter::applyFilter($products);
		}

		$container = filterProductsByPages($products);
        
        $this->params['products'] 		= $container['products'];
        $this->params['maxPage'] 		= $container['maxPage'];
        $this->params['page'] 			= $container['page'];
        $this->params['getParameters'] = $container['getParameters'];
        $this->params['pageTitle'] 	= 'Vorgestellte Produkte';
        $this->params['minPrice'] 		= $filter['minPrice'];
        $this->params['maxPrice'] 		= $filter['maxPrice'];
        $this->params['filter'] 		= $filter['filter'];
        $this->params['css'][] 		= 'products';
        $this->params['js'][] 			= 'products';
	}
}