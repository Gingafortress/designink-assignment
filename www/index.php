<?php

date_default_timezone_set("Pacific/Auckland");
// Start the session
session_start();

//Determine what page the user wants
$_GET['page'] = isset( $_GET['page'] ) ? $_GET['page'] : 'home';

//We need the page class
require 'classes/views/page.php';

// Require the model class
require 'classes/models/Model.php';

// Load the appropriate content
switch( $_GET['page'] ) {
	// Home page
	case 'home':
		require 'classes/models/HomeModel.php';
		require 'classes/views/HomePage.php';

		$model 	= new HomeModel();
		$page 	= new HomePage( $model );
	break;

	case 'about':
		require 'classes/models/AboutModel.php';
		require 'classes/views/AboutPage.php';

		$model 	= new AboutModel();
		$page 	= new AboutPage( $model );

	break;

	case 'contact':
		require 'classes/models/ContactModel.php';
		require 'classes/views/ContactPage.php';

		$model 	= new ContactModel();
		$page 	= new ContactPage( $model);
	break;

	case 'sign-up':
		require 'classes/models/SignupModel.php';
		require 'classes/views/SignupPage.php';

		$model 	= new SignupModel();
		$page 	= new SignupPage( $model);
	break;

	case 'login':
		require 'classes/models/LoginModel.php';
		require 'classes/views/LoginPage.php';

		$model 	= new LoginModel();
		$page 	= new LoginPage( $model);
	break;

	case 'account':
		require 'classes/models/AccountModel.php';
		require 'classes/views/AccountPage.php';

		$model 	= new AccountModel();
		$page 	= new AccountPage( $model);
	break;

	case 'logout':
		require 'classes/models/LogoutModel.php';
		require 'classes/views/LogoutPage.php';

		$model 	= new LogoutModel();
		$page 	= new LogoutPage( $model);
	break;

	case 'file':
		require 'classes/models/FileModel.php';
		require 'classes/views/FilePage.php';

		$model 	= new FileModel();
		$page 	= new FilePage( $model);
	break;

	case 'search':
		require 'classes/models/SearchModel.php';
		require 'classes/views/SearchPage.php';

		$model 	= new SearchModel();
		$page 	= new SearchPage( $model);
	break;

	case 'file-edit':
		require 'classes/models/FileEditModel.php';
		require 'classes/views/FileEditPage.php';

		$model 	= new FileEditModel();
		$page 	= new FileEditPage( $model);
	break;



		//404
	default:
		require 'classes/models/Error404Model.php';
		require 'classes/views/Error404Page.php';
		
		$model 	= new Error404Model();
		$page 	= new Error404Page( $model );
	break;	
}


$page->headerHTML();
$page->contentHTML();
$page->footerHTML();


// // Include the header of the website
// include 'header.php';

// include $pageData['file'];

// // Include the footer content
// include 'footer.php';