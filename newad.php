
<?php
ob_start();
session_start();
$pageTitle = 'Create New Item';

 include 'init.php' ;

 if (isset($_SESSION['user'])) {


 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 	
 	$formErrors = array();

 	$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
 	$desc 		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
 	$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
 	$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
 	$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
 	$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
 	$tags 		= filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

 	if (strlen($name) < 4) {
 		$formErrors[] = "Item Title Must Be More Than 4 characters";
 	}

 	if (strlen($desc) < 10) {
 		$formErrors[] = "description Must Be More Than 10 characters";
 	}

 	if (strlen($country) < 2) {
 		$formErrors[] = "Country name Must Be More Than 2 characters";
 	}

 	if (empty($price)) {
 		$formErrors[] = "Item Price Must Be Not Empty";
 	}

 	if (empty($status)) {
 		$formErrors[] = "Item Status Must Be Not Empty";
 	}

 	if (empty($category)) {
 		$formErrors[] = "Category Must Be Not Empty";
 	}

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
				'zcat' 		=> $category,
				'zmember' 	=> $_SESSION['uid'],
				'ztags' 	=> $tags

			));	
				
			// Echo Success Message
			
			if ($stmt) {
				$successMsg = "item has Been Added" ;
			}
		}
 	}
?>

<h1 class="text-center"> <?php echo $pageTitle ; ?> </h1>

<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"> <?php echo $pageTitle ; ?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
							<!-- Start Name field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label">Name </label>
								<div class="col-sm-10 col-md-9">
									<input type="text" name="name" class="form-control live" data-class='.live-title'   placeholder="Name Of The Item" pattern=".{4,}" title="This Field Require At Least 4 Characters" required >
								</div>
							</div>
							<!-- End Name field -->

							<!-- Start Description field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label">Description </label>
								<div class="col-sm-10 col-md-9">
									<input type="text" name="description" class="form-control live" data-class='.live-desc'   placeholder="Description Of The Item" pattern=".{10,}" title="This Field Require At Least 10 Characters" required >
								</div>
							</div>
							<!-- End Description field -->

							<!-- Start Price field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label">Price </label>
								<div class="col-sm-10 col-md-9">
									<input type="text" name="price" class="form-control live" data-class='.live-price'   placeholder="Price Of The Item" required>
								</div>
							</div>
							<!-- End Price field -->

							<!-- Start Country field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label">Country </label>
								<div class="col-sm-10 col-md-9">
									<input type="text" name="country" class="form-control"  placeholder="Country Of Made"  >
								</div>
							</div>
							<!-- End Country field -->

							<!-- Start Status field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label">Status </label>
								<div class="col-sm-10 col-md-9">
									<select class="form-control" name="status" required>
										<option value="">...</option>
										<option value="1"> New </option>
										<option value="2"> Like New </option>
										<option value="3"> Used </option>
										<option value="4">Very Old</option>
									</select>
								</div>
							</div>
							<!-- End Status field -->
							
							<!-- Start Categories field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label">Category </label>
								<div class="col-sm-10 col-md-9">
									<select class="form-control" name="category" required>
										<option value="">...</option>
										<?php
											$cats = getAllFrom('*','categories','','','ID');
											foreach ($cats as $cat) {
												echo "<option value=".$cat['ID'] ." > ". $cat['Name']." </option>";
												
											}
										?>
									</select>
								</div>
							</div>
							<!-- End Categories field -->
							<!-- Start tags field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label">Tags : </label>
								<div class="col-sm-10 col-md-9">
									<input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma(,)"  >
								</div>
							</div>
							<!-- End tags field -->

							<!-- Start Button field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-3 col-sm-9 col-md-6">

									<input type="submit" value="Add Item" class="btn btn-primary btn-sm" >
								</div>
							</div>
							<!-- End Button field -->
						</form>
					</div>
					<div class="col-md-4">
						<div class='thumbnail item-box live-preview'>
	 						<span class='price-tag'> $<span class="live-price">0 </span> </span>
	 						<img class='' src='layout/images/img.jpg' alt='' />
	 						<div class='caption'>
	 							<h3 class="live-title">Title</h3>
	 							<p class="live-desc">Description</p>
	 						</div>
	 					</div>
					</div>
				</div>
				<!-- Start Looping Through Errors -->
					<?php 
						if (!empty($formErrors)) {
							foreach ($formErrors as $error) {
								echo "<div class='alert alert-danger'>" . $error . "</div>";
							}
						}

						if (isset($successMsg)) {
							echo "<div class='alert alert-success'> ". $successMsg ." </div>";
						}

					?>
				<!-- End Looping Through Errors -->
				
			</div>
		</div>
	</div>
</div>


<?php

}else{
	header('Location: login.php');
	exit();
}

include $tpl . "footer.php ";

ob_end_flush();

 ?>