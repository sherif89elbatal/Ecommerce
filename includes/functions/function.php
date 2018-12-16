<?php


/*
** Get  All function V2.0
** function to All Records From Database
*/

function getAllFrom($field , $table , $where = NULL, $and = NULL, $orderfield, $ordering = "DESC" ) {

	global $con ;

	$getAll = $con->prepare("SELECT $field From $table $where $and ORDER BY $orderfield $ordering ");

	$getAll->execute();

	$all = $getAll->fetchAll();

	return $all;

}



/*
** Get  categories function
** function to get Categories From Database
*/

function getCat() {

	global $con ;

	$getCat = $con->prepare("SELECT * From categories  ORDER BY ID ASC");

	$getCat->execute();

	$cats = $getCat->fetchAll();

	return $cats;

}

/*
** Get  Ad items function
** function to get AD items From Database
*/

function getItem($where , $value, $approve = NULL) {

	global $con ;

	$sql = $approve == NULL ? 'AND Approve = 1' : '' ;   // Short  IF 

	$getItems = $con->prepare("SELECT * From items WHERE $where = $value $sql ORDER BY Item_ID DESC");

	$getItems->execute(array($value));

	$items = $getItems->fetchAll();

	return $items;

}




/*
** Check if User Is Not Activated
** function To Check The RegStatus of The User
*/

function checkUserStatus($user){

	 global $con ;

	//check if the user exist in Database

 	$stmtx = $con->prepare("SELECT  Username, Password FROM users WHERE Username = ? AND RegStatus = 0");
		
 	$stmtx->execute(array($user));
 	
 	$status = $stmtx->rowCount();

 	return $status;

}






/*
    **Title function that echo the page title in case page has the variable called $pageTitle
*/

function getTitle(){
    
    global $pageTitle;
    
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        
        echo 'Default';
        
    }
}


 // Check item function , Function to check items in Database

 function checkItem($select, $from , $value ){

 	global $con ; 

 	$statment = $con->prepare("SELECT $select From $from WHERE $select = ?" );

 	$statment-> execute(array($value));

 	$count = $statment->rowCount();

 	return $count;
 }











/*
** Redirect Function [ This function Accepte Prameters]
** $ErrorMsg = Echo Error Message 
** $seconds = Seconds Before Redirecting
*/

function redirectHome($TheMsg , $url = null , $seconds = 3 ){

	if ($url === null) {
		
		$url= "index.php";
		$link = "HomePage";

	}else{
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ) {
			
			$url = $_SERVER['HTTP_REFERER'] ;
			
			$link = "Previous Page ";
		}else{

			$url = "index.php";
			
			$link = "HomePage";
		}
	}
	echo  $TheMsg ;
	echo "<div class='alert alert-info'> You will Be redirect to $link After ". $seconds ." Seconds  </div>";
	header("refresh:$seconds;url=$url");
	exit(); 
}



/*
** Count Numbers of Items function 
** function to count Numbers of Items Rows
** $item = The Item To Count
** $table = The table To Choose From
*/

function countItems($item,$table){

	global $con ;

	$stmt2 = $con->prepare("SELECT Count($item) FROM $table");

	$stmt2->execute();

	return $stmt2->fetchColumn(); // fetchColumn its a function will fetch the Column from database

}


/*
** Get Latest Records function
** function to get Latest Items From Database [Users, Items, Comments]
** $select = Field to select
** $table  = the table to choose from
** $order  = Desc Ordering
** $limit  = Number of Records To Get
*/

function getLatest($select, $table, $order, $limit = 5 ) {

	global $con ;

	$getStmt = $con->prepare("SELECT $select From $table  ORDER BY $order DESC LIMIT $limit");

	$getStmt->execute();

	$rows = $getStmt->fetchAll();

	return $rows;

}






