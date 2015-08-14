<?php

class Page {

	//Properties
	public $model;

	// constructor
	public function __construct( $model ) {
		$this->model = $model;

		// Get page data
		$this->model->getPageInfo();

	}

	//Build the header HTML
	public function headerHTML() {
		//include the header.php file
		include 'templates/header.php';
	}

	//Build the footer HTML
	public function footerHTML() {
		//include the footer.php file
		include 'templates/footer.php';
	}

	public function foundationAlert($message, $type) {
		if($message == '') { return; }
		echo '<small class="alert-box '.$type.' ">';
		echo $message;
		echo'</small>';
	}
}