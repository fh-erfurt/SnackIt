<?php



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
		$this->params['title'] = 'Registrierung';
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