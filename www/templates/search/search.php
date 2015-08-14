<div class="row clearfix ">
    <div class="twelve columns centered ">
		<div>
			<?php 
				while( $row = $this->searchResults->fetch_assoc() ) {
					echo '<a href="index.php?page=file&fileid='.$row['ID'].'"><img src="img/file-images/thumbnail/'.$row['FileImage'].'" class="img-search"></a>';
			}?>
		</div>
  	</div>
</div>