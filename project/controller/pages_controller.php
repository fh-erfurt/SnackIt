<?php


require_once __DIR__.'/../models/product.class.php';


class PagesController extends Controller
{

	public function actionIndex()
	{

	header('Location: index.php?c=accounts&a=login');

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

		// set param username to prefill login input field
		$this->params['username'] = $username;
		$this->params['errMsg'] = $errMsg;
	}

	public function actionRegister()
	{
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
        $typeSnacks=0;
        $products = Product::getProductsByType($typeSnacks);
		$this->params['products'] = $products;
		
    }
	
}