<?php

//Class specifically for the home page
//based off the Page class
class LoginPage extends Page {

	private $loginUsername;
	private $loginPassword;

	private $loginUsernameError;
	private $loginPasswordError;
	private $loginError;




	//Properties
	public function __construct($model) {
		parent::__construct($model);
		//if the user has submitted a form
		if( isset( $_POST['username'] ) ) {
			//process the login form
			$this->processLoginForm();
		}
	}
	
	//Method to show the content for the home page
	public function contentHTML() {
		include 'templates/search/searchform.php';
		include 'templates/login/login.php';
	}

	public function processLoginForm(  ) {

		$loginUsername 	= trim($_POST['username']);
		$loginPassword 	= $_POST['password'];
		
		$this->loginUsername = $loginUsername;

		if($loginUsername == ''){
			$this->loginUsernameError = 'Required';
		}elseif( !$this->model->attemptLogin($loginUsername) ) {
			$this->loginUsernameError = 'Incorrect username';
		}

		if($loginPassword == ''){
			$this->loginPasswordError = 'Required';
		}elseif( !$this->model->attemptLogin($loginPassword) ) {
			$this->loginPasswordError = 'Incorrect password';
		}

		//Use the model to check if the user has the right credentials
		if($this->loginUsernameError == '' && $this->loginPasswordError == '') {
		 $result = $this->model->attemptLogin();

		$this->loginError = $result;
		}
	}
}