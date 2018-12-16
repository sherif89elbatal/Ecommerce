<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> <?php  getTitle() ?> </title>
	<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $css; ?>fontawesome.min.css">
  <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
  <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
	<link rel="stylesheet" href="<?php echo $css; ?>frontend.css">
</head>

<body>
	<div class="upper-bar" >
		<div class="container">
  <?php
    if(isset($_SESSION['user'])){ ?>
        
        <div class="btn-group my-info pull-right">
          <img class='img-thumbnail img-circle my-img' src='layout/images/img.jpg' alt='' />
          <span class="dropdown-toggle" data-toggle="dropdown">
            <?php echo $_SESSION['user']?>
            <span class="caret"></span>
          </span>
          <ul class="dropdown-menu">
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="newad.php">New Item</a></li>
            <li><a href="profile.php#my-ads">My Items</a></li>
            <li><a href="logout.php">Logout</a></li>

            
          </ul>
        </div>

    <?php
    }else{

      ?>
      <a href="login.php">
        <span class="pull-right" >Login/Signup</span>
      </a>
  <?php } ?>  
    </div>
	</div>
	<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle='collapse' data-target="#app-nav" aria-expanded="false" >
        <span class="sr-only"> Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php

          $getcat = getAllFrom('*','categories','WHERE parent = 0','','ID','ASC');
        	foreach ( $getcat as $cat) {
        		echo "<li> 
        				<a href='categories.php?pageid=". $cat['ID'] ."' >
        				". $cat['Name'] ."

        				</a>


    				 </li>";
        	}


        ?>  
      </ul>
     </div>
    </div>
    </nav>         
  

