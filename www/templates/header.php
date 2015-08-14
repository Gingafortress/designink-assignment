<!doctype html>
<html lang="en">
<head>
  	<meta charset="utf-8">
  	<title><?php echo $this->model->title; ?></title>
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="description" content="<?php echo $this->model->description; ?>">
 	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/css/foundation.min.css">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
 	  <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="img/favicon.jpg" />
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/vendor/modernizr.js"></script>
</head>
<body>

  <!-- Navigation -->
  	<div class="contain-to-grid sticky" >
   		<nav class="top-bar" data-topbar>
     		<ul class="title-area name" >
                  <?php
                    $result = $this->model->getFileTotal();
                    $result->fetch_assoc();
                    $row = $result->num_rows; 
                    
                 ?>
        		<li ><h1><a href="index.php?page=search&query"><?php echo $row;?> Files Uploaded</a></h1></li>
                <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
      		</ul>

      	<section class="top-bar-section">
       		<ul class="right">
          		<li><a href="index.php?page=home">home</a></li>
          		<li><a href="index.php?page=about">about</a></li>
                <li><a href="index.php?page=contact">contact</a></li>
                <?php
                    //if user is not logged in
                    if( !isset($_SESSION['username'] ) ) : ?>
                        <li><a href="index.php?page=sign-up">signup</a></li> 
                        <li><a href="index.php?page=login">login</a></li>
                <?php else: ?>
                        <li><a href="index.php?page=account"><?php echo $_SESSION['username']?></a></li> 
                        <li><a href="index.php?page=logout">logout</a></li>
                <?php endif; ?>
            </ul>
            
        </section>
        </nav>
    </div>
   
