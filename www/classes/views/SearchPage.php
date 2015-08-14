<?php

class SearchPage extends Page {

	private $searchResults;

	public function __construct($model) {
		parent::__construct($model);

		// If the user is searching for deals based on keywords
		if( isset($_GET['query']) ) {
			$this->searchResults = $this->model->search();
		}
		if( isset($_GET['query-all']) ) {
			$this->searchResults = $this->model->search();
		}
		if( isset($_GET['type-id']) ) {
			$this->searchResults = $this->model->searchByType();
		}
		

	}

	public function contentHTML() {
		include 'templates/search/searchform.php';
		include 'templates/search/search.php';
	}
}