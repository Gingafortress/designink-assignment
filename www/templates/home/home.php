
	<div class="row">
		<div class="columns text-center">
			<img id="home-logo-oct" src="img/svg/designink-logo-oct.svg" alt="design ink logo of octopus">
		</div>
	</div>

<h3 class="text-center">Graphicals for Anyone</h3>

<div class="row">
	<div class="columns">
		<form action="index.php" method="get">
            <input type="hidden" name="page" value="search">
			<div class="row">
			    <div class="medium-8 columns">
			        <input type="search" placeholder="Search" name="query">
			    </div>
			    <div class="medium-4 columns">
			        <button class="postfix small-text-center medium-text-right right search-button">Go Search</button>
			    </div>
			</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="medium-8  columns">
		<p class="">The best site for  the discerning designer for when you need the design but no time to do it!
		An open source resources site for those who have the will but not the wallet.  </p>
	</div>
	<div class="medium-4   columns">
		
		<div class="small-text-center medium-text-right">
		<?php
            //if user is not logged in
            if( !isset($_SESSION['username'] ) ) : ?>
          		<h2><a href="index.php?page=sign-up">Join Now!</a></h2>
          	 <?php else: ?>
          	 	<h2><a href="index.php?page=account"> Account</a></h2>
          	 <?php endif; ?>
        </div>

	</div>
</div>




<h3 class="text-center">Latest Uploads</h3>

<div class="row clearfix ">
    <div class="twelve columns centered ">
    	<?php
          // Get all the latest deals
          	$result = $this->model->getLatestFiles();

          	// Loop through each result and display inside a list item
          	while( $row = $result->fetch_assoc() ) {
            	echo '<a href="index.php?page=file&fileid='.$row['ID'].'"><img src="img/file-images/thumbnail/'.$row['FileImage'].'" class="img-search"></a>';
        }?>
   	</div>
</div>
<div class="small-text-center" >
    <h2><a href="index.php?page=search&query" >See Everything Else!</a></h2>
</div>






  