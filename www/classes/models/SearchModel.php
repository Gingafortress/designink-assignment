<?php

class SearchModel extends Model {

	public function search() {

		// Filter the user input
		$query = $this->filter($_GET['query']);

		// Prepare SQL
		$sql = "SELECT ID, FileName, FileDescription, FileImage
				FROM file
				WHERE FileName
				LIKE '%$query%'";

		// Run the query
		$result = $this->dbc->query($sql);

		return $result;
	}
	public function searchByType() {

		// Filter the category ID
		$typeID = $this->filter($_GET['type-id']);

		// Prepare SQL
		$sql = "SELECT ID, FileName, FileDescription, FileImage
				FROM file
				JOIN file_types
				ON file.ID = FileID
				WHERE TypeID = $typeID
				ORDER BY CreationDate";

		// Run the query
		$result = $this->dbc->query($sql);

		return $result;
	}

}