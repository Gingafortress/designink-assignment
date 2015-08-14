<hr>
<div class="row">
	<div class="columns">
		<h2 class="text-center">Admin Controls</h2>
	</div>
</div>

<div class="row">
	<div class="medium-6 columns">
		<h3>deactivate account</h3>
		<div class="row">
			<div class="columns">
			<form action="index.php?page=account" method="post">
				<label>Disable Account:</label>
				<select name="active-user-dropdown">
					<?php
					//Use the model to get all accounts
					$result = $this->model->getAllUsernames();
					//loop through the result and display all the usernames
					while( $row = $result->fetch_assoc() ) {
					//Make sure the user is not an admin
						if( $row['Privilege'] == 'admin' || $row['Active'] == 'inactive') {
							continue;
						}
						echo '<option>'.$row['Username'].'</option>';
						}?>
				</select>
					<?php $this->foundationAlert($this->adminError, 'error'); ?>
				<input type="submit" class="button small dink-button " value="Disable Account">
					<?php $this->foundationAlert($this->deactivateAccountSuccess, 'success'); ?>
					<?php $this->foundationAlert($this->deactivateAccountFail, 'error'); ?>
			</form>
			</div>
		</div>
	</div>
	<div class="medium-6 columns">
		<h3>enable account</h3>
		<div class="row">
			<div class="columns">
				<form action="index.php?page=account" method="post">
					<label>activate account:</label>
					<select name="inactive-user-dropdown">
						<?php
						//Use the model to get all accounts
						$result = $this->model->getAllUsernames();
						//loop through the result and display all the usernames
						while( $row = $result->fetch_assoc() ) {
						//Make sure the user is not an admin
							if( $row['Privilege'] == 'admin' || $row['Active'] == 'active') {
								continue;
							}
							echo '<option>'.$row['Username'].'</option>';
							}?>
					</select>
						<?php $this->foundationAlert($this->adminEnableError, 'error'); ?>
					<input type="submit" class="button small dink-button" value="Re-activate Account">
						<?php $this->foundationAlert($this->activateAccountSuccess, 'success'); ?>
					<?php $this->foundationAlert($this->activateAccountFail, 'error'); ?>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="medium-6 columns">
		<h3>Add Tag</h3>
		<div class="row">
			<div class="columns">
				<form action="index.php?page=account" method="post">	
					<!-- <label for="add-tag">Tag</label> -->
					<input type="text" name="add-tag" id="add-tag" placeholder="Doe" >
					<?php $this->foundationAlert($this->addTagError, 'error'); ?>
					<input type="submit" class="button small dink-button " value="add tag">
					<?php $this->foundationAlert($this->tagSuccess, 'success'); ?>
					<?php $this->foundationAlert($this->tagFail, 'error'); ?>
				</form>
			</div>
		</div>
	</div>
	<div class="medium-6 columns">
		<h3>Add File Type</h3>
		<div class="row">
			<div class="columns">
				<form action="index.php?page=account" method="post">
					<!-- <label for="add-file-type">File Type</label> -->
					<input type="text" name="add-file-type" id="add-file-type" placeholder="jpeg" >
					<?php $this->foundationAlert($this->addFileTypeError, 'error'); ?>
					<input type="submit" class="button small dink-button" value="add file type">
					<?php $this->foundationAlert($this->fileTypeSuccess, 'success'); ?>
					<?php $this->foundationAlert($this->fileTypeFail, 'error'); ?>
				</form>
			</div>
		</div>
	</div>		
</div>

<div class="row">
	<div class="medium-6 columns">
		<h3>Delete Tag</h3>
		<div class="row">
			<div class="columns">
				<form action="index.php?page=account" method="post">	
					<!-- <label for="delete-tag-dropdown">Tag</label> -->
					<select name="delete-tag-dropdown">
						<?php
						$result = $this->model->getAllTags();
						// Loop through each category and display as a checkbox
						while( $row = $result->fetch_assoc() ) {
							echo '<option value="'.$row['ID'].'">'.$row['Tags'].'</option>';
						}?>
					</select>
					<?php $this->foundationAlert($this->deleteTagError, 'error'); ?>
					<input type="submit" class="button small dink-button " value="delete tag">
					<?php $this->foundationAlert($this->deleteTagSuccess, 'success'); ?>
					<?php $this->foundationAlert($this->deleteTagFail, 'error'); ?>
				</form>
			</div>
		</div>
	</div>
	<div class="medium-6 columns">
		<h3>Delete File Type</h3>
		<div class="row">
			<div class="columns">
				<form action="index.php?page=account" method="post">
					<!-- <label for="delete-file-type-dropdown">File Type</label> -->
					<select name="delete-file-type-dropdown">
						<?php
						$result = $this->model->getAllTypes();
						// Loop through each category and display as a checkbox
						while( $row = $result->fetch_assoc() ) {
							echo '<option value="'.$row['ID'].'">'.$row['Types'].'</option>';
						}?>
					</select>
					<?php $this->foundationAlert($this->addFileTypeError, 'error'); ?>
					<input type="submit" class="button small dink-button" value="delete file type">
					<?php $this->foundationAlert($this->deleteFileTypeSuccess, 'success'); ?>
					<?php $this->foundationAlert($this->deleteFileTypeFail, 'error'); ?>
				</form>
			</div>
		</div>
	</div>		
</div>
	








