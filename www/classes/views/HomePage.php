<?php

//Class specifically for the home page
//based off the Page class
class HomePage extends Page {
	
	public function __construct($model) {
		parent::__construct($model);
	}
	//Method to show the content for the home page
	public function contentHTML() {
		//Show call to action
		include 'templates/home/home.php';
	}
}