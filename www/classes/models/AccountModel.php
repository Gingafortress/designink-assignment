<?php

class AccountModel extends Model {


	public function getAllUsernames() {

		return $this->dbc->query( "SELECT Username, Privilege, Active FROM users" );
	}
	public function checkPassword( $password ) {

		// Get the username of the person who is logged in
		$username = $_SESSION['username'];

		// Get the password of the account that is logged in
		$result = $this->dbc->query("SELECT Password FROM users WHERE Username = '$username'");

		// Convert into an associative array
		$data = $result->fetch_assoc();

		// Need the password compat library
		require 'vendor/password.php';

		// Compare the current password against user existing password
		if( password_verify($password, $data['Password']) ) {
			return true;
		} else {
			return false;
		}
	}
	public function updatePassword() {

		// Get the username of the person logged in
		$username = $_SESSION['username'];

		// Hash the new password
		require 'vendor/password.php';
		$hashedPassword = password_hash($_POST['new-password'], PASSWORD_BCRYPT);

		// Prepare UPDATE SQL
		$sql = "UPDATE users SET Password = '$hashedPassword' WHERE Username = '$username'";

		// Run the SQL
		$this->dbc->query($sql);

		// Ensure the password update worked
		if( $this->dbc->affected_rows != 0 ) {
			return true;
		} else {
			return false;
		}
	}
	public function checkPrivilege() {

		//get username  of person selected
		$username = $_SESSION['username'];	
		// Get the privilege of the account that is logged in
		$result = $this->dbc->query("SELECT Privilege FROM users WHERE Username = '$username'");

		//Run the sql
		$this->dbc->query($sql);

		// Ensure the password update worked
		if( $this->dbc->affected_rows != 0 ) {
			return true;
		} else {
			return false;
		}
	}
	public function deactivateAccount() {

		//get username  of person selected
		$user = $_POST['active-user-dropdown'];
	
		$this->dbc->query("UPDATE users SET Active = 'inactive' WHERE Username = '$user'");
	}
	public function activateAccount() {

		//get username  of person selected
		$userDisabled = $_POST['inactive-user-dropdown'];
		
		$this->dbc->query("UPDATE users SET Active = 'active' WHERE Username = '$userDisabled'");
	}
	public function addedInfo() {
		//Get the userID
		$userID = $_SESSION['userID'];

		//Query to see if there is existing info in the database
		$sql = "SELECT FirstName, LastName, ProfileImage, Bio
				FROM users_added_info
				WHERE UsersID = $userID";
		//run the sql
		$result = $this->dbc->query($sql);

		//Filter the user data
		$firstName 	= $this->filter($_POST['first-name']);
		$lastName 	= $this->filter($_POST['last-name']);
		$bio		= $this->filter($_POST['bio']);
		

		// if there is a result then do a update
		if($result->num_rows == 1) {

			//if user has provided an image 
			if(isset($_POST['newUserImage']) ) {
				$image = $this->filter($_POST['newUserImage']);
				//convert the result into associative array

				$data = $result->fetch_assoc();
				if($data['ProfileImage'] != 'octopus.jpg') {
					//Delete the old images
					unlink('img/profile-images/original/'.$data['ProfileImage']);
					unlink('img/profile-images/avatar/'.$data['ProfileImage']);
					unlink('img/profile-images/icon/'.$data['ProfileImage']);
				}
			} else { 
				//convert the result into associative array
				$data = $result->fetch_assoc();
				//No new image
				$image = $data['ProfileImage'];

			}
			//UPDATE
			$sql = "UPDATE users_added_info
					SET FirstName 		= '$firstName', 
						LastName  		= '$lastName', 
						ProfileImage	= '$image',
						Bio 	  		= '$bio'
					WHERE UsersID  		= '$userID'";
			
		
		} elseif ($result->num_rows == 0) {
			
			//if there is newUserImage then an image is provided
			if(isset($_POST['newUserImage']) ) {
				$image = $this->filter($_POST['newUserImage']);
			} else { 
				$image = 'octopus.jpg';
			}
			//INSERT
			$sql = "INSERT INTO users_added_info
					VALUES (NULL, $userID, '$firstName','$lastName','$image','$bio')";
		}

		//run sql
		$this->dbc->query($sql);

		//if the query failed
		if($this->dbc->affected_rows == 1 ) {
			return true;
		} 
		return false;
	}
	public function getAddedInfo() {
		return $this->dbc-> query("	SELECT FirstName, LastName, Bio, ProfileImage 
									FROM users_added_info 
									WHERE UsersID = ".$_SESSION['userID']);
	}
	public function getAllTypes() {

		return $this->dbc->query("SELECT ID, Types FROM types ORDER BY Types ASC");
	}
	public function getAllTags() {

		return $this->dbc->query("SELECT ID, Tags FROM tags ORDER BY Tags ASC");
	}
	public function checkTagExists(){

		$tag = $this->filter($_POST['add-tag']);

		$sql = "SELECT Tags FROM tags WHERE Tags = '$tag' ";

		$result = $this->dbc->query($sql);

		if( $result->num_rows > 0 ) {
			return true;
		} else {
			return false;
		}
	}
	public function checkFileTypeExists(){
		
		$fileType = $this->filter($_POST['add-file-type']);

		$sql = "SELECT Types FROM types WHERE Types = '$fileType' ";

		$result = $this->dbc->query($sql);

		if( $result->num_rows > 0 ) {
			return true;
		} else {
			return false;
		}
	}
	public function addTag() {
		
		$tag = $this->filter($_POST['add-tag']);
		
		$sql = "INSERT INTO tags VALUES (NULL, '$tag')";
		
		$this->dbc->query($sql);
		
		if($this->dbc->affected_rows == 0) {
			return false; //Failed
		} else {
			return true; //Success
		}
	}
	public function addFileType() {
		
		$fileType = $this->filter($_POST['add-file-type']);
		
		$sql = "INSERT INTO types VALUES (NULL, '$fileType')";
		
		$this->dbc->query($sql);
		
		if($this->dbc->affected_rows == 0) {
			return false; //Failed
		} else {
			return true; //Success
		}
	}
	public function deleteTag() {
		$tagID = $_POST['delete-tag-dropdown'];

		$sql = "DELETE FROM tags
				WHERE ID= '$tagID'";
		
		$this->dbc->query($sql);

		if($this->dbc->affected_rows == 1) {
			return true; 
		} else {
			return false; 
		}
	}
	public function deleteFileType() {
		$fileTypeID = $_POST['delete-file-type-dropdown'];

		$sql = "DELETE FROM tags
				WHERE ID= '$fileTypeID'";
		
		$this->dbc->query($sql);

		if($this->dbc->affected_rows == 1) {
			return true; 
		} else {
			return false; 
		}
	}
	public function uploadFile() {
		
		$fileName 			= $this->filter($_POST['file-name']);
		$fileDescription 	= $this->filter($_POST['file-description']);
		$imageName			= $this->filter($_POST['fileImageName']);
		// $file 				= $this->filter($file);
		$userID  			= $this->filter($_SESSION['userID']);
		$fileType 			= $this->filter($_POST['file-type-upload-dropdown']);
		
		$sql = "INSERT INTO file 
				VALUES (NULL, '$userID' , '$fileName', '$fileDescription', '$imageName', ' ', CURRENT_TIMESTAMP)";
		// Get the ID of the brand new file
		// We will use this to associate tags
		$this->dbc->query($sql);
		$fileID = $this->dbc->insert_id;
		// Loop through each tag
		foreach( $_POST['tag-checkbox'] as $tagsID ) {
			// Filter the ID just in case the user has tampered with it
			$tagsID = $this->filter($tagsID);
			// Prepare SQL
			$sql = "INSERT INTO file_tags VALUES (NULL, '$tagsID', '$fileID')";
			// Run the query
			$this->dbc->query($sql);
		}
		$sql = "INSERT INTO file_types VALUES (NULL, '$fileID', '$fileType')";
		$this->dbc->query($sql);
		if($this->dbc->affected_rows == 0)	{
			return false;
		}
		return true;
	}
	public function getUserFileInfo() {
		$userID = $_SESSION['userID'];
				
		// Prepare SQL
		$sql = ("SELECT file.ID AS ID, file.UsersID AS UsersID, FileImage, file.CreationDate
				FROM file 
				JOIN users  
				ON users.ID = file.UsersID
				WHERE UsersID = $userID
				ORDER BY file.CreationDate");
		
		// Run the query
		
		$result = $this->dbc->query($sql);

		return $result;
	}
}





















