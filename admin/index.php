
<?php

 session_start();
 	$noNavbar = '';
		$pageTitle = 'Login';
	if(isset($_SESSION['Username'])){
		header('Location: dashboard.php'); // Redirect To Dashboard Page
		exit();
		}

 include 'init.php' ;
 

// check if user comming from HTTP POST Request 

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 	
 	$username = $_POST['user'];
 	$password = $_POST['pass'];
 	$hashedPass = sha1($password);

 	//check if the user exist in Database

 	$stmt = $con->prepare("SELECT  UserID, Username, Password FROM users WHERE Username= ? AND Password= ? AND GroupID = 1 LIMIT 1");
		
 	$stmt->execute(array($username, $hashedPass));
	$row = $stmt->fetch();
 	$count = $stmt->rowCount();

 	// check if the Database contains count > 0 this means  it had countRow Record 
 	if ($count > 0) {
 	 	
 	 	$_SESSION['Username'] = $username; // Register Session Name
				$_SESSION['ID'] = $row['UserID'];		// Register Session ID
 	 	header('Location: dashboard.php'); // Redirect To Dashboard 
 	 	exit();

 	 } else{
 	 	echo  "sorry  admin only :)";
 	 }

 }

 ?>

 	<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
 		<h4 class="text-center"> Admin login</h4>
 		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
 		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
 		<input class="btn btn-primary btn-block" type="submit" value="login">

 	</form>





<?php include $tpl . "footer.php "; ?>