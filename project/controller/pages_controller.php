<?php

//Here most of the functions and all variables that the pages use
require_once 'models/product.class.php';
require 'models/order.class.php';
require 'helper/filter.class.php';
require 'models/address.class.php';


class PagesController extends Controller
{

	public function actionIndex()
	{

		header('Location: index.php?c=accounts&a=login');
	}

	public function actionLogin()
	{	//this->params gives the variable to the page
		$this->params['title'] = 'Login';

		$this->params['js'][] = 'test';


		// store error message
		$errMsg = null;

		// retrieve inputs 
		$email = isset($_POST['email']) ? $_POST['email'] : 'fehler';
		$password = isset($_POST['password']) ? $_POST['password'] : '';



		// check user send login field
		if (isset($_POST['submitBtn'])) {


			//set cookie when user sets remember me on login 
			if ($_POST['rememberMe']) {
				$duration = time() + 3600 * 24 * 30;
				setcookie('Email', $email, $duration, '/');
				setcookie('Password', $password, $duration, '/');
			}

			//validates the acc
			if (validateAccount($email, $password)) {

				$_SESSION['loggedIn'] = true;
				$_SESSION['accountId'] = getaccountIdByEmail($email);
				header('Location: index.php');
			} else {
				$errMsg = "Passwort und Email stimmen nicht überein.";
				$_SESSION['loggedIn'] = false;
			}
		}


		// if there is no error reset mail
		if ($errMsg === null) {
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

		if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) {
			if (isset($_POST['submit'])) {
				//gets the variables from the register
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
				if ($input['password'] == $input['password2']) {
					if (!containsNullValue($input)) {
						//inserts the acc
						$this->params['ErrorMsg'] = insertnewAccount(
							$input['email'],
							$input['password'],
							$input['password2'],
							$input['firstname'],
							$input['lastname'],
							$input['country'],
							$input['zipcode'],
							$input['city'],
							$input['street'],
							$input['number']
						);
					}
				} else {
					$this->params['ErrorMsg'] = 'Passwörter stimmen nicht überein.';
				}
			}
		}
	}


	public function actionLogout()
	{
		//destroys session and cookie
		setcookie('Email', '', -1, '/');
		setcookie('Password', '', -1, '/');
		session_destroy();
		header('Location: index.php?c=pages&a=login');
		$_SESSION['loggedIn'] = false;
	}

	public function actionProfil()
	{
		$this->params['title'] = 'Dein Profil';

		$db = $GLOBALS['db'];
		$Account = [];
		//gets the acc from the session
		$Account = getAccountDataById($_SESSION['accountId']);
		$this->params['Account'] = $Account;

		if (isset($_POST['changeEmail'])) {
			$this->params['changeEmail'] = true;
			// there is no need for executing the rest of the function 
			// because the view does not have to know about the user data
			return;
		}

		if (isset($_POST['confirmEmail'])) {
			$newEmail = htmlspecialchars($_POST['NewEmail']) ?? null;
			if (getAccountIdByEmail($newEmail) == null) {

				//change Email

				$sql = 'UPDATE account set Email=(:email) WHERE AccountId =' . $_SESSION['AccountID'];
				$statement = $db->prepare($sql);
				$statement->bindParam(':email', $newEmail);
				$statement->execute();


				$this->params['changeEmail'] = true;
				$this->params['messageType'] = 'success';
				$this->params['message'] = 'Deine Email wurde erfolgreich geändert!';
			} else {
				$this->params['changeEmail'] = true;
				$this->params['messageType'] = 'error';
				$this->params['message'] = 'Diese Email existiert bereits!';
			}
		} else if (isset($_POST['changePassword'])) {
			$this->params['changePassword'] = true;
			// there is no need for executing the rest of the function 
			// because the view does not have to know about the user data
			return;
		}

		if (isset($_POST['changeData'])) {
			$this->params['changeData'] = true;
		} else if (isset($_POST['confirmPassword'])) {
			$oldPassword = htmlspecialchars($_POST['oldPassword']) ?? null;
			$newPassword = htmlspecialchars($_POST['newPassword']) ?? null;
			$newPassword2 = htmlspecialchars($_POST['newPassword2']) ?? null;
			//check old password
			if (validateAccount($Account['Email'], $oldPassword)) {
				//passwords should be the same
				if ($newPassword == $newPassword2) {
					//newPassword should not be null
					if ($newPassword != null) {
						//change password

						$sql = 'UPDATE account set Password=(:password) WHERE AccountId =' . $_SESSION['AccountID'];
						$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
						$statement = $db->prepare($sql);
						$statement->bindParam(':password', $newPassword);

						$statement->execute();


						$this->params['messageType'] = 'success';
						$this->params['message'] = 'Dein Passwort wurde erfolgreich geändert!';
					}
				} else {
					$this->params['changePassword'] = true;
					$this->params['messageType'] = 'error';
					$this->params['message'] = 'Die eingegebenen Passwörter stimmen nicht überein!';
				}
			} else {
				$this->params['changePassword'] = true;
				$this->params['messageType'] = 'error';
				$this->params['message'] = 'Dein aktuelles Passwort ist nicht korrekt!';
			}
		}
	}

