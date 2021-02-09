<?php

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
				$input['state'] = htmlspecialchars($_POST['state']) ?? null;
				$input['zipcode'] = htmlspecialchars($_POST['zipcode']) ?? null;
				$input['city'] = htmlspecialchars($_POST['city']) ?? null;
				$input['street'] = htmlspecialchars($_POST['street']) ?? null;
				$input['number'] = htmlspecialchars($_POST['number']) ?? null;

				//passwords should be the same
				if($input['password'] == $input['password2'])
				{
					if(!containsNullValue($input))
					{
					
						insertnewAccount($input['email'], $input['password'], $input['password2'], $input['firstname'], $input['lastname'], $input['country'],
											$input['zipcode'], $input['city'], $input['street'], $input['number']);
					
					}
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

		
	}
}