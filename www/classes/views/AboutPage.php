<?php

class AboutPage extends Page {
	public function __construct($model) {
		parent::__construct($model);
	}
	public function contentHTML() {
		include 'templates/search/searchform.php';
		include 'templates/about/about.php';
	}
}