	public function actionAgb()
	{
		$this->params['title'] = 'AGB';
	}

	public function actionTest()
	{
		$this->params['title'] = 'AGB';
	}

	public function actionError404()
	{
		$this->params['title'] = 'Error404';
	}

	public function actionDatenschutzerklärung()
	{
		$this->params['title'] = 'Datenschutzerklärung';
	}

	public function actionImpressum()
	{
		$this->params['title'] = 'Datenschutzerklärung';
	}

	public function actionStartseite()
	{
		$this->params['title'] = 'Alles was du brauchst!';

		//autologin over the cookie 
		if (isset($_COOKIE['Email']) && isset($_COOKIE['Password'])) {
			if (validateAccount($_COOKIE['Email'], $_COOKIE['Password'])) {
				$_SESSION['loggedIn'] = true;
				$_SESSION['accountId'] = getaccountIdByEmail($_COOKIE['Email']);
			}
		}
	}

	public function actionSnacks()
	{
		$this->params['title'] = 'Snacks';

		$typeSnacks = 0;
		$products = Product::getProductsByType($typeSnacks);
		$this->params['products'] = $products;
		$this->params['js'][] = 'products';
		if (isset($_POST['salty'])) {
			$typeSalty = 'salty';
			$products = Product::getProductsByPropType($typeSalty, $typeSnacks);
			$this->params['products'] = $products;
		}
		if (isset($_POST['sweet'])) {
			$typeSweet = 'sweet';
			$products = Product::getProductsByPropType($typeSweet, $typeSnacks);
			$this->params['products'] = $products;
		}
		if (isset($_POST['all'])) {
			$products = Product::getProductsByType($typeSnacks);
			$this->params['products'] = $products;
		}


		if (isset($_GET['applyFilter'])) {
			$products = Filter::applyFilter($products);
			$this->params['products'] = $products;
		}

		// dynamically load products
		if (isset($_GET['ajax'])) {
			$productCount = $_GET['productCount'];
			$products = array_slice($products, $productCount, 10);
			$productArray = [];
			foreach ($products as $product) {
				$productArray[] = $product->toArray();
			}
			$result['productCount'] = $productCount;
			$result['products'] = $productArray;
			$result = json_encode($result);
			echo $result;
			exit(0);
		}
	}
	public function actionSnackssweet()
	{
		$this->params['title'] = 'Snacks';

		$typeSnacks = 0;
		$typeSweet = 'sweet';
		$products = Product::getProductsByPropType($typeSweet, $typeSnacks);
		$this->params['products'] = $products;
		$this->params['js'][] = 'products';

		if (isset($_GET['applyFilter'])) {
			$products = Filter::applyFilter($products);
			$this->params['products'] = $products;
		}

		// dynamically load products
		if (isset($_GET['ajax'])) {
			$productCount = $_GET['productCount'];
			$products = array_slice($products, $productCount, 10);
			$productArray = [];
			foreach ($products as $product) {
				$productArray[] = $product->toArray();
			}
			$result['productCount'] = $productCount;
			$result['products'] = $productArray;
			$result = json_encode($result);
			echo $result;
			exit(0);
		}
	}
	public function actionSnackssalty()
	{
		$this->params['title'] = 'Snacks';

		$typeSnacks = 0;
		$typeSalty = 'salty';
		$products = Product::getProductsByPropType($typeSalty, $typeSnacks);
		$this->params['products'] = $products;
		$this->params['js'][] = 'products';

		if (isset($_GET['applyFilter'])) {
			$products = Filter::applyFilter($products);
			$this->params['products'] = $products;
		}

		// dynamically load products
		if (isset($_GET['ajax'])) {
			$productCount = $_GET['productCount'];
			$products = array_slice($products, $productCount, 10);
			$productArray = [];
			foreach ($products as $product) {
				$productArray[] = $product->toArray();
			}
			$result['productCount'] = $productCount;
			$result['products'] = $productArray;
			$result = json_encode($result);
			echo $result;
			exit(0);
		}
	}

	public function actionGetränke()
	{
		$this->params['title'] = 'Getränke';

		$typeDrinks = 1;
		$products = Product::getProductsByType($typeDrinks);
		$this->params['products'] = $products;
		$this->params['js'][] = 'products';

		if (isset($_GET['applyFilter'])) {
			$products = Filter::applyFilter($products);
			$this->params['products'] = $products;
		}

		// dynamically load products
		if (isset($_GET['ajax'])) {
			$productCount = $_GET['productCount'];
			$products = array_slice($products, $productCount, 10);
			$productArray = [];
			foreach ($products as $product) {
				$productArray[] = $product->toArray();
			}
			$result['productCount'] = $productCount;
			$result['products'] = $productArray;
			$result = json_encode($result);
			echo $result;
			exit(0);
		}
	}

