<?php
class ImageUploader {
	//Properties
	private $imageName;
	private $imageType;
	private $imageSize;
	private $imageError;
	private $imageTemp;
	private $inputName;
	private $destination;
	public 	$errorMessage;
	private $imageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif','image/zip'];

	//Function to send back image name
	public function getImageName() { return $this->imageName; }
	//Methods (functions)
	public function upload($inputName, $destination, $newFileName = '') {

		//extract the information about the image
		$this->imageName 	= $_FILES[$inputName] ['name'];
		$this->imageType 	= $_FILES[$inputName] ['type'];
		$this->imageSize 	= $_FILES[$inputName] ['size'];
		$this->imageError 	= $_FILES[$inputName] ['error'];
		$this->imageTemp 	= $_FILES[$inputName] ['tmp_name'];

		$this->inputName 	= $inputName;
		$this->destination 	= $destination;

		//Show the max file size if needed
		if( $_POST['MAX_FILE_SIZE'] < 1000 ) {
			$maxsize = $_POST ['MAX_FILE_SIZE'].' bytes';
		}elseif($_POST['MAX_FILE_SIZE'] < 1000000){
			$maxsize = ($_POST ['MAX_FILE_SIZE'] /1000).' Kilobytes';
		}else {
			$maxsize = ($_POST ['MAX_FILE_SIZE'] /1000000).' Megabytes';
		}	

		


		switch( $this->imageError ) {
			case 1:	$this->errorMessage = 'Image too large for server.'; 				break;
			case 2: $this->errorMessage = 'Image size exceeds form file size limit of '.$maxsize; 	break;
			case 3: $this->errorMessage = 'Image only partially uploaded.'; 			break;
			case 4: $this->errorMessage = 'Image failed to load / No image selected.'; 	break;
		}
			//If an error occured
		if( $this->errorMessage != '') {
			return false;
		}

		//Validation
		if( !in_array($this->imageType, $this->imageTypes) ) {
			$this->errorMessage = 'Invalid file type';
			return false;
		}

		//generate unique id to be used on the file name
		$unique = uniqid('', true);
		//If a new file name has been provided
		if( $newFileName == '') {
			$this->imageName = $unique.$this->imageName;
		} else {
			//Get the file extension of the image
			$fileExtension = pathinfo($this->imageName, PATHINFO_EXTENSION);
			$this->imageName = $unique.$newFileName.'.'.$fileExtension;
		}

		//move image fom temp to final destination
		move_uploaded_file($this->imageTemp, $this->destination.$this->imageName);

		//If the file did not make it to the final destination
		if(!file_exists($this->destination.$this->imageName) ) {
			$this->errorMessage = 'Could not move image to final destination. ';
			return false;
		}
		//Everything is done
		return true;
	}

	public function resize($originalFileLocation, $newWidth, $destination, $imageName) {
		
		//Get the mime type
		$mime = mime_content_type($originalFileLocation);
		
		switch( $mime ) {
			
			case 'image/jpeg':
				$originalImage = imagecreatefromjpeg( $originalFileLocation );
			break;
				
			case 'image/png':
				$originalImage = imagecreatefrompng( $originalFileLocation );
			break;

			case 'image/gif':
				$originalImage = imagecreatefromgif( $originalFileLocation );
			break;

			default:
				die('not an image');
			break;
		}

		//Get the height of the original image
		$dimensions = getimagesize($originalFileLocation);

		$originalWidth = $dimensions[0];
		$originalHeight = $dimensions[1];

		//Calculate new height
		$newHeight = ($originalHeight / $originalWidth) * $newWidth;

		//create a brand new image
		$newImage = imagecreatetruecolor($newWidth, $newHeight);

		//Copy original image data onto this new smaller image
		imagecopyresampled(	$newImage, $originalImage, 
							0, 0, 
							0, 0, 
							$newWidth, $newHeight, 
							$originalWidth, $originalHeight);

		//Create a file based on the new image
		switch( $mime ) {

			case 'image/jpeg':
				imagejpeg($newImage, $destination.$imageName, 80 );
			break;
			case 'image/png':
				imagejpeg($newImage, $destination.$imageName, 9 );
			break;
			case 'image/gif':
				imagejpeg($newImage, $destination.$imageName);
			break;

		}
		//Delete any trace from the server memory
		imagedestroy($originalImage);
		imagedestroy($newImage);
	}
}
















