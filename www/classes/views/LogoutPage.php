<?php

class LogoutPage extends Page {
	public function __construct($model) {
		parent::__construct($model);

			if( isset($_SESSION['username'] ) ) {
			//remove username and anything else from the session
			unset($_SESSION['username']);
			unset($_SESSION['privilege']);
			unset($_SESSION['userID']);
		}
	}

		public function contentHTML() {
		//Show call to action
		include 'templates/search/searchform.php';
		include 'templates/logout/logout.php';
	}
}