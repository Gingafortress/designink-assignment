<?php

class AccountPage extends Page {
	// Properties
	private $existingPasswordError;
	private $newPasswordError;
	private $confirmPasswordError;
	private $passwordChangeSuccess;
	private $passwordChangeFail;
	
	private $adminError;
	private $adminEnableError;
	private $deactivateAccountSuccess;
	private $deactivateAccountFail;
	private $activateAccountSuccess;
	private $activateAccountFail;
		
	private $profileImageError;
	private $firstNameError;
	private $lastNameError;
	private $jobTitleError;
	private $bioError;

	private $firstName;
	private $lastName;
	private $jobTitle;
	private $bio;

	private $staffSuccessMessage;
	private $staffErrorMessage;

	private $totalErrors = 0;

	private $userFirstNameError;
	private $userLastNameError;
	private $userBioError;
	private $userImageError;
	private $userFirstName;
	private $userLastName;
	private $userBio;

	private $userSuccess;
	private $userFail;

	private $addTag;
	private $addTagError;
	private $tagFail;
	private $tagSuccess;
	private $addFileType;
	private $addFileTypeError;
	private $fileTypeFail;
	private $fileTypeSuccess;

	private $deleteTag;
	private $deleteTagError;
	private $deleteTagSuccess;
	private $deleteTagFail;
	private $deleteFileType;
	private $deleteFileTypeError;
	private $deleteFileTypeSuccess;
	private $deleteFileTypeFail;

	private $fileName;
	private $fileNameError;
	private $fileDescription;
	private $fileDescriptionError;
	private $fileImage;
	private $fileImageError;
	private $file;
	private $fileError;
	private $uploadTag;
	private $fileTag = '';
	private $fileType = '';
	private $tagCheckboxError;
	private $FileTypeError;

	private $fileUploadSuccess;
	private $fileUploadFail;

	




	public function __construct($model) {
		parent::__construct($model);

		// If the user has submitted the password change form
		if( isset($_POST['existing-password']) ) {
			$this->processPasswordChange();
		}
		//If the user is inserting additional info
		if(isset($_POST['user-data']) ) {
			$this->processAddedInfo();
		}
		if( isset($_POST['active-user-dropdown']) ) {
			$this->processDeactivateAccount();
		}
		if( isset($_POST['inactive-user-dropdown']) ) {
			$this->processActivateAccount();
		}
		//if the admin has added a staff member
		if( isset($_POST['add-staff'] ) ) {
			$this->processAddStaff();
		}
		//if the add file type form has been submitted
		if(isset($_POST['add-file-type']) ) {
			$this->processAddFileType();
		}
		//if the add tag form has been submitted
		if(isset($_POST['add-tag']) ) {
			$this->processAddTag();
		}
		//if the delete file type form has been submitted
		if(isset($_POST['delete-file-type-dropdown']) ) {
			$this->processDeleteFileType();
		}
		//if the delete tag form has been submitted
		if(isset($_POST['delete-tag-dropdown']) ) {
			$this->processDeleteTag();
		}
		if(isset($_POST['upload-file'])) {
			$this->processUploadFile();
		}
		

	}
	