	public function actionDokumentation()
	{
		$this->params['title'] = 'Dokumentation';

		$typeDrinks = 1;
		$products = Product::getProductsByType($typeDrinks);
		$this->params['products'] = $products;
	}

	public function actionAngebote()
	{
		$this->params['title'] = 'Angebote';

		$typeSale = 2;
		$products = Product::getProductsByType($typeSale);
		$this->params['products'] = $products;
		$this->params['js'][] = 'products';

		if (isset($_GET['applyFilter'])) {
			$products = Filter::applyFilter($products);
			$this->params['products'] = $products;
		}

		// dynamically load products
		if (isset($_GET['ajax'])) {
			$productCount = $_GET['productCount'];
			$products = array_slice($products, $productCount, 10);
			$productArray = [];
			foreach ($products as $product) {
				$productArray[] = $product->toArray();
			}
			$result['productCount'] = $productCount;
			$result['products'] = $productArray;
			$result = json_encode($result);
			echo $result;
			exit(0);
		}
	}

	public function actionItem()
	{


		$productId = $_GET['id'] ?? null;
		$productId = htmlspecialchars($productId);
		$product = Product::getProductById($productId);
		$this->params['product'] = $product;

		$this->params['title'] = $product->ProdName;


		//when the 'In Den Einkaufswagen' button is clicked
		if (isset($_POST['addToCart'])) {

			if (intval($_POST['count']) > 0) {
				// if user is logged in, use shopping cart stored in database
				if ($_SESSION['loggedIn'] === true) {
					if (isset($_SESSION['shoppingCartId'])) {
						$shoppingCart = Order::getOrderById($_SESSION['shoppingCartId']);
					} else {
						$shoppingCart = new Order($_SESSION['accountId']);
						$shoppingCart->insert();
						$_SESSION['shoppingCartId'] = $shoppingCart->orderId;
					}
					$products[$productId] = intval($_POST['count']);
					$shoppingCart->products = $products;
					$shoppingCart->addProducts($products);
				} else {
					$shoppingCart = isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : array();
					if (array_key_exists($productId, $shoppingCart)) {
						$shoppingCart[$productId] = intval($shoppingCart[$productId]) + intval($_POST['count']);
					} else {
						$shoppingCart[$productId] = intval($_POST['count']);
					}
					$_SESSION['shoppingCart'] = $shoppingCart;
				}
				if (!isset($_SESSION['shoppingCartCount'])) {
					$_SESSION['shoppingCartCount'] = 0;
				}
				$_SESSION['shoppingCartCount'] += intval($_POST['count']);

				header('Location: index.php?a=Startseite');
				exit(0);
			}
		}
	}

	public function actionShoppingCart()
	{
		$this->params['title'] = 'Item';


		if (isset($_SESSION['shoppingCartId'])) {
			// user is logged in -> get shopping cart from DB

			$order = Order::getOrderById($_SESSION['shoppingCartId']);
			$totalPrice = 0;
			foreach ($order->products as $productContainer) {
				$totalPrice += floatval($productContainer['product']->Price) * intval($productContainer['count']);
			}
			$this->params['order'] = $order;
			$this->params['totalPrice'] = $totalPrice;
		} else if (isset($_SESSION['shoppingCart'])) {

			// user is not logged in -> get shopping cart from session
			$products = array();
			$totalPrice = 0;
			foreach ($_SESSION['shoppingCart'] as $id => $count) {
				$product = Product::getProductById($id);
				$products[] = ['product' => $product, 'count' => $count];
				$totalPrice += floatval($product->Price) * intval($count);
			}
			$this->params['products'] = $products;
			$this->params['totalPrice'] = $totalPrice;
		}

		if (isset($_POST['delete'])) {

			$order->deleteProductFromCart($order->orderId, $_POST['productId']);
			$order = Order::getOrderById($_SESSION['shoppingCartId']);
			$totalPrice = 0;
			foreach ($order->products as $productContainer) {
				$totalPrice += floatval($productContainer['product']->Price) * intval($productContainer['count']);
			}
			$this->params['order'] = $order;
			$this->params['totalPrice'] = $totalPrice;
		}

		if (isset($_POST['pay'])) {
			header('Location: index.php?a=Checkout');
		}
	}

	public function actionCheckout()
	{
		$this->params['title'] = 'Checkout';

		if ($_SESSION['loggedIn'] == true) {
			$account = [];
			//gets the acc from the session
			$account = getAccountDataById($_SESSION['accountId']);
			$this->params['account'] = $account;
			$address = [];
			$address = Address::getAddressById($account->addressId);
			$this->params['address'] = $address;
		}
	}
}
