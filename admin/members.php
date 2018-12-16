<?php

    /*
    ===========================================
    == mange members page
    == You Can Add | Delete | Edit Members Here 
    ===========================================
    */
    
    session_start();
	$pageTitle = 'Members';
	if(isset($_SESSION['Username'])){
		
		include 'init.php';
		
        $do = isset($_GET['do'])? $_GET['do'] : 'manage';  // Short if operator :)
        
        // Start Manage Page
		
        if($do == 'manage'){// manage page
			
			$query = '';
			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
				
				$query = 'AND RegStatus = 0';
			}


			 // Select All users Except Admins
			 
			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");
			
			// Execute The Statement
			
			$stmt->execute();
			
			// fetch All users And Assign To Variables
			
			$rows = $stmt ->fetchAll();
			
			if(! empty($rows)){

			?>
            
			<h1 class="text-center"> Manage Members  </h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Avatar</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registerd Date </td>
							<td>Control</td>
						</tr>
						<?php
							
							foreach($rows as $row){
								
								echo "<tr>";
									echo "<td>". $row['UserID'] . "</td>";
									echo "<td>";
										if(empty($row['avatar'])){
											echo "<img src='uploads/avatars/DefaultAvatar.jpg' alt='' />" ;
										}else{
											echo "<img src='uploads/avatars/". $row['avatar'] . "' alt='' />" ;
										}
									echo "</td>";
									echo "<td>". $row['Username'] . "</td>";
									echo "<td>". $row['Email'] . "</td>";
									echo "<td>". $row['FullName'] . "</td>";
									echo "<td>". $row['Date'] ."</td>";
									echo "<td> <a class='btn btn-success' href='members.php?do=Edit&UserID=". $row['UserID'] ." '><i class='fa fa-edit'></i> Edit </a>
											   <a class='btn btn-danger confirm' href='members.php?do=Delete&UserID=". $row['UserID'] ." '><i class='fa fa-close'></i> Delete </a> ";
												
											   if ($row['RegStatus'] == 0) {
											   	echo "<a class='btn btn-info ' href='members.php?do=Activate&UserID=". $row['UserID'] ." '><i class='fa fa-check'></i> Activate </a> ";
											   }

								echo "</td>";
									
								echo "</tr>";
								}	
						
						?>
					</table>
				</div>
				
			<a href='members.php?do=Add' class="btn btn-primary btnadd"><li class="fa fa-plus"></li> New Member </a>
			</div>

		<?php }else{

			echo "<div class='container'>";
				echo "<div class='nice-message' > There's No Members To Show </div>";
				echo "<a href='members.php?do=Add' class='btn btn-primary btnadd'><li class='fa fa-plus'></li> New Member </a>";

			echo "</div>";


		} ?>
		
		<?php
		}elseif($do == 'Add'){ // Add Members Page ?> 
			
				<h1 class="text-center"> Add New Member  </h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
							<!-- Start Username field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Username : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="username" class="form-control" autocomplete="off" required="required"  placeholder="Username To Login Into Shop" >
								</div>
							</div>
							<!-- End Username field -->
							<!-- Start Password field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Password : </label>
								<div class="col-sm-10 col-md-6">
									<input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password Must Be Hard And Complex" >
									<i class="show-pass fa fa-eye fa-1x"></i>
								</div>
							</div>
							<!-- End Password field -->
							<!-- Start Email field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Email : </label>
								<div class="col-sm-10 col-md-6">
									<input type="email" name="email"  class="form-control" required="required"  placeholder="Email Must Be Valid">
								</div>
							</div>
							<!-- End Email field -->
							<!-- Start FullName field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Full Name : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="Full"  class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page">
								</div>
							</div>
							<!-- End Fullname field -->
							<!-- Start avatar field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Your Image : </label>
								<div class="col-sm-10 col-md-6">
									<input type="file" name="avatar"  class="form-control" required="required">
								</div>
							</div>
							<!-- End avatar field -->
							<!-- Start Button field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-10 col-md-6">
									<input type="submit" value="Add Member" class="btn btn-primary btn-lg" >
								</div>
							</div>
							<!-- End Button field -->
							
							
							
						</form>
						
					</div>
			
		<?php
		
		} elseif ($do == 'Insert'){   // Insert Members page
			
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				echo '<h1 class="text-center"> Update Member </h1>' ;
				echo '<div class="container">' ;

				// upload Variables

				$avatarName = $_FILES['avatar']['name'];
				$avatarType = $_FILES['avatar']['type'];
				$avatarTmp = $_FILES['avatar']['tmp_name'];
				$avatarSize = $_FILES['avatar']['size'];


				// List of Allowed File Typed To Upload

				$avatarAllowedExtension = array("jpeg","jpg","png","gif");

				// Get Avatar Extension
				$avatar_E = explode('.',$avatarName);
				$avatarExtension = end($avatar_E);
				
				// Get variables from the Form
				$user 	=  $_POST['username'];
				$pass 	=  $_POST['password'];
				$email	=  $_POST['email'];
				$name 	=  $_POST['Full'];
				
				$hashpass = sha1($_POST['password']);
				// Start Validate the Form
				
				$formErrors = array();
				
				if(strlen($user) < 3 ){
					$formErrors[] =" Username cant be less <strong> than 3 characters </strong> ";	
				}
				if(strlen($user) > 20 ){
					$formErrors[] = " Username cant Be More <strong> Than 20 Characters</strong> ";
					
				}
				
				if (empty($user)) {
					$formErrors[] = " Username Cant Be <strong> Empty </strong>";
				}
				
				if (empty($pass)) {
					$formErrors[] = " Paswword Cant Be <strong> Empty </strong>";
				}
				
				if (empty($email)) {
					
					$formErrors[] = "Email cant Be <strong> Empty </strong> ";
				}
				
				if (empty($name)) {
					
					$formErrors[] = " Full Name cant Be <strong> Empty </strong> ";
				}

				if (!empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
					$formErrors[] = " This Extention Is Not <strong> Allowed </strong> ";	
				}

				if (empty($avatarName)) {
					$formErrors[] = " You must  Upload  <strong> Image </strong> ";	
				}

				if ($avatarSize > 4194304 ) {
					$formErrors[] = " size of image cant be larger than <strong>4MB</strong> ";	
				}

				
				foreach($formErrors as $Error ){
					echo "<div class='alert alert-danger' >" . $Error . "</div>" ;
				}
				// End Validate the Form
				
				// if there is no Errors proceed the Update database operator
				
				
				if(empty($formErrors)){
				
				$avatar = rand(0, 100000000) . '_' . $avatarName;

				move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);

			 		// check the username in data base

					$check = checkItem("Username","users", $user);
					$check2 = checkItem("Email","users", $email);

					if ($check == 1 || $check2 == 1) {
						
						$TheMsg = "<div class = 'alert alert-danger' >sorry this name or Email is exist in data base </div> ";
						redirectHome($TheMsg,"back");

						}else{
					
							// Insert User info in database
							
							$stmt = $con->prepare("INSERT INTO
															users(Username, Password, Email, FullName,RegStatus , Date, avatar)
															VALUES(:zuser, :zpass, :zemail, :zname,1 ,now() ,:zavatar)");	
							$stmt ->execute(array(
							 
								'zuser' 	=> $user ,
								'zpass' 	=> $hashpass ,
								'zemail'	=> $email ,
								'zname' 	=> $name,
								'zavatar'	=> $avatar
							
							));	
								
							// Echo Success Message
							
							$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Record Updated" . "</div>";
							redirectHome($TheMsg , "back");
						}
				
				}
				
			}else{
				
				$TheMsg = "<div class= 'alert alert-danger' > You Cant Browse this Page Directly </div>";
				redirectHome($TheMsg); // if you didnt add seconds parameter its  ok it will take the default value 3
			}
			
			echo "</div>" ;
			
        }elseif ($do == 'Edit'){ // Edite page
			
			// check if GET Request UserID is numeric and  GET  the integer value of it
			
			$userid = isset($_GET['UserID'])&& is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;
			
			// SElECT All data from DATABase Depend on This ID 
			
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID= ? LIMIT 1");
			
			// Execute  Query 
			
			$stmt->execute(array($userid));
			
			// fetch the Data
			
			$row = $stmt->fetch();
			
			// The Row Count
			
			$count = $stmt->rowCount();
			
			// Check if there is find Id  Show The Form
			
			if( $count > 0 ){ ?>
				
				<h1 class="text-center"> Edit Member </h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="userid" value="<?php echo $userid ?> "/>
						<!-- Start Username field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username : </label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="username" value="<?php echo $row["Username"] ?>" class="form-control" autocomplete="off" required ="required ">
							</div>
						</div>
						<!-- End Username field -->
						<!-- Start Password field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password : </label>
							<div class="col-sm-10 col-md-6">
								<input type="hidden" name="oldpassword" value="<?php echo $row["Password"] ?>" >
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="leave blank if you dont want to change" >
							</div>
						</div>
						<!-- End Password field -->
						<!-- Start Email field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email : </label>
							<div class="col-sm-10 col-md-6">
								<input type="email" name="email" value="<?php echo $row["Email"] ?>" class="form-control" required ="required ">
							</div>
						</div>
						<!-- End Email field -->
						<!-- Start FullName field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name : </label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="Full" value="<?php echo $row["FullName"] ?>" class="form-control" required ="required ">
							</div>
						</div>
						<!-- End Fullname field -->
						<!-- Start Button field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-md-6">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" >
							</div>
						</div>
						<!-- End Button field -->
						
						
						
					</form>
					
				</div>
	
			
			<?php
			
			// Else if  didnt found Id  Show Error message
			
			}else{

				 echo "<div class='container'>";

				 $TheMsg = "<div class= 'alert alert-danger'> there is no such id </div>";
				 
				 redirectHome($TheMsg);

				 echo "</div>";
			}
			
			
			
         }elseif($do == 'Update'){ // Update Page
			
			echo '<h1 class="text-center"> Update Member </h1>' ;
			echo '<div class="container">' ;
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				// Get variables from the Form
				$id 	=  $_POST['userid'];
				$user 	=  $_POST['username'];
				$email	=  $_POST['email'];
				$name 	=  $_POST['Full'];
				
				// Password trick
				
				$pass=empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ; // short if operator 
				
				// Start Validate the Form
				
				$formErrors = array();
				
				if(strlen($user) < 3 ){
					$formErrors[] =" Username cant be less <strong> than 3 characters </strong> ";	
				}
				if(strlen($user) > 20 ){
					$formErrors[] = " Username cant Be More <strong> Than 20 Characters</strong> ";
					
				}
				
				if (empty($user)) {
					$formErrors[] = " Username Cant Be <strong> Empty </strong>";
				}
				if (empty($email)) {
					
					$formErrors[] = "Email cant Be <strong> Empty </strong> ";
				}
				
				if (empty($name)) {
					
					$formErrors[] = " Full Name cant Be <strong> Empty </strong> ";
				}
				
				foreach($formErrors as $Error ){
					echo "<div class='alert alert-danger' >" . $Error . "</div>" ;
				}
				// End Validate the Form
				
				// if there is no Errors proceed the Update database operator
				
				if(empty($formErrors)){
				
					$stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");

					$stmt2->execute(array($user,$id));

					$count = $stmt2->rowCount();

					if ($count == 1) {
						
						echo "<div class='alert alert-danger'> Sorry This User is Exist </div>";

						redirectHome($TheMsg, 'back');
					
					}else{

						// update The Database with this Info
					
					$stmt = $con ->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
					
					$stmt->execute(array($user, $email, $name, $pass, $id));
					
					
					// Echo Success Message
					$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Record Updated" . "</div>";
					
					redirectHome($TheMsg, 'back');

					}


				}
				
			}else{
				
				$TheMsg = " <div class= 'aler alert-danger '> You Cant Browse this Page Directly </div>";
				
				redirectHome($TheMsg );
			}
			
			echo "</div>" ;
			
		 }elseif ($do == 'Delete') { // Delete member Page
			
			echo '<h1 class="text-center"> Delete Member </h1>' ;
			echo '<div class="container">' ;
				
				// check if GET Request UserID is numeric and  GET  the integer value of it
				
				$userid = isset($_GET['UserID'])&& is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;
				
				// SElECT All data from DATABase Depend on This ID
				
				//$stmt = $con->prepare("SELECT * FROM users WHERE UserID= ? LIMIT 1"); I used the function checkItem  instad of this :)
				
				 $check = checkItem('UserID', 'users', $userid);
				
				// Execute  Query

				//$stmt->execute(array($userid)); I used the function checkItem instad of this :)
				
				// The Row Count
				
				//$count = $stmt->rowCount(); I used the function checkItem instad of this :)
				
				// Check if there is find Id  Show The Form
				
				
				if( $check > 0 ){ 
					
					
					$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser ");
					
					$stmt->bindParam(":zuser", $userid);
					
					$stmt->execute();
					
					// Echo Success Message
					
					$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Delete Updated" . "</div>";
					redirectHome($TheMsg,'back');
				}else{
					
					$TheMsg = "<div class='alert alert-danger'> This ID is Not Exist  </div>";
					redirectHome($TheMsg);
				}
				
				
			echo "</div>";
			
		}elseif ( $do='Activate') {  // Activate Page

			echo '<h1 class="text-center"> Activate Member </h1>' ;
			echo '<div class="container">' ;
				
				// check if GET Request UserID is numeric and  GET  the integer value of it
				
				$userid = isset($_GET['UserID'])&& is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;
				
				// SElECT All data from DATABase Depend on This ID
				
				 $check = checkItem('UserID', 'users', $userid);
				
				// The Row Count
				
				// Check if there is find Id  Show The Form
				
				if( $check > 0 ){ 
					
					$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID =? ");
					
					$stmt->execute(array($userid));
					
					$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Recorde Updated" . "</div>";
					redirectHome($TheMsg,'back');
				}else{
					
					$TheMsg = "<div class='alert alert-danger'> This ID is Not Exist  </div>";
					redirectHome($TheMsg);
				}
				
				
			echo "</div>";

		}
		 
		include $tpl . "footer.php ";
		
		 
		 }else{

			header("Location: index.php");
			exit();
		}


