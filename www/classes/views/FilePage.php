<?php

class FilePage extends Page {
	
	private $fileInfo;
	private $comment;
	private $commentError;
	private $commentSuccess;
	private $commentFail;
	private $totalErrors = 0;


	public function __construct($model) {
		parent::__construct($model);

		$this->fileInfo = $this->model->getFileInfo();
		$this->fileTags = $this->model->getFileTags();
		$this->fileType = $this->model->getFileType();
		

		if( isset( $_POST['add-comment'] ) ) {
			//process the login form
			$this->processComment();
		}
	}
			//Method to show the content for the home page
	public function contentHTML() {
		//Show call to action
		if( $this->fileInfo == false ) {
			echo 'Something went wrong';
			return;
		}
		include 'templates/search/searchform.php';
		include 'templates/file/file.php';
	}

	private function processComment(){

		$comment = trim($_POST['comment']);

		if( strlen($comment) > 200 ) {
			$this->commentError = 'comments must be at most 200 characters. You are over by '.(strlen($this->comment) - 200);
			$this->totalErrors++;
		} elseif( !preg_match('/^[\w.\-\s]{2,200}$/', $comment ) ) {
			$this->commentError = 'Only allowed letters, hyphens, spaces and full stops.';
			$this->totalErrors++;
		}

		if($this->totalErrors == 0){
			
			$result = $this->model->addComment();

			if($result) {
				$this->commentSuccess = 'Successfully updated your info';
			} else {
				$this->commentFail = 'Information not updated';
			}
		}
		
	}
}