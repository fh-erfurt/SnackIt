<?php

namespace dwp\controller;

require_once 'models/account.class.php';
require_once 'models/address.class.php';
require_once 'helper/helper.php';
use models\Account;
use models\Address;

class AccountsController extends Controller
{
	public function actionLogin()
	{
		$this->_params['title'] = 'SnackIt/Login';
		$this->_params['js'][] = 'login';
		$this->_params['css'][] = 'login';
		$this->_params['css'][] = 'error';

		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
		{
			if(isset($_POST['submitBtn']))
			{
				$email    = htmlspecialchars($_POST['email']) ?? null;
				$password = htmlspecialchars($_POST['password']) ?? null;

				if(Account::validateUser($email, $password))
				{
					$_SESSION['loggedIn'] = true;
					$_SESSION['accountID'] = Account::getUserIdByEmail($email);

					
					saveShoppingCart();
					
					// redirect after login
					if(isset($_SESSION['afterLoginPage']))
					{
						$redirect = $_SESSION['afterLoginPage'];
						unset($_SESSION['afterLoginPage']);
						header('Location: index.php?'.$redirect);
					}
					else
					{
						header('Location: index.php');
					}
				}
				else
				{
					$this->_params['error'] = 'Die E-Mail oder das Passwort ist falsch!';
					$_SESSION['loggedIn'] = false;
				}
			}
		}
		else
		{
			header('Location: index.php');
		}
	}

	public function actionLogout()
	{
		if($_SESSION['loggedIn'] === true)
		{
			$_SESSION['loggedIn'] = false;
			session_destroy();
		}

		header('Location: index.php');
		exit();
	}

	public function actionRegister()
	{
		$this->_params['title'] = 'SnackIt/Registrierung';
		$this->_params['css'][] = 'register';
		$this->_params['css'][] = 'error';

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
					if(!containsNull($input))
					{
						//add user to DB
						$user = new Account($input['firstname'], $input['lastname'], $input['email'], null, 0, $input['password']);
						if($user->insert())
						{
							//add address to DB
							$address = new Address($input['country'], $input['state'], $input['zipcode'], $input['city'], $input['street'], $input['number']);
							$address->insertIfNotExist();

							//set addressId on user
							$user->addressId = $address->addressId;
							$user->updateAddressId();

							//log user in
							$_SESSION['loggedIn'] = true;
							$_SESSION['accountID'] = Account::getUserIdByEmail($user->email);
							
							// save the shopping cart from Session Context to user context
							saveShoppingCart();

							if(isset($_SESSION['afterLoginPage']))
							{
								$redirect = $_SESSION['afterLoginPage'];
								unset($_SESSION['afterLoginPage']);
								header('Location: index.php?'.$redirect);
							}
							else
							{
								header('Location: index.php');
							}
						}
						else
						{
							$this->_params['error'] = 'Die E-Mail Adresse ist bereits vergeben!';
						}
					}
					else
					{
						$this->_params['error'] = 'Bitte alle Felder ausfüllen!';
					}
				}
				else
				{
					$this->_params['error'] = 'Die Passwörter sind nicht identisch!';
				}
			}
		}
		else
		{
			header('Location: index.php');
		}
	}


	public function actionProfile()
	{
		$this->_params['title'] = 'Snackit/Profil';

		if($_SESSION['loggedIn'] === true)
		{
			$user = Account::getUserById($_SESSION['userId']);
			$address = Address::getAddressById($user->addressId);

			if(isset($_POST['changePassword']))
			{
				$this->_params['changePassword'] = true;
				// there is no need for executing the rest of the function 
				// because the view does not have to know about the user data
				return; 
			}
			if(isset($_POST['changeData']))
			{
				$this->_params['changeData'] = true;
			}
			else if(isset($_POST['confirmPassword']))
			{
				$oldPassword = htmlspecialchars($input['oldPassword']) ?? null;
				$newPassword = htmlspecialchars($input['newPassword']) ?? null;
				$newPassword2 = htmlspecialchars($input['newPassword2']) ?? null;
				//check old password
				if(Account::validateUser($user->email, $oldPassword))
				{
					//passwords should be the same
					if($newPassword == $newPassword2)
					{
						//newPassword should not be null
						if($newPassword != null)
						{
							//change password
							$user->password = $newPassword;
							if($user->update())
							{
								$this->_params['messageType'] = 'success';
								$this->_params['message'] = 'Dein Passwort wurde erfolgreich geändert!';
							}
							else
							{
								$this->_params['changePassword'] = true;
								$this->_params['messageType'] = 'error';
								$this->_params['message'] = 'Die E-Mail Adresse ist bereits vergeben!';
							}
						}
						else
						{
							$this->_params['changePassword'] = true;
							$this->_params['messageType'] = 'error';
							$this->_params['message'] = 'Bitte geben Sie ein neues Passwort ein!';
						}
					}
					else
					{
						$this->_params['changePassword'] = true;
						$this->_params['messageType'] = 'error';
						$this->_params['message'] = 'Die eingegebenen Passwörter stimmen nicht überein!';
					}
				}
				else
				{
					$this->_params['changePassword'] = true;
					$this->_params['messageType'] = 'error';
					$this->_params['message'] = 'Dein aktuelles Passwort ist nicht korrekt!';
				}
			}
			
			// if the user wants to save his changed data
			if(isset($_POST['confirmChange']))
			{
				// the data should be kept in the form
				$input['email']    	= htmlspecialchars($_POST['email']) ?? null;
				$input['firstname'] = htmlspecialchars($_POST['firstname']) ?? null;
				$input['lastname'] 	= htmlspecialchars($_POST['lastname']) ?? null;
				$input['country'] 	= htmlspecialchars($_POST['country']) ?? null;
				$input['state'] 	= htmlspecialchars($_POST['state']) ?? null;
				$input['zipcode'] 	= htmlspecialchars($_POST['zipcode']) ?? null;
				$input['city'] 		= htmlspecialchars($_POST['city']) ?? null;
				$input['street'] 	= htmlspecialchars($_POST['street']) ?? null;
				$input['number'] 	= htmlspecialchars($_POST['number']) ?? null;

				if(!containsNull($input))
				{
					$addressChanged = false;
					if( $address->country 	!= $input['country'] ||
						$address->state 	!= $input['state']   ||
						$address->zipcode 	!= $input['zipcode'] ||
						$address->city 		!= $input['city'] 	 ||
						$address->street 	!= $input['street']  ||
						$address->number 	!= $input['number'] )
					{
							$addressChanged = true;
							$address->country 	= $input['country'];
							$address->state 	= $input['state'];
							$address->zipcode 	= $input['zipcode'];
							$address->city 		= $input['city'];
							$address->street 	= $input['street'];
							$address->number 	= $input['number'];
							$addressId = $address->insertIfNotExist();
					}
					$userChanged = false;
					if( $addressChanged ||
						$user->email 		!= $input['email']	   ||
						$user->firstname 	!= $input['firstname'] ||
						$user->lastname 	!= $input['lastname'] )
					{
						$userChanged = true;
						$user->email 		= $input['email'];
						$user->firstname 	= $input['firstname'];
						$user->lastname 	= $input['lastname'];
						if($addressChanged)
						{
							$user->addressId 	= $addressId;
						}
					}
					if($userChanged)
					{
						if($user->update())
						{
							$this->_params['messageType'] = 'success';
							$this->_params['message'] = 'Deine Daten wurden erfolgreich geändert!';
						}
						else
						{
							$this->_params['changeData'] = true;
							$this->_params['messageType'] = 'error';
							$this->_params['message'] = 'Die E-Mail Adresse ist bereits vergeben!';
						}
					}
					else
					{
						$this->_params['changeData'] = true;
						$this->_params['messageType'] = 'error';
						$this->_params['message'] = 'Bitte verändern Sie mindestens ein Feld oder drücken Sie auf "Zurück"!';
					}
				}
				else
				{
					$this->_params['changeData'] = true;
					$this->_params['messageType'] = 'error';
					$this->_params['message'] = 'Leerfelder sind nicht erlaubt!';
				}
				

				if(!isset($userChanged) || !$userChanged)
				{
					$user->firstname 	= $input['firstname'];
					$user->lastname 	= $input['lastname'];
					$user->email 		= $input['email'];
					$address->street 	= $input['street'];
					$address->number 	= $input['number'];
					$address->zipcode 	= $input['zipcode'];
					$address->city 		= $input['city'];
					$address->state 	= $input['state'];
					$address->country 	= $input['country'];
				}
			}

			
			$this->_params['user'] = $user;
			$this->_params['address'] = $address;
			$this->_params['css'][] = 'profile';

		}
		else
		{
			header('Location: index.php');
		}
	}

	

}