<?php 

/*
=======================================
== Template Page
=======================================
*/

ob_start(); // Output Buffering Start 

session_start();

$pageTitle='';


if (isset($_SESSION['Username'])) {
		
	include 'init.php';
	
	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

	if ($do == 'manage') {
			
		echo "Welcome";

	}elseif ($do == 'Add') {
		
		echo "Add page";

	}elseif ($do == 'Insert' ) {
		

	}elseif ($do == 'Edit') {
		

	}elseif ($do == 'Update'){


	}elseif ($do == 'Delete'){


	}elseif ($do == 'Activate'){


	}

	include $tpl . 'footer.php' ;

} else {

	header("Location: index.php");
	exit();
}	


ob_end_flush(); // Release The Output 


?>

