<?php

class FileModel extends Model {


	public function getLatest5Files() {
		return $this->dbc->query("	SELECT ID, FileName, FileImage 
									FROM file 
									ORDER BY CreationDate 
									DESC LIMIT 10 ");
	}
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
					users.ID = file.UsersID
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
	public function addComment() {
		// Filter the ID
		$fileID = $this->filter($_GET['fileid']);
		$userID = $this->filter($_SESSION['userID']);
		$comment = $this->filter($_POST['comment']);
		if( !is_numeric($fileID) ) {
			return false;
		}

		$sql = "INSERT INTO comments 
				VALUES (NULL, '$fileID', '$userID', '$comment', CURRENT_TIMESTAMP)";
		// die($sql);
		$this->dbc->query($sql);
		if ($this->dbc->affected_rows == 1) {
			return true;
		}
	}
	public function getCommentInfo() {
		$fileID = $this->filter($_GET['fileid']);

		if( !is_numeric($fileID) ) {
			return false;
		}
		$sql = "SELECT comments.ID AS ID, FileID, comments.UsersID, Comment
					
				FROM 
					comments
				JOIN 
					file 
				ON 
					file.ID = comments.FileID
				WHERE 
					comments.fileID = $fileID

				ORDER BY comments.CreationDate";
		
		$result = $this->dbc->query($sql);
		
		return $result;
	}
	public function getCommmentUser() {
		$fileID = $this->filter($_GET['fileid']);

		if( !is_numeric($fileID) ) {
			return false;
		}
		$sql = "SELECT comments.ID AS ID, FileID, comments.UsersID, Comment
					
				FROM 
					comments
				JOIN 
					users 
				ON 
					users.ID = comments.UsersID
				WHERE 
					comments.fileID = $fileID

				ORDER BY comments.CreationDate";
		
		$result = $this->dbc->query($sql);
		
		return $result;
	}
}	