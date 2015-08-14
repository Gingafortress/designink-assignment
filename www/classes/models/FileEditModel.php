<?php

class FileEditModel extends Model {

	public function getFileInfo() {

		// Filter the ID
		$fileID = $this->filter($_GET['fileid']);

		// Make sure the dealID is a number
		if( !is_numeric($fileID) ) {
			// ID is not a number. It has been tampered with
			return false;
		}
		// Prepare SQL
		$sql = "SELECT 
					file.ID AS ID, UsersID, FileName, FileDescription, FileImage, UserName
				FROM 
					file
				JOIN 
					users 
				ON 
					Users.ID = file.UsersID
				WHERE 
					file.ID = $fileID";
		
		// Run the query
		$result = $this->dbc->query($sql);

		// If there is a result
		if( $result->num_rows == 1 ) {
			return $result->fetch_assoc();
		} else {
			// Either the deal didn't exist or the ID was tampered with
			return false;
		}
	}
	public function getFileTags() {
	

		// Filter the ID
		$fileID = $this->filter($_GET['fileid']);
		// Make sure the fileID is a number
		if( !is_numeric($fileID) ) {
			// ID is not a number. It has been tampered with
			return false;
		}
		// Prepare SQL
		$sql = "SELECT Tags, tags.ID
				FROM tags
				JOIN file_tags
				ON tags.ID = TagsID
				WHERE FileID = $fileID";

		// Run the query
		$result = $this->dbc->query($sql);

		return $result;
	}
	public function getFileType() {
		// Filter the ID
		$fileID = $this->filter($_GET['fileid']);
		// Make sure the fileID is a number
		if( !is_numeric($fileID) ) {
			// ID is not a number. It has been tampered with
			return false;
		}
		// Prepare SQL
		$sql = "SELECT Types, types.ID
				FROM types
				JOIN file_types
				ON types.ID = TypeID
				WHERE FileID = $fileID";
		
		// Run the query
		$result = $this->dbc->query($sql);

		return $result->fetch_assoc();
	}
	public function getAllTypes() {
		return $this->dbc->query("SELECT ID, Types FROM types ORDER BY Types ASC");
	}
	public function getAllTags() {
		return $this->dbc->query("SELECT ID, Tags FROM tags ORDER BY Tags ASC");
	}
	public function editFile() {
		//Get the userID
		$userID = $_SESSION['userID'];
		$fileID = $this->filter($_GET['fileid']);
		if( !is_numeric($fileID) ) {
			// ID is not a number. It has been tampered with
			return false;
		}
		//Query to see if there is existing info in the database
		$sql = "SELECT ID, FileName, FileDescription, FileImage
				FROM file
				WHERE ID = $fileID";
		//run the sql
		$result = $this->dbc->query($sql);
		//Filter the user data
		$fileName 	= $this->filter($_POST['file-name-update']);
		$description 	= $this->filter($_POST['file-description-update']);
		
		// if there is a result then do a update
		if($result->num_rows == 1) {
			//if user has provided an image 
			if(isset($_POST['newFileImage']) ) {
				$image = $this->filter($_POST['newFileImage']);
				//convert the result into associative array
				$data = $result->fetch_assoc();
				if($data['FileImage'] != 'octopus.jpg') {
					//Delete the old images
					unlink('img/file-images/original/'.$data['FileImage']);
					unlink('img/file-images/preview/'.$data['FileImage']);
					unlink('img/file-images/thumbnail/'.$data['FileImage']);
				}
			} else { 
				//convert the result into associative array
				$data = $result->fetch_assoc();
				//No new image
				$image = $data['FileImage'];
			}
			//UPDATE
			$sql = "UPDATE 
						file
					SET 
						FileName 		= '$fileName', 
						FileDescription = '$description', 
						FileImage		= '$image',
					WHERE 
						UsersID = '$userID'";
		}
		//run sql
		$this->dbc->query($sql);

		//if the query failed
		if($this->dbc->affected_rows == 1 ) {
			return true;
		} 
		return false;
	}
}