<div class="row user-info">
		<?php
		//get user information
		$userInfo = $this->model->getAddedInfo();

		if($userInfo->num_rows == 1 ) {
			$row 		= $userInfo->fetch_assoc( );
			$image 		= $row['ProfileImage'];
			$helloText 	= $row['FirstName'].' '.$row['LastName'];
			$bioText 	= $row['Bio'];
		} else { 
			$image 		= 'octopus.jpg';
			$helloText 	= $_SESSION['username'];
			$bioText 	= 'Who are you? Add some information about yourself.';
		}
		?>
		<div class="medium-6 large-3 columns">
			<img src="img/profile-images/avatar/<?php echo $image;?>">
			</div>
			<div class="medium-6 large-9 columns">
			<h2>Hello <?php echo $helloText; ?></h2>
			<p><?php echo $bioText; ?></p>
		</div> 
</div>

<div class="row clearfix ">
    <div class="twelve columns centered ">
    	<h3 class="text-center">Files Uploaded</h3>
		<?php
			$result = $this->model->getUserFileInfo();
          	
          	while( $row = $result->fetch_assoc() ) {
            	echo '<a href="index.php?page=file&fileid='.$row['ID'].'"><img src="img/file-images/thumbnail/'.$row['FileImage'].'" class="img-search"></a>';
         }?>
	</div>
</div>
<hr>
<div class="row">
	<div class="columns">
		<h2 class="text-center">User Controls</h2>
	</div>
</div>
<?php
	//Get the users additional info if it exists
	$result = $this->model->getAddedInfo();
	//If there is a result
	if($result->num_rows == 1) {
		//Extract data
		$data = $result->fetch_assoc();
			$firstName 	= $data['FirstName'];
			$lastName 	= $data['LastName'];
			$bio 		= $data['Bio'];
	} else {
		$firstName 	= '';
		$lastName 	= '';
		$bio 		= '';
	}
	//If the user has submitted the form 
	// then we want to use the newer data instead
	if ( isset($_POST['user-data']) ) {
		$firstName 	= $_POST['first-name'];
		$lastName 	= $_POST['last-name'];
		$bio 		= $_POST['bio'];
	}?>
<div class="row">
	<div class="columns">
		<form action="index.php?page=account" method="post" enctype="multipart/form-data">
			<h3>add/update info</h3>
			<div class="row">
				<div class=" medium-6 columns">
					<label for="first-name">First Name:</label>
					<input type="text" value="<?= $firstName; ?>" name="first-name" id="first-name" placeholder="Bruce">
					<?php $this->foundationAlert($this->userFirstNameError, 'error'); ?>
				</div>
				<div class=" medium-6 columns">
					<label for="last-name">Last Name:</label>
					<input type="text" value="<?= $lastName; ?>" name="last-name" id="last-name" placeholder="Wayne">
					<?php $this->foundationAlert($this->userLastNameError, 'error'); ?>
				</div>
			</div>
			<div class="row">
				<div class=" medium-6 columns">
					<label for="bio">About you:</label>
					<textarea name="bio" id="bio" cols="30" rows="5"><?= $bio; ?></textarea>
					<?php $this->foundationAlert($this->userBioError, 'error'); ?>
				</div>
				<div class=" medium-6 columns">
					<label for="profile-image">Profile Image: Make sure it's square</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
					<input type="file" name="profile-image" id="profile-image" class="button small file-button">
					<?php $this->foundationAlert($this->userImageError, 'error'); ?>
					<?php if($userInfo->num_rows == 1 ) {
						$buttonContent = 'update info!';
					}else{ 
						$buttonContent = 'add info!';
					}?>
					<input type="submit" name="user-data" value="<?php echo $buttonContent; ?>" class="button small dink-button ">
					<?php $this->foundationAlert($this->userSuccess, 'success'); ?>
					<?php $this->foundationAlert($this->userFail, 'error'); ?>
				</div>
			</div>
		</form>
	</div>
</div>
<form action="index.php?page=account" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="columns">
			<h3>upload file</h3>
		</div>
		<div class="medium-6 columns">
			<label for="file-name">File Name</label>
			<input type="text" name="file-name" value="<?php echo $this->fileName; ?>">
			<?php $this->foundationAlert($this->fileNameError, 'error'); ?>
			
			<label for="types">File Type</label>
			<select name="file-type-upload-dropdown">
			<?php
			$result = $this->model->getAllTypes();
			// Loop through each category and display as a checkbox
			while( $row = $result->fetch_assoc() ) {
				// If the ID in this->fileType is the same as the ID we are looping over
				if( $this->fileType == $row['ID'] ) {
					$selected = ' selected';
				} else {
					$selected = '';
				}
				echo '<option value="'.$row['ID'].'" '.$selected.' >'.$row['Types'].'</option>';
			}?>
			<?php $this->foundationAlert($this->fileTypeError, 'error'); ?>
			</select>
		</div>

		<div class="medium-6 columns">
			<label for="file-description">Description</label>
			<textarea name="file-description" id="file-description" cols="30" rows="5" ><?php echo $this->fileDescription; ?></textarea>
			<?php $this->foundationAlert($this->fileDescriptionError, 'error'); ?>
		</div>
	</div>
	<div class="row">
		<div class="columns">
			<label for="tag-checkbox">File Tags</label>
			<?php
				$result = $this->model->getAllTags();
				// Loop through each tag and display as a radio
				while( $row = $result->fetch_assoc() ) {
					// If the ID in this->fileTag is the same as the ID we are looping over
					if(is_array($this->fileTag) && in_array( $row['ID'], $this->fileTag ) ) {
						$selected = ' checked';
					} else {
						$selected = '';
					}
			echo '<p class="small-3 medium-2 columns left tag-class">
			<input type="checkbox" name="tag-checkbox[]" value="'.$row['ID'].'" '.$selected.'>'.' '.$row['Tags'].'</p>';
			}?>
			<?php $this->foundationAlert($this->tagCheckboxError, 'error'); ?>
		</div>
	</div>
	<div class="row">
		<div class="medium-6 columns">
			<label for="file-image">File Image: Make sure it's square</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
			<input type="file" name="file-image" id="file-image" class="button small file-button">
			<?php $this->foundationAlert($this->fileImageError, 'error'); ?>
		</div>
		<div class="medium-6 columns">
			<label for="file">File</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
			<input type="file" name="file" id="file" class="button small file-button">
			<?php $this->foundationAlert($this->fileError, 'error'); ?>
		</div>
	</div>
	<div class="row">
		<div class="columns ">
			<input type="submit" value="upload file!" name="upload-file" class="button small dink-button " id="upload-file">
			<?php $this->foundationAlert($this->fileUploadSuccess, 'success'); ?>
			<?php $this->foundationAlert($this->fileUploadFail, 'error'); ?>
		</div>
	</div>
</form>	
<div class="row">
	<div class="medium-6 columns">
		<form action="index.php?page=account" method="post">
			<h3>change password</h3>
			<div class="row">
				<div class=" columns">
					<label>old password: </label>
					<input type="password" name="existing-password">
					<?php $this->foundationAlert($this->existingPasswordError, 'error'); ?>
				</div>
				<div class=" columns">
					<label>new password: </label>
					<input type="password" name="new-password">
					<?php $this->foundationAlert($this->newPasswordError, 'error'); ?>
				</div>
				<div class="columns">
					<label>confirm new password: </label>
					<input type="password" name="confirm-password">
					<?php $this->foundationAlert($this->confirmPasswordError, 'error'); ?>
				</div>
			</div>
			<div class="row">
				<div class="columns">
					<input type="submit" class="button small dink-button" value="Set new password!">
					<?php $this->foundationAlert($this->passwordChangeSuccess, 'sucess'); ?>
					<?php $this->foundationAlert($this->passwordChangeFail, 'error'); ?>
				</div>
			</div>
		</form>
	</div>
</div>







