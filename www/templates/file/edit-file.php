<div class="row">
	<div class=" small-12 medium-3 columns center">
		<img src="img/file-images/thumbnail/<?=$this->fileInfo['FileImage'];?>" >
	</div>
	<div class="small-12 medium-5 columns">
		<h4>File Name: <?= $this->fileInfo['FileName'];?></h4>
        <h4>File Type: <?= $this->fileType['Types']?></h4>
        <h4>Uploader: <?= $this->fileInfo['UserName'];?></h4>
        <p><?= $this->fileInfo['FileDescription']; ?></p>
    </div>   
    <div class="medium-4 columns">
    	<h3>Tags</h3>
        <?php
         	foreach( $this->fileTags as $row ) { ?>
                <li class="tag-list"><a class=" button tiny tags" href="index.php?page=search&tagid='.$row['ID'].'"><?=$row['Tags'];?></a></li>
        <?php } ?>        
    </div>
</div>

<form action="index.php?page=account" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="column">
			<h3 class="text-center">Edit File</h3>
		</div>
		<div class="medium-6 columns">
			<label for="file-name-update">File Name</label>
			<input type="text" name="file-name-update" value="<?= $this->fileInfo['FileName']; ?>">
			<?php $this->foundationAlert($this->fileNameUpdateError, 'error'); ?>
			<label for="types">File Type</label>
			<select name="disabled-dropdown">
			<?php
			$result = $this->model->getAllTypes();
			// Loop through each category and display as a checkbox
				echo 	'<option value="'.$row['ID'].'">'.$this->fileType['Types'].'</option>';
			while( $row = $result->fetch_assoc() ) {
				echo '<option value="'.$row['ID'].'">'.$row['Types'].'</option>';
			}?>
			</select>
			<?php $this->foundationAlert($this->fileTypeUpdateError, 'error'); ?>
		</div>
		<div class="medium-6 columns">
			<label for="file-description-update">Description</label>
			<textarea name="file-description-update" id="file-description-update" cols="30" rows="5"><?= $this->fileInfo['FileDescription']; ?></textarea>
			<?php $this->foundationAlert($this->fileDescriptionUpdateError, 'error'); ?>
		</div>
	</div>
	<div class="row">
		<div class="columns">
			<label for="tag-update">File Tags</label>
			<?php
			$result = $this->model->getAllTags();
			// Loop through each tag and display as a radio
			while( $row = $result->fetch_assoc() ) {
				echo '<p class="small-3 medium-2 columns left tag-class"><input type="checkbox" name="tag-update[]" value="'.$row['ID'].'">'.' '.$row['Tags'].'</p>';
			}?>
			<?php $this->foundationAlert($this->tagUpdateError, 'error'); ?>
		</div>
	</div>

	<div class="row">
		<div class="medium-6 columns">
			<label for="file-image-update">File Image: Must be square!</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
			<input type="file" name="file-image-update" id="file-image-update" class="button small file-button">
			<?php $this->foundationAlert($this->fileImageUpdateError, 'error'); ?>
		</div>
		<div class="medium-6 columns">
			<label for="file-update">File:</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
			<input type="file" name="file-update" id="file-update" class="button small file-button">
			<?php $this->foundationAlert($this->fileUpdateError, 'error'); ?>
		</div>
	</div>
	<div class="row">
		<div class="small-6 medium-6  columns ">
			<input type="submit" value="update file!" name="update-file" class="button small dink-button " id="upload-file">
			<?php $this->foundationAlert($this->fileUpdateSuccess, 'success'); ?>
			<?php $this->foundationAlert($this->fileUpdateFail, 'error'); ?>
		</div>
	</form>
	<div class=" small-6 medium-6 columns">
    	<input type="submit" name="user-data" value="delete file" class="button small file-button left">
	</div>	
</div>