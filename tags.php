<?php
session_start();
 include 'init.php' ; ?>
 <div class="container">
	 	
	 	<div class="row">
	 	<?php
	 	if (isset($_GET['name'])) {
	 		$tag = $_GET['name'];
	 		echo "<h1 class='text-center'> " . $tag . " </h1>" ; 
	 		
	 		$tagItems = getAllFrom('*','items',"where tags like '%$tag%'",'AND Approve = 1','Item_ID');
	 		foreach( $tagItems as $item ){
	 			echo "<div class='col-sm-6 col-md-3'>";
	 				echo "<div class='thumbnail item-box'>";
	 					if($item['Approve'] == 0){echo "<span class='approve-status'>Waiting Approval  </span>" ;}
	 					echo "<span class='price-tag'> ".$item['Price']." </span>";
	 					echo "<img class='' src='layout/images/img.jpg' alt='' />";
	 					echo "<div class='caption'>";
	 						echo "<h3><a href='items.php?itemid=". $item['Item_ID'] ."'>". $item['Name']  ." </a></h3>";
	 						echo "<p>" . $item['Description'] . "</p>";
	 						echo "<div class='date'>" . $item['Add_Date'] . "</div>";
	 					echo "</div>";
	 				echo "</div>";
	 			echo "</div>";
	 		

	 		}
	 		
	 	}else{
	 		echo "<div class='alert alert-danger'> You You Must Enter Tag Name </div>";
	 	}
	 	?>
	 	</div>
</div>
<?php include $tpl . "footer.php "; ?>