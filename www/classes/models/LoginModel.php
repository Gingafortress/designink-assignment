<?php

class LoginModel extends Model {

	public function attemptLogin( ) {
		//extract the data from the POST array
		$username = $_POST['username'];
		$password = $_POST['password'];

		//Filter the data
		$username = $this->dbc->real_escape_string( $username );

		//Prepare the sql to find a user and get the hashed password
		$sql = "SELECT ID, Password, Privilege, Active FROM users WHERE Username = '$username' ";

		//Run the SQL
		$result = $this->dbc->query( $sql );

		//Make sure there is a result
		if( $result->num_rows == 0 ){
			return false;
		}

		//Extract the data from the results
		$data = $result->fetch_assoc();
		
		if($data['Active'] == 'disabled'){
			return 'Your account is disabled';
		}
		//Use the password compat library
		require 'vendor/password.php';

		//compare the passwords
		if (password_verify($password, $data['Password'] ) ){
			//Credentials are correct
			$_SESSION['username'] 	= $username;
			$_SESSION['privilege'] 	= $data['Privilege'];
			$_SESSION['userID']		= $data['ID'];


			// Redirect the user
			header('Location: index.php?page=account');
			echo '<pre>';
			print_r($data);
			die();
		} else {
			return false;
		}
	}
}