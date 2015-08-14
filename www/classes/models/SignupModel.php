<?php

class SignupModel extends Model {

	public function checkUserNameExists( $username) {
		//Filter the username just in case it has malicous code
		$username = $this->dbc->real_escape_string( $username );
		//Prepare sql
		$sql = "SELECT UserName FROM users WHERE UserName = '$username' ";
		//Run the query
		$result = $this->dbc->query($sql);
		//If there is a result
		if( $result->num_rows > 0 ) {
			return true;
		} else {
			//Account with that username does not exist
			return false;
		}
	}

	public function checkEmailExists( $email ) {

		// Filter email address
		$email = $this->dbc->real_escape_string( $email );

		//Prepare sql
		$sql = "SELECT UserName FROM users WHERE Email = '$email' ";

		//Run the query
		$result = $this->dbc->query($sql);

		return $result->num_rows ? true : false;
		//     OR
		// //If there is a result
		// if( $result->num_rows ) {
		// 	return true;
		// } else {
		// 	//Account with that email does not exist
		// 	return false;
		// }

	}
	public function registerNewAccount( $username, $email, $password) {

		// Filter the Data
		$username = $this->filter( $username );
		$email = $this->filter( $email );

		//Hash the password
		require 'vendor/password.php';

		$hashedPassword = password_hash( $password, PASSWORD_BCRYPT );


		//prepare SQL for insert
		$sql = "INSERT INTO users VALUES (NULL,'$username', '$hashedPassword', '$email', 'user', CURRENT_TIMESTAMP,'enabled' )";

		//Run the sql
		$this->dbc->query($sql);

		//Get the id of the brand new user
		$userID = $this->dbc->insert_id;
		

		//Validate the account creation


		//Log user in by saving their details into the session
		$_SESSION['username'] 	= $username;
		$_SESSION['privilege'] 	= 'user';
		$_SESSION['userID']		= $userID;
	}
}











