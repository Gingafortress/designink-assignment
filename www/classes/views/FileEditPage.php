<?php

class FileEditPage extends Page {

	private $fileNameUpdate;
	private $fileNameUpdateError;
	private $fileDescriptionUpdate;
	private $fileDescriptionUpdateError;
	private $fileImageUpdate;
	private $fileImageUpdateError;
	private $fileUpdate;
	private $fileUpdateError;
	private $tagUpdate;
	private $fileTagUpdate = '';
	private $fileTypeUpdate = '';
	private $tagUpdateError;
	private $fileTypeUpdateError;

	private $fileUpdateSuccess;
	private $fileUpdateFail;

	private $totalErrors = 0;


	public function __construct($model) {
		parent::__construct($model);

		$this->fileInfo = $this->model->getFileInfo();
		$this->fileTags = $this->model->getFileTags();
		$this->fileType = $this->model->getFileType();

		if(isset($_POST['update-file'])) {
			$this->processUpdateFile();
		}
	}

	public function contentHTML() {
		//Show call to action
		if( $this->fileInfo == false ) {
			echo 'Something went wrong';
			return;
		}
		include 'templates/search/searchform.php';
		include 'templates/file/edit-file.php';
	}


	private function processUpdateFile(){
		$fileNameUpdate 			= trim($_POST['file-name']);
		$fileTypeUpdate 			= ($_POST['file-type-upload-dropdown']);
		$fileTagUpdate				= ($_POST['tag-checkbox']);
		$fileDescriptionUpdate 		= trim($_POST['file-description']);
		
		$this->fileNameUpdate = $fileNameUpdate;
		$this->fileTypeUpdate = $fileTypeUpdate;
		$this->fileTagUpdate = $fileTagUpdate;
		$this->fileDescriptionUpdate = $fileDescriptionUpdate;

		//Validation
		if( $fileNameUpdate == '' ) {
			$this->fileNameUpdateError = 'Required';
			$this->totalErrors++;
		}elseif( strlen($fileNameUpdate) > 30 || strlen($fileNameUpdate) < 3 ) {
			$this->fileNameUpdateError = 'Job Title must be between 3 and 30 characters.';
			$this->totalErrors++;
		} elseif( !preg_match( '/^[\w0-9_\-. ]{3,20}$/', $fileNameUpdate ) ){
			$this->fileNameUpdateError = 'Use only letters, numbers, hyphens underscore and periods.';
			$this->totalErrors++;
		}
		$FileTypeUpdate = $_POST['file-type-upload-dropdown'];
		if(!is_numeric($FileTypeUpdate)) {
			$this->fileTypeUpdateError = 'Something Wrong';
			$this->totalErrors++;
		}
		if( $fileDescriptionUpdate  == '' ) {
			$this->fileDescriptionUpdateError = 'Required';
			$this->totalErrors++;
		}elseif( strlen($fileDescriptionUpdate ) > 2000 || strlen($fileDescriptionUpdate ) < 3 ) {
			$this->fileDescriptionUpdateError = 'Job Title must be between 3 and 2000 characters. you have gone over by'.(strlen($fileDescription)-2000);
			$this->totalErrors++;
		} elseif( !preg_match( '/^[\w0-9_\-. ]{3,2000}$/', $fileDescriptionUpdate  ) ){
			$this->fileDescriptionUpdateError = 'Use only letters, numbers, hyphens underscore and periods.';
			$this->totalErrors++;
		}
		// Only if the user has seleted some checkboxes
		if( isset($fileTagUpdate) ) {
			// Loop through each checkbox and make sure they are a number
			foreach($fileTagUpdate as $tagUpdate) {
				// If it is not a number
				if( !is_numeric($uploadTag) ) {
					$this->totalErrors++;
					$this->tagUpdateError = 'Something wrong with checkboxes';
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
				$_POST['newFileImage'] = $imageName;
			} else {
				//Something went wrong
				$this->totalErrors++;
				$this->fileImageUpdateError = $imageUploader->errorMessage;
			}
		}
		if($this->totalErrors == 0 ) {
			$result = $this->model->updateFile();
			//if result was good
			if($result) {
				$this->fileUpdateSuccess = 'Successfully updated your file';
			} else {
				$this->fileUpdateFail = 'File not updated';
			}
		}
	}
}
