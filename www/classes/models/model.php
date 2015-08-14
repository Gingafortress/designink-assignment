<?php

class Model {
	//Properties
	protected $dbc;
	public $title;
	public $description;
	//Constructor
	public function __construct() {
		//Connect to the database & save the connection in the property above
		$this->dbc = new mysqli('localhost', 'root', '', 'designink');
	}
	//Methods (functions)
	public function getPageInfo() {
		//Obtain the name of the requested page
		$requestedPage = $_GET['page'];
		//Prepare Query
		$sql = " SELECT Title, Description FROM pages WHERE Name = '$requestedPage' ";
		//Run the query
		$result = $this->dbc->query( $sql );

		//Make sure there is data in the result if not
		//then we need to get 404 data instead
		if( $result->num_rows == 0 ) {

			//Prepare sql to get the 404 data page
			$sql = " SELECT Title, Description FROM pages WHERE Name = '404' ";

			//Run the query
			$result = $this->dbc->query( $sql );
		}
		
		//Convert the reults into an associative array
		$pageData = $result->fetch_assoc();

		//Save the title and description oin the properties above
		$this->title 		= $pageData['Title'];
		$this->description 	= $pageData['Description'];
	}
	protected function filter( $value ) {
		return $this->dbc->real_escape_string( $value );
	}
	
	public function getFileTotal(){
		 return $this->dbc->query("SELECT ID FROM file");
	}
}