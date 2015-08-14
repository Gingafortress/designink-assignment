<?php
//Registration page class
//Can register acounts
//Has a form
class SignupPage extends Page {

	//Properties
	
	private $userName;
	private $email;

	private $userNameError;
	private $emailError;
	private $passwordError;
	
	
	public function contentHTML() {
		include 'templates/search/searchform.php';
		include 'templates/sign-up/signup.php';
	}

	public function __construct($model) {
		//Use the parent constructor code
		parent::__construct($model);
		//Process data
		//If the registration has been submitted
		if( isset( $_POST['create-account'] ) ) {

			$this->processNewAccount();
		}
	}

	public function processNewAccount(){
		
		//make life easier
		$uName = trim($_POST['username']);
		$email = trim($_POST['email']);
		$pass1 =      $_POST['password1'];
		$pass2 =      $_POST['password2'];

		//Save the form data for use later on
		$this->userName = $uName;
		$this->email = $email;
		//Validate username
		if( strlen($uName) > 20 || strlen($uName) < 3 ) {
			$this->userNameError = 'username must be between 3 and 20 characters.';
		} elseif( !preg_match( '/^[a-zA-Z0-9_\-.]{3,20}$/', $uName ) ){
			$this->userNameError = 'Use only letters, numbers, hyphens underscore and periods.';
		} elseif( $this->model->checkUserNameExists( $uName ) ) {
			$this->userNameError = 'Username already in use';
		}

		//Validate the email
		if(strlen($email) < 5 || strlen($email) > 254) {
			$this->emailError = 'email is an invalid length.';
		} elseif( !filter_var($email, FILTER_VALIDATE_EMAIL ) ) {
			$this->emailError = 'Invalid email. example@exampe.com';
		} elseif( $this->model->checkEmailExists( $email )  ) {
			$this->emailError = 'email already in use';
		}

		//Validate the passwords
		if( strlen($pass1) < 8 ) {
			$this->passwordError = 'Passwords must be at least 8 characters.';
		} elseif( $pass1 != $pass2 ) {
			$this->passwordError = 'Passwords do not match.';
		}

		//If there are no errors, then register an account
		if( $this->userNameError == '' && $this->emailError == '' && $this->passwordError == '' ) {
			$this->model->registerNewAccount($uName, $email, $pass1);
	
			//Redirect user
			header('Location: index.php?page=account');
		}
	}
}
