	public function contentHTML() {
		// Make sure the user is logged in
		// If not then offer them a login or registration link
		if( !isset($_SESSION['username']) ) {
			echo 'You need to be logged in';
			return;
		}
		//include account html
		include 'templates/search/searchform.php';
		include 'templates/account/user-account.php';
		// If user is an admin
		if( $_SESSION['privilege'] == 'admin' ) {
			include 'templates/account/admin-controls.php';
		}
	}
	private function processPasswordChange() {

		$existingPass = $_POST['existing-password'];
		$newPass = $_POST['new-password'];
		$confirmPass = $_POST['confirm-password'];

		// Validate
		if( strlen($existingPass) == 0 ) {
			$this->existingPasswordError = 'Required';
			$this->totalErrors++;
		} elseif( !$this->model->checkPassword($existingPass) ) {
			$this->existingPasswordError = 'Incorrect password';
			$this->totalErrors++;
		}

		if( strlen($newPass) < 8 ) {
			$this->newPasswordError = 'Needs to be more than 8 characters';
			$this->totalErrors++;
		}

		if( strlen($confirmPass) < 8 ) {
			$this->confirmPasswordError = 'Needs to be more than 8 characters';
			$this->totalErrors++;
		} elseif( $confirmPass != $newPass ) {
			$this->confirmPasswordError = 'Does not match the new password';
			$this->totalErrors++;
		}

		// If no errors
		if( $this->totalErrors == 0 ) {

			// Update the password
			$result = $this->model->updatePassword();

			// If updating the password was a success
			if( $result ) {
				$this->passwordChangeSuccess = 'Successfully changed your password!';
			} else {
				$this->passwordChangeFail = 'Something went wrong updating your password...';
			}

		}
	}
	private function processDeactivateAccount() {

		$userAccount = $_POST['active-user-dropdown'];
		if($userAccount == 'admin') {
			$this->adminError = 'cannot delete yourself';
			return;
		} else {
			 $this->model->deactivateAccount();
			 $this->deactivateAccountSuccess = 'Successfully disabled account';
			 // $this->activateAccountSuccess = 'Something went wrong';
		}
	}
	private function processActivateAccount() {

		$disabledAccount = $_POST['inactive-user-dropdown'];

		if($disabledAccount == 'admin') {
			$this->adminEnableError = 'cannot enable yourself';
			return;
		} else {
			 $this->model->activateAccount();
			 $this->activateAccountSuccess = 'Successfully enabled account';
			 // $this->activateAccountFail = 'Something went wrong';
		}
	}
	private function processAddedInfo() {
		$firstName 	= trim($_POST['first-name']);
		$lastName 	= trim($_POST['last-name']);
		$bio 		= trim($_POST['bio']);

		//Validation
		if( strlen($firstName) < 2  ) {
			$this->userFirstNameError = 'Needs to be at least 2 characters';
			$this->totalErrors++;
		} elseif( strlen($firstName) > 20  ){
			$this->userFirstNameError = 'Needs to be at most 20 characters';
			$this->totalErrors++;
		} elseif(!preg_match( '/^[a-zA-Z \-]{2,20}$/', $firstName )) {
			$this->userFirstNameError = 'Can only use characters of the alphabet, spaces and hyphens';
			$this->totalErrors++;
		}
		if( strlen($lastName) < 2  ) {
			$this->userLastNameError = 'Needs to be at least 2 characters';
			$this->totalErrors++;
		} elseif( strlen($lastName) > 20  ){
			$this->userLastNameError = 'Needs to be at most 20 characters';
			$this->totalErrors++;
		} elseif(!preg_match( '/^[a-zA-Z \-]{2,20}$/', $lastName )) {
			$this->userLastNameError = 'Can only use characters of the alphabet, spaces and hyphens';
			$this->totalErrors++;
		}

		if( strlen($bio) > 2000 ) {
			$this->bioError = 'Bio must be at most 200 characters. You have gone over by '.(strlen($this->bio) - 200);
			$this->totalErrors++;
		} elseif( !preg_match('/^[\w.\-\s]{2,200}$/', $bio ) ) {
			$this->bioError = 'Only allowed letters, hyphens, spaces and full stops.';
			$this->totalErrors++;
		}

		//attempt to upload the image
		if($this->totalErrors == 0 && isset($_FILES['profile-image']) && $_FILES['profile-image']['name'] !='') {
			//Require the image uploader
			require_once 'vendor/ImageUploader.php';
			//create instance of the image uploader
			$imageUploader = new ImageUploader();
			//Attempt to upload the image
			$result = $imageUploader->upload('profile-image', 'img/profile-images/original/');
			//if upload was success
			if($result) {
				//get the file name
				$imageName = $imageUploader->getImageName();
				//Prepare the variables
				$fileLocation = "img/profile-images/original/$imageName";
				$avatarDestination = "img/profile-images/avatar/";
				//Make the avatar version
				$imageUploader->resize($fileLocation, 200, $avatarDestination, $imageName );
				//make icon version
				$iconDestination = "img/profile-images/icon/";
				$imageUploader->resize($fileLocation, 32, $iconDestination, $imageName );
				$_POST['newUserImage'] = $imageName;
			} else {
				//Something went wrong
				$this->totalErrors++;
				$this->userImageError = $imageUploader->errorMessage;
			}
		}

		if($this->totalErrors == 0 ) {
			$result = $this->model->addedInfo();
			
			//if result was good
			if($result) {
				$this->userSuccess = 'Successfully updated your info';
			} else {
				$this->userFail = 'Information not updated';
			}
		}
	}
	private function processAddFileType() {

		$fileType = trim($_POST['add-file-type']);
		//Validation
		if( strlen( $fileType ) < 2  ) {
			$this->addFileTypeError = 'Needs to be at least 2 characters';
			$this->totalErrors++;
		} elseif( strlen( $fileType ) > 20  ){
			$this->addFileTypeError = 'Needs to be at most 20 characters';
			$this->totalErrors++;
		} elseif(!preg_match( '/^[a-zA-Z \-]{2,20}$/', $fileType )) {
			$this->addFileTypeError = 'Can only use characters of the alphabet, spaces and hyphens';
			$this->totalErrors++;
		} elseif( $this->model->checkFileTypeExists()) {
			$this->addFileTypeError = 'FileType already exists.';
			$this->totalErrors++;
		}
		if($this->totalErrors == 0 ) {
			$result = $this->model->addFileType();

			//if result was good
			if($result) {
				$this->fileTypeSuccess = 'Successfully added File Type';
			} else {
				$this->fileTypeFail = 'File Type not added';
			}

		}
	}
	private function processAddTag() {
		
		$addTag = trim($_POST['add-tag']);
		//Validation
		if( strlen( $addTag ) < 2  ) {
			$this->addTagError = 'Needs to be at least 2 characters';
			$this->totalErrors++;
		} elseif( strlen( $addTag ) > 20  ){
			$this->addTagError = 'Needs to be at most 20 characters';
			$this->totalErrors++;
		} elseif(!preg_match( '/^[a-zA-Z \-]{2,20}$/', $addTag )) {
			$this->addTagError = 'Can only use characters of the alphabet, spaces and hyphens';
			$this->totalErrors++;
		} elseif( $this->model->checkTagExists()) {
			$this->addTagError = 'tag already exists.';
			$this->totalErrors++;
		}
		if($this->totalErrors == 0 ) {
			$result = $this->model->addTag();
			if($result) {
				$this->tagSuccess = 'Successfully added Tag';
			} else {
				$this->tagFail = 'Tag not added';
			}
		}
	}
	private function processDeleteFileType(){
		$deleteFileType = $_POST['delete-file-type-dropdown'];

		if(is_numeric($deleteFileType)) {
			$result = $this->model->deleteFileType();
			$this->deleteFileTypeSuccess = 'Successfully deleted Tag';
		} else {
			$this->deleteFileTypeFail = 'Failed deleting File Type';
		}
	}
	private function processDeleteTag() {
		$deleteTag = $_POST['delete-tag-dropdown'];

		if(is_numeric($deleteTag)) {
			$result = $this->model->deleteTag();
			$this->deleteTagSuccess = 'Successfully deleted Tag';
		} else {
			$this->deleteTagFail = 'Failed deleting Tag';
		}
	}
	private function processUploadFile(){
		$fileName 			= trim($_POST['file-name']);
		$fileType 			= ($_POST['file-type-upload-dropdown']);
		$fileTag			= ($_POST['tag-checkbox']);
		$fileDescription 	= trim($_POST['file-description']);
		
		$this->fileName = $fileName;
		$this->fileType = $fileType;
		$this->fileTag = $fileTag;
		$this->fileDescription = $fileDescription;

		//Validation
		if( $fileName == '' ) {
			$this->fileNameError = 'Required';
			$this->totalErrors++;
		}elseif( strlen($fileName) > 30 || strlen($fileName) < 3 ) {
			$this->fileNameError = 'Job Title must be between 3 and 30 characters.';
			$this->totalErrors++;
		} elseif( !preg_match( '/^[\w0-9_\-. ]{3,20}$/', $fileName ) ){
			$this->fileNameError = 'Use only letters, numbers, hyphens underscore and periods.';
			$this->totalErrors++;
		}
		$FileType = $_POST['file-type-upload-dropdown'];
		if(!is_numeric($FileType)) {
			$this->totalErrors++;
			$this->FileTypeError = 'Something Wrong';
		}
		if( $fileDescription  == '' ) {
			$this->fileDescriptionError = 'Required';
			$this->totalErrors++;
		}elseif( strlen($fileDescription ) > 2000 || strlen($fileDescription ) < 3 ) {
			$this->fileDescriptionError = 'Job Title must be between 3 and 2000 characters. you have gone over by'.(strlen($fileDescription)-2000);
			$this->totalErrors++;
		} elseif( !preg_match( '/^[\w0-9_\-. ]{3,2000}$/', $fileDescription  ) ){
			$this->fileDescriptionError = 'Use only letters, numbers, hyphens underscore and periods.';
			$this->totalErrors++;
		}
		// Only if the user has seleted some checkboxes
		if( isset($fileTag) ) {
			// Loop through each checkbox and make sure they are a number
			foreach($fileTag as $uploadTag) {
				// If it is not a number
				if( !is_numeric($uploadTag) ) {
					$this->totalErrors++;
					$this->tagCheckboxError = 'Something wrong with checkboxes';
				}
			}
		}
		//attempt to upload the image
		if($this->totalErrors == 0 && isset($_FILES['file-image']) && $_FILES['file-image']['name'] !='') {
			//Require the image uploader
			require_once 'vendor/ImageUploader.php';
			//create instance of the image uploader
			$imageUploader = new ImageUploader();
			//Attempt to upload the image
			$result = $imageUploader->upload('file-image', 'img/file-images/original/');
			//if upload was success
			if($result) {
				//get the file name
				$imageName = $imageUploader->getImageName();
				//Prepare the variables
				$fileLocation = "img/file-images/original/$imageName";
				//Prepare the preview version
				$previewDestination = "img/file-images/preview/";
				$imageUploader->resize($fileLocation, 400, $previewDestination, $imageName );
				//Make the thumbnail version
				$thumbnailDestination = "img/file-images/thumbnail/";
				$imageUploader->resize($fileLocation, 200, $thumbnailDestination, $imageName );
				$_POST['fileImageName'] = $imageName;
			} else {
				//Something went wrong
				$this->totalErrors++;
				$this->fileImageError = $imageUploader->errorMessage;
			}
		}
		if($this->totalErrors == 0 ) {
			$result = $this->model->uploadFile();
			//if result was good
			if($result) {
				$this->fileUploadSuccess = 'Successfully uploaded your file';
			} else {
				$this->fileUploadFail = 'File not uploaded';
			}
		}
	}
}






