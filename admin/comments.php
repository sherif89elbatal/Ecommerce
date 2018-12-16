<?php

    /*
    ===========================================
    == mange Comments page
    == You Can Edit | Delete | Approve Comments From Here 
    ===========================================
    */
    
    session_start();
	$pageTitle = 'Comments';
	if(isset($_SESSION['Username'])){
		
		include 'init.php';
		
        $do = isset($_GET['do'])? $_GET['do'] : 'manage';  // Short if operator :)
        
        // Start Manage Page
		
        
        if($do == 'manage'){// manage page
			
			 // Select All users Except Admins
			 
			$stmt = $con->prepare("SELECT 
										comments.*, items.Name AS Item_Name, users.Username AS Member
								   FROM 
								   		comments
								   INNER JOIN
								   		items
								   ON
								   		items.Item_ID = comments.Item_ID
							   		INNER JOIN 
							   			users
						   			ON 
						   				users.UserID = comments.User_ID
					   				ORDER BY
					   					C_ID DESC
								   ");
			
			// Execute The Statement
			
			$stmt->execute();
			
			// fetch All users And Assign To Variables
			
			$comments = $stmt ->fetchAll();
			
			if(! empty($comments)){

			?>
            
			<h1 class="text-center"> Manage Comments  </h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Added Date </td>
							<td>Control</td>
						</tr>
						<?php
							
							foreach($comments as $comment){
								
								echo "<tr>";
									echo "<td>". $comment['C_ID'] . "</td>";
									echo "<td>". $comment['Comment'] . "</td>";
									echo "<td>". $comment['Item_Name'] . "</td>";
									echo "<td>". $comment['Member'] . "</td>";
									echo "<td>". $comment['Comment_Date'] ."</td>";
									echo "<td> <a class='btn btn-success' href='comments.php?do=Edit&comid=". $comment['C_ID'] ." '><i class='fa fa-edit'></i> Edit </a>
											   <a class='btn btn-danger confirm' href='comments.php?do=Delete&comid=". $comment['C_ID'] ." '><i class='fa fa-close'></i> Delete </a> ";
												
											   if ($comment['status'] == 0) {
											   	echo "<a class='btn btn-info ' href='comments.php?do=Approve&comid=". $comment['C_ID'] ." '><i class='fa fa-check'></i> Approve </a> ";
											   }

								echo "</td>";
									
								echo "</tr>";
								}	
						

						?>
					</table>
				</div>
				
			</div>
		
		<?php }else{

			echo "<div class='container'>";
				echo "<div class='nice-message' > There's No Comments To Show </div>";
			echo "</div>";

		}?>


		<?php
			
        }elseif ($do == 'Edit'){ // Edite page
			
			// check if GET Request comid is numeric and  GET  the integer value of it
			
			$comid = isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
			
			// SElECT All data from DATABase Depend on This ID 
			
			$stmt = $con->prepare("SELECT * FROM comments WHERE C_ID= ? ");
			
			// Execute  Query 
			
			$stmt->execute(array($comid));
			
			// fetch the Data
			
			$row = $stmt->fetch();
			
			// The Row Count
			
			$count = $stmt->rowCount();
			
			// Check if there is find Id  Show The Form
			
			if( $count > 0 ){ ?>
				
				<h1 class="text-center"> Edit Comment </h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="comid" value="<?php echo $comid ?> "/>
						<!-- Start Comment field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Comment : </label>
							<div class="col-sm-10 col-md-6">

								<textarea class="form-control" name="comment"> <?php echo $row['Comment'];?> </textarea>

							</div>
						</div>
						<!-- End Comment field -->
						
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
			
			echo '<h1 class="text-center"> Update Comment </h1>' ;
			echo '<div class="container">' ;
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				// Get variables from the Form
				
				$comid 	=  $_POST['comid'];
				$comment 	=  $_POST['comment'];
				 
				
					// update The Database with this Info
					
					$stmt = $con ->prepare("UPDATE comments SET Comment = ? WHERE C_ID = ?");
					
					$stmt->execute(array($comment, $comid));
					
					
					// Echo Success Message
					$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Record Updated" . "</div>";
					
					redirectHome($TheMsg, 'back');
				
				
			}else{
				
				$TheMsg = " <div class= 'aler alert-danger '> You Cant Browse this Page Directly </div>";
				
				redirectHome($TheMsg );
			}
			
			echo "</div>" ;
			
		 }elseif ($do == 'Delete') { // Delete Comments Page
			
			echo '<h1 class="text-center"> Delete Comment </h1>' ;
			echo '<div class="container">' ;
				
				// check if GET Request comid is numeric and  GET  the integer value of it
				
				$comid = isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
				
				// SElECT All data from DATABase Depend on This ID
				
				//$stmt = $con->prepare("SELECT * FROM users WHERE UserID= ? LIMIT 1"); I used the function checkItem  instad of this :)
				
				 $check = checkItem('C_ID', 'comments', $comid);
				
				// Execute  Query

				//$stmt->execute(array($userid)); I used the function checkItem instad of this :)
				
				// The Row Count
				
				//$count = $stmt->rowCount(); I used the function checkItem instad of this :)
				
				// Check if there is find Id  Show The Form
				
				
				if( $check > 0 ){ 
					
					
					$stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zid ");
					
					$stmt->bindParam(":zid", $comid);
					
					$stmt->execute();
					
					// Echo Success Message
					
					$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Delete Updated" . "</div>";
					redirectHome($TheMsg,'back');
				}else{
					
					$TheMsg = "<div class='alert alert-danger'> This ID is Not Exist  </div>";
					redirectHome($TheMsg);
				}
				
				
			echo "</div>";
			
		}elseif ( $do='Approve') {  // Approve Page

			echo '<h1 class="text-center"> Approve Comment </h1>' ;
			echo '<div class="container">' ;
				
				// check if GET Request comid is numeric and  GET  the integer value of it
				
				$comid = isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
				
				// SElECT All data from DATABase Depend on This ID
				
				 $check = checkItem('C_ID', 'comments', $comid);
				
				// The Row Count
				
				// Check if there is find Id  Show The Form
				
				if( $check > 0 ){ 
					
					$stmt = $con->prepare("UPDATE comments SET status = 1 WHERE C_ID =? ");
					
					$stmt->execute(array($comid));
					
					$TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount()." Recorde Approved" . "</div>";
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


