<?php

ob_start();
 session_start();
	$pageTitle = 'Login';
	
	if(isset($_SESSION['user'])){
		header('Location: index.php'); // Redirect To HomePage
		
		}

	include 'init.php';

// check if user comming from HTTP POST Request 

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

 	if (isset($_POST['login'])) {
 		
 	
	 	$user = $_POST['username'];
	 	$pass = $_POST['password'];

	 	$hashedPass = sha1($pass);

	 	//check if the user exist in Database

	 	$stmt = $con->prepare("SELECT  UserID, Username, Password FROM users WHERE Username= ? AND Password= ?");
			
	 	$stmt->execute(array($user, $hashedPass));
	 	$get = $stmt-> fetch();
	 	$count = $stmt->rowCount();

	 	// check if the Database contains count > 0 this means  it had countRow Record 
	 	if ($count > 0) {
	 	 	
	 	 	$_SESSION['user'] = $user; // Register Session Name

	 	 	$_SESSION['uid']  = $get['UserID']; // Register User ID in session
			
	 	 	header('Location: index.php'); // Redirect To Homepage 
	 	 	
	 	 	exit();

	 	 }
 	}else{
 		
 		$formErrors = array();

 		$username 	= $_POST['username'];
 		$password 	= $_POST['password'];
 		$password2 	= $_POST['password2'];
 		$email 		= $_POST['email'];

 		// Start  Validate ussername

 		if (isset($username)) {
 			
 			$filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

 			if (strlen($filterdUser) < 4 ) {
 				
 				$formErrors[] = "Sorry your Name Must Be More Than 4 Characters" ;
 			}
 		}
 		// End  Validate username
 		// Start  Validate password


 		if (isset($password) && isset($password2)) {
 			
 			if (empty($password)) {
 				$formErrors[]='Sorry password cant be empty';
 			}


 			$pass1= sha1($password);
 			$pass2= sha1($password2);

 			if ($pass1 !== $pass2) {
 				$formErrors[] = 'sorry your Password is Not Match';
 			}
 		}
	 // End  Validate password
 	// Start validate email 
 		if (isset($email)) {
 			
 			$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

 			if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {
 				$formErrors[] = 'Email is not Valid';
 			}
 		}
 	// End validate email 

	// if there is no Errors proceed the User Add
		
		if(empty($formErrors)){
		
	 		// check the username and email in data base

			$check = checkItem("Username","users", $username);
			$check2 = checkItem("Email","users", $email);

			if ($check == 1 || $check2 == 1) {
				
				$formErrors[] = "Sorry Username or Email is Exist  ";
				

				}else{
			
					// Insert User info in database
					
					$stmt = $con->prepare("INSERT INTO
													users(Username, Password, Email,RegStatus , Date )
													VALUES(:zuser, :zpass, :zemail,0 ,now())");	
					$stmt ->execute(array(
					 
						'zuser' => $username ,
						'zpass' => sha1($password) ,
						'zemail'=> $email 
					
					));	
						
					// Echo Success Message
					
					$successMsg = "Congrats You Are Now Registerd User";
					
				}
		}
 	} 

 }


	
?>

<div class="container login-page">
	<h1 class="text-center" > <span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span> </h1>
	
	<!-- Start Login form -->
	
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" >
		<div class="input-container" >
			<input class="form-control" type="text" name="username" autocomplete="off" placeholder="Your Username" required />
		</div>
		<div class="input-container" >
			<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Password" required />
		</div>
			<input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
	</form>
	<!-- End Login form -->
	
	<!-- Start signup form -->

	<form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		<div class="input-container">
			<input class="form-control" type="text" name="username" autocomplete="off" placeholder="Your Username" pattern=".{4,}" title="Username must be more than 4 Characters" required  />
		</div>
		<div class="input-container" >
			<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Write a Complex Password" minlength="4" required />
		</div>
		<div class="input-container">
			<input class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Write Your Password again" minlength="4" required  />
		</div>
		<div class="input-container">
			<input class="form-control" type="email" name="email" autocomplete="off" placeholder="Write a valid email " required />
		</div>
		<input class="btn btn-success btn-block" type="submit" name="signup" value="Signup">
	</form>

	<!-- End signup form -->
	<div class="the-errors text-center " >
		
		<?php 
		if (! empty($formErrors)) {
			foreach ($formErrors as $error) {

				echo "<div class='msg error'>" . $error . "</div>";

			}
		}

		if (isset($successMsg)) {
			echo "<div class='msg success'>" . $successMsg . "</div>" ;
		}
			
		?>

	</div>

</div>



<?php
	include $tpl .'footer.php';

ob_end_flush();	
?>