<div class="row">
	<div class="medium-5 columns">
		<img src="img/file-images/preview/<?=$this->fileInfo['FileImage'];?>">
	</div>
	<div class="medium-7 columns">
		<h2><?= $this->fileInfo['FileName'];?></h2>
        <h4>File Type: <?= $this->fileType['Types']?></h4>
        <h4>By <?= $this->fileInfo['UserName'];?></h4>
        <p><?= $this->fileInfo['FileDescription']; ?></p>
        <h3>Tags</h3>
        
        <div class="row">
            <div class="column">
                <?php
                while( $row = $this->fileTags->fetch_assoc() ) { ?>
                    <li class="tag-list"><a class=" button tiny tags" href="index.php?page=search&tagid='.$row['ID'].'"><?=$row['Tags'];?></a></li>
                <?php } ?>        
            </div>
        </div>
    	<div class="row">
			<div class="small-6 columns">
				<button class="button small dink-button">Download</button>
			</div>
			<div class="small-6 columns">
				<?php if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' ){ ?>
            		<a href="index.php?page=file-edit&fileid=<?= $this->fileInfo['ID'] ?>" class="button small file-button right" name="user-data">Edit File</a>
        		<?php } ?>
			</div>
    	</div>
    </div>
</div>    
<div class="row">
    <div class="medium-5 columns">
        <h3>Related Images:</h3>
            <?php
                // Get all the latest deals
                $result = $this->model->getLatest5Files();
                // Loop through each result and display inside a list item
                while( $row = $result->fetch_assoc() ) {
                    echo '<a href="index.php?page=file&fileid='.$row['ID'].'"><img src="img/file-images/thumbnail/'.$row['FileImage'].'" class="file-img-search"></a>';
                }?>
    </div>
    <div class="medium-7 columns">
        <h3>Comments</h3>
            <?php if( isset($_SESSION['privilege']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'user')){ ?>
                
                <form novalidate method="post" action="index.php?page=file&fileid=<?= $this->fileInfo['ID']; ?>">
                <label for="comment">Add a Comment:</label>
                <textarea name="comment" id="comment" cols="30" rows="3" ></textarea>
                <?php $this->foundationAlert($this->commentError, 'error'); ?>
                <input type="submit" name="add-comment" value="Add Comment" class="button small dink-button ">
                <?php $this->foundationAlert($this->commentSuccess, 'success'); ?>
                <?php $this->foundationAlert($this->commentFail, 'fail'); ?>
            </form>
            <?php } 
                // Get all the latest deals
                $result = $this->model->getCommentInfo();
                // Loop through each result and display inside a list item
                while( $row = $result->fetch_assoc() ) { ?>
                    <p class="comment">
                        '<?= $row['Comment']; ?>'
                    </p>
            <?php } ?>
    </div>
</div>   




