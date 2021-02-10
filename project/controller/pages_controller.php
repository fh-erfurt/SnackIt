<?php


require_once 'models/product.class.php';


class PagesController extends Controller
{

	public function actionIndex()
	{

	header('Location: index.php?c=accounts&a=login');

	}

	public function actionLogin()
	{
		$this->params['title'] = 'Login';

		// store error message
		$errMsg =null;

		// retrieve inputs 
		$email = isset($_POST['email']) ? $_POST['email'] : 'fehler';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		
		// check user send login field
		if(isset($_POST['submitBtn']))
		{
			
			if(validateAccount($email, $password))
			{
				
				$_SESSION['loggedIn'] = true;
                $_SESSION['AccountID'] = getAccountIdByEmail($email);
				header('Location: index.php');
			}
			else{
				$errMsg = "Passwort und Email stimmt nicht überein";
				$_SESSION['loggedIn'] = false;
			}
			
		}
			

		// if there is no error reset mail
		if($errMsg === null)
		{
			$email = '';
		}

		// set param username to prefill login input field
		$this->params['email'] = $email;
		$this->params['errMsg'] = $errMsg;
	}

	public function actionRegister()
	{
		$this->params['title'] = 'Registrierung';
		$this->params['ErrorMsg'] = null;
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
		{
			if(isset($_POST['submit']))
			{
				$input['email']    = htmlspecialchars($_POST['email']) ?? null;
				$input['password'] = htmlspecialchars($_POST['password']) ?? null;
				$input['password2'] = htmlspecialchars($_POST['password2']) ?? null;
				$input['firstname'] = htmlspecialchars($_POST['firstname']) ?? null;
				$input['lastname'] = htmlspecialchars($_POST['lastname']) ?? null;
				$input['country'] = htmlspecialchars($_POST['country']) ?? null;
				$input['zipcode'] = htmlspecialchars($_POST['zipcode']) ?? null;
				$input['city'] = htmlspecialchars($_POST['city']) ?? null;
				$input['street'] = htmlspecialchars($_POST['street']) ?? null;
				$input['number'] = htmlspecialchars($_POST['number']) ?? null;

				//passwords should be the same
				if($input['password'] == $input['password2'])
				{
					if(!containsNullValue($input))
					{
					
						$this->params['ErrorMsg'] = insertnewAccount($input['email'], $input['password'], $input['password2'], $input['firstname'], $input['lastname'], $input['country'],
											$input['zipcode'], $input['city'], $input['street'], $input['number']);
					
					
					
					}
				}
				else
				{
					$this->params['ErrorMsg'] = 'Passwörter stimmen nicht überein';
				}
			}
		
		}
		
	}
	

	public function actionLogout()
	{
		session_destroy();
		header('Location: index.php?c=pages&a=login');
	}
	
	public function actionAgb()
	{
		$this->params['title'] = 'AGB';
	}
	
	public function actionStartseite()
	{
		$this->params['title'] = 'Alles was du brauchst!';
	}
	
	public function actionSnacks()
	{
	$this->params['title'] = 'Snacks';	

	$typeSnacks=0;
	$products = Product::getProductsByType($typeSnacks);
	$this->params['products'] = $products;
	}

	public function actionGetränke()
	{
		$this->params['title'] = 'Getränke';
    }
	
	public function actionAngebote()
	{
	$this->params['title'] = 'Angebote';	
	}
}