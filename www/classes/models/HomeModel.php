<?php

class HomeModel extends Model {

	// Properties

	// Methods
	public function getLatestFiles() {
		return $this->dbc->query("	SELECT ID, FileName, FileImage 
									FROM file 
									ORDER BY CreationDate 
									DESC LIMIT 10 ");
	}

}