<?php 

/*
=======================================
== Items Page
=======================================
*/

ob_start(); // Output Buffering Start 

session_start();

$pageTitle='Items';


if (isset($_SESSION['Username'])) {
		
	include 'init.php';
	
	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

	if ($do == 'manage') {
			
			 // Select All users Except Admins
			 
			$stmt = $con->prepare("SELECT 
										items.*,
										categories.Name AS category_name, 
										users.Username 
									FROM 
										items
									INNER JOIN
										 categories
									ON 
										categories.ID = items.Cat_ID
									INNER JOIN 
										users 
									ON 
										users.UserID = items.Member_ID
									ORDER BY 
										Item_ID DESC


										");
			
			// Execute The Statement
			
			$stmt->execute();
			
			// fetch All users And Assign To Variables
			
			$items = $stmt ->fetchAll();
			
			if(! empty($items)){
			
			?>
            
			<h1 class="text-center"> Manage items  </h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Date </td>
							<td>Category</td>
							<td>Username </td>
							<td>Control</td>
						</tr>
						<?php
							
							foreach($items as $item){
								
								echo "<tr>";
									echo "<td>". $item['Item_ID'] . "</td>";
									echo "<td>". $item['Name'] . "</td>";
									echo "<td>". $item['Description'] . "</td>";
									echo "<td>". $item['Price'] . "</td>";
									echo "<td>". $item['Add_Date'] ."</td>";
									echo "<td>". $item['category_name'] ."</td>";
									echo "<td>". $item['Username'] ."</td>";
									echo "<td> 
										<a class='btn btn-success' href='items.php?do=Edit&itemid=". $item['Item_ID'] ." '><i class='fa fa-edit'></i> Edit </a>
									    <a class='btn btn-danger confirm' href='items.php?do=Delete&itemid=". $item['Item_ID'] ." '><i class='fa fa-close'></i> Delete </a> ";
										if ($item['Approve'] == 0) {
											   	echo "<a class='btn btn-info ' 
											   	href='items.php?do=Approve&itemid=". $item['Item_ID'] ." '>
											   	<i class='fa fa-check'></i> Approve </a> ";
											   }
								echo "</td>";
									
								echo "</tr>";
								}	
						
						?>
					</table>
				</div>
				
			<a href='items.php?do=Add' class="btn btn-primary btnadd"><li class="fa fa-plus"></li> New Item </a>
			</div>
			
			<?php }else{

			echo "<div class='container'>";
				echo "<div class='nice-message' > There's No Items To Show </div>";
				echo "<a href='items.php?do=Add' class='btn btn-primary btnadd'><li class='fa fa-plus'></li> New item </a>";

			echo "</div>";


		} ?>

		<?php

	}elseif ($do == 'Add') { ?>
		
		<h1 class="text-center"> Add New Item  </h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Insert" method="POST">
							<!-- Start Name field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Name : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="name" class="form-control"   placeholder="Name Of The Item" >
								</div>
							</div>
							<!-- End Name field -->

							<!-- Start Description field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Description : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="description" class="form-control" required="required"  placeholder="Description Of The Item" >
								</div>
							</div>
							<!-- End Description field -->

							<!-- Start Price field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Price : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="price" class="form-control" required="required"  placeholder="Price Of The Item" >
								</div>
							</div>
							<!-- End Price field -->

							<!-- Start Country field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Country : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="country" class="form-control" required="required"  placeholder="Country Of Made" >
								</div>
							</div>
							<!-- End Country field -->

							<!-- Start Status field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Status : </label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="status">
										<option value="0">...</option>
										<option value="1"> New </option>
										<option value="2"> Like New </option>
										<option value="3"> Used </option>
										<option value="4">Very Old</option>
									</select>
								</div>
							</div>
							<!-- End Status field -->

							<!-- Start Members field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Member : </label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="member">
										<option value="0">...</option>
										<?php
											$allMembers =getAllFrom('*' , 'users' , '', '', 'UserID' );
											foreach ($allMembers as $user) {
												echo "<option value=".$user['UserID'] ." > ". $user['Username']." </option>";
											}
										?>
									</select>
								</div>
							</div>
							<!-- End Members field -->
							
							<!-- Start Categories field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Category : </label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="category">
										<option value="0">...</option>
										<?php
											$allCats =getAllFrom('*' , 'categories' , 'WHERE parent = 0', '', 'ID' );
											foreach ($allCats as $cat) {
												echo "<option value=".$cat['ID'] ." > ". $cat['Name']." </option>";

												$childCats =getAllFrom('*' , 'categories' , "WHERE parent = {$cat['ID']}", '', 'ID' );
												foreach ($childCats as $child) {
													echo "<option value=".$child['ID'] ." > ---". $child['Name']." </option>";
												}
											}
										?>
									</select>
								</div>
							</div>
							<!-- End Categories field -->
							<!-- Start tags field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Tags : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma(,)" >
								</div>
							</div>
							<!-- End tags field -->

							<!-- Start Button field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-10 col-md-6">

									<input type="submit" value="Add Item" class="btn btn-primary btn-sm" >
								</div>
							</div>
							<!-- End Button field -->
						</form>
					</div>
					
	<?php

	}elseif ($do == 'Insert' ) {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				echo '<h1 class="text-center"> Insert Item </h1>' ;
				echo '<div class="container">' ;
				
				// Get variables from the Form
				$name 		=  $_POST['name'];
				$desc 		=  $_POST['description'];
				$price		=  $_POST['price'];
				$country 	=  $_POST['country'];
				$status 	=  $_POST['status'];
				$member 	=  $_POST['member'];
				$cat 		=  $_POST['category'];
				$tags 		=  $_POST['tags'];

				
				// Start Validate the Form
				
				$formErrors = array();
				
				if(empty($name)){
					$formErrors[] =" Name can't be <strong> Empty </strong> ";
					redirectHome('../');	
				}
				if(empty($desc) ){
					$formErrors[] = " Description can't be <strong> Empty </strong> ";
					
				}
				
				if (empty($price)) {
					$formErrors[] = " Price can't be <strong> Empty </strong>";
				}
				
				if (empty($country)) {
					$formErrors[] = " Country can't be <strong> Empty </strong>";
				}
				
				if ($status == 0 ) {
					
					$formErrors[] = "You Must Choose The <strong> Status </strong> ";
				}
				
				if ($member == 0 ) {
					
					$formErrors[] = "You Must Choose The <strong> member </strong> ";
				}

				if ($cat == 0 ) {
					
					$formErrors[] = "You Must Choose The <strong> category </strong> ";
				}
				
				foreach($formErrors as $Error ){
					echo "<div class='alert alert-danger' >" . $Error . "</div>" ;
				}
				// End Validate the Form
				
				// if there is no Errors proceed the Update database operator
				
				if(empty($formErrors)){
				
					
							// Insert User info in database
							
							$stmt = $con->prepare("INSERT INTO
															items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, tags)
															VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus ,now(), :zcat, :zmember, :ztags )");	
							$stmt ->execute(array(
							 
								'zname' 	=> $name ,
								'zdesc' 	=> $desc ,
								'zprice'	=> $price ,
								'zcountry'  => $country,
								'zstatus' 	=> $status,
								'zcat' 		=> $cat,
								'zmember' 	=> $member,
								'ztags'		=> $tags

							));	
								
							// Echo Success Message
							
							$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Record Updated" . "</div>";
							redirectHome($TheMsg , "back");
				}
				
			}else{
				
				$TheMsg = "<div class= 'alert alert-danger' > You Cant Browse this Page Directly </div>";
				redirectHome($TheMsg); // if you didnt add seconds parameter its  ok it will take the default value 3
			}
			
			echo "</div>" ;

	}elseif ($do == 'Edit') {

		// check if GET Request itemID is numeric and  GET  the integer value of it
		
		$itemid = isset($_GET['itemid'])&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
			
			// SElECT All data from DATABase Depend on This ID 
			
			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID= ? ");
			
			// Execute  Query 
			
			$stmt->execute(array($itemid));
			
			// fetch the Data
			
			$item = $stmt->fetch();
			
			// The Row Count
			
			$count = $stmt->rowCount();
			
			// Check if there is find Id  Show The Form
			
			if( $count > 0 ){ ?>
				
			<h1 class="text-center"> Edit Item  </h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?> "/>
							<!-- Start Name field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Name : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="name" class="form-control" required="required"  placeholder="Name Of The Item" value="<?php echo $item['Name']?>" >
								</div>
							</div>
							<!-- End Name field -->

							<!-- Start Description field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Description : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="description" class="form-control" required="required"  placeholder="Description Of The Item" value="<?php echo $item['Description']?>" >
								</div>
							</div>
							<!-- End Description field -->

							<!-- Start Price field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Price : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="price" class="form-control" required="required"  placeholder="Price Of The Item" value="<?php echo $item['Price']?>" >
								</div>
							</div>
							<!-- End Price field -->

							<!-- Start Country field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Country : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="country" class="form-control" required="required"  placeholder="Country Of Made" value="<?php echo $item['Country_Made']?>" >
								</div>
							</div>
							<!-- End Country field -->

							<!-- Start Status field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Status : </label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="status">
										<option value="1" <?php if($item['Status'] == 1 ){ echo "selected";}?> > New </option>
										<option value="2" <?php if($item['Status'] == 2 ){ echo "selected";}?> > Like New </option>
										<option value="3" <?php if($item['Status'] == 3 ){ echo "selected";}?> > Used </option>
										<option value="4" <?php if($item['Status'] == 4 ){ echo "selected";}?> >Very Old</option>
									</select>
								</div>
							</div>
							<!-- End Status field -->

							<!-- Start Members field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Member : </label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="member">
										<?php
											$allMembers =getAllFrom('*' , 'users' , '', '', 'UserID' );
											
											foreach ($allMembers as $user) {
												echo "<option value='".$user['UserID'] ."'";
												if($item['Member_ID'] == $user['UserID'] ){ echo 'selected';} 
												echo " > ". $user['Username']." </option>";

											}
										?>
									</select>
								</div>
							</div>
							<!-- End Members field -->
							
							<!-- Start Categories field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Category : </label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="category">
										<?php
											$allCats = getAllFrom('*' , 'categories' , 'WHERE parent = 0', '', 'ID' );
											foreach ($allCats as $cat) {
												echo "<option value='".$cat['ID'] ."'";
												if($item['Cat_ID'] == $cat['ID'] ){ echo 'selected';}
												echo " > ". $cat['Name']." </option>";

												$childCats =getAllFrom('*' , 'categories' , "WHERE parent = {$cat['ID']}", '', 'ID' );
												foreach ($childCats as $child) {
													echo "<option value=".$child['ID'] ." > ---". $child['Name']." </option>";
												}
											}
										?>
									</select>
								</div>
							</div>
							<!-- End Categories field -->

							<!-- Start tags field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Tags : </label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma(,)" value="<?php echo $item['tags']?>" >
								</div>
							</div>
							<!-- End tags field -->

							<!-- Start Button field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-10 col-md-6">

									<input type="submit" value="Save" class="btn btn-primary btn-sm" >
								</div>
							</div>
							<!-- End Button field -->
						</form>

						<?php

								 // Select All users Except Admins
					 
					$stmt = $con->prepare("SELECT 
												comments.*, users.Username AS Member
										   FROM 
										   		comments
									   		INNER JOIN 
									   			users
								   			ON 
								   				users.UserID = comments.User_ID
							   				WHERE
							   					Item_ID = ?
										   ");
					
					// Execute The Statement
					
					$stmt->execute(array($itemid));
					
					// fetch All users And Assign To Variables
					
					$rows = $stmt ->fetchAll();

					if (! empty($rows)) {
						
					
					
					?>
					<h1 class="text-center"> Manage ( <?php echo $item['Name']?> ) Comments  </h1>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User Name</td>
								<td>Added Date </td>
								<td>Control</td>
							</tr>
							<?php
								
								foreach($rows as $row){
									
									echo "<tr>";
										echo "<td>". $row['Comment'] . "</td>";
										echo "<td>". $row['Member'] . "</td>";
										echo "<td>". $row['Comment_Date'] ."</td>";
										echo "<td> <a class='btn btn-success' href='comments.php?do=Edit&comid=". $row['C_ID'] ." '><i class='fa fa-edit'></i> Edit </a>
												   <a class='btn btn-danger confirm' href='comments.php?do=Delete&comid=". $row['C_ID'] ." '><i class='fa fa-close'></i> Delete </a> ";
													
												   if ($row['status'] == 0) {
												   	echo "<a class='btn btn-info ' href='comments.php?do=Approve&comid=". $row['C_ID'] ." '><i class='fa fa-check'></i> Approve </a> ";
												   }

									echo "</td>";
										
									echo "</tr>";
									}	
							
							?>
						</table>
					</div>
					<?php } ?>
					</div>
	
			<?php
			
			// Else if  didnt found Id  Show Error message
			
			}else{

				 echo "<div class='container'>";

				 $TheMsg = "<div class= 'alert alert-danger'> there is no such id </div>";
				 
				 redirectHome($TheMsg);

				 echo "</div>";
			}

	}elseif ($do == 'Update'){

			echo '<h1 class="text-center"> Update item </h1>' ;
			echo '<div class="container">' ;
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				// Get variables from the Form
				$id 		=  $_POST['itemid'];
				$name 		=  $_POST['name'];
				$desc		=  $_POST['description'];
				$price 		=  $_POST['price'];
				$country 	=  $_POST['country'];
				$status 	=  $_POST['status'];
				$cat 		=  $_POST['category'];
				$member 	=  $_POST['member'];
				$tags 		=  $_POST['tags'];
				
				
				// Start Validate the Form
				
				$formErrors = array();
				
				if(empty($name)){
					$formErrors[] =" Name can't be <strong> Empty </strong> ";	
				}

				if(empty($desc) ){
					$formErrors[] = " Description can't be <strong> Empty </strong> ";
					
				}

				if (empty($price)) {
					$formErrors[] = " Price can't be <strong> Empty </strong>";
				}

				if (empty($country)) {
					$formErrors[] = " Country can't be <strong> Empty </strong>";
				}
				
				if ($status == 0 ) {
					
					$formErrors[] = "You Must Choose The <strong> Status </strong> ";
				}
				
				if ($member == 0 ) {
					
					$formErrors[] = "You Must Choose The <strong> member </strong> ";
				}

				if ($cat == 0 ) {
					
					$formErrors[] = "You Must Choose The <strong> category </strong> ";
				}
				
				foreach($formErrors as $Error ){
					echo "<div class='alert alert-danger' >" . $Error . "</div>" ;
				}
				// End Validate the Form
				
				// if there is no Errors proceed the Update database operator
				
				if(empty($formErrors)){
				
					// update The Database with this Info
					
					$stmt = $con ->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, Member_ID = ?, tags =? WHERE Item_ID = ?");
					
					$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));
					
					
					// Echo Success Message
					$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Record Updated" . "</div>";
					
					redirectHome($TheMsg, 'back');
				}
				
			}else{
				
				$TheMsg = " <div class= 'aler alert-danger '> You Cant Browse this Page Directly </div>";
				
				redirectHome($TheMsg );
			}
			
			echo "</div>" ;

	}elseif ($do == 'Delete'){
		
		echo "<h1 class='text-center'> Delete Item </h1>";
		echo "<div class='container'>";

		// check if Get Request Item id is Numeric & Get The integer value of it 

		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; 

		// selelct All data depend on this id 

		$check = checkItem('Item_ID' ,'items', $itemid );

		if($check > 0 ){

			$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zitem ");

			$stmt->bindParam(":zitem", $itemid );

			$stmt->execute();

			// Echo Success Message
					
			$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Delete Updated" . "</div>";
			redirectHome($TheMsg,'back');


		}else{

			$TheMsg = "<div class='alert alert-danger'> This ID is Not Exist  </div>";
			redirectHome($TheMsg);

		}


		echo "</div>";

	}elseif ($do == 'Approve'){

			echo '<h1 class="text-center"> Approve Member </h1>' ;
			echo '<div class="container">' ;
				
				// check if GET Request itemID is numeric and  GET  the integer value of it
				
				$itemid = isset($_GET['itemid'])&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
				
				// SElECT All data from DATABase Depend on This ID
				
				 $check = checkItem('Item_ID', 'items', $itemid);
				
				// The Row Count
				
				// Check if there is find Id  Show The Form
				
				if( $check > 0 ){ 
					
					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID =? ");
					
					$stmt->execute(array($itemid));
					
					$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Recorde Updated" . "</div>";
					redirectHome($TheMsg,'back');
				}else{
					
					$TheMsg = "<div class='alert alert-danger'> This ID is Not Exist  </div>";
					redirectHome($TheMsg);
				}
				
				
			echo "</div>";

	}

	include $tpl . 'footer.php' ;

} else {

	header("Location: index.php");
	exit();
}	


ob_end_flush(); // Release The Output 


?>

