
<?php


include "connect.php";  // conection with database file

// Routes

$tpl = 'includes/templates/' ; // templates Directory
$lang = 'includes/languages/'; // language Directory
$css = 'layout/css/' ; // css Directory
$func = 'includes/functions/'; // functions Directory
$js = 'layout/js/' ; // js Directory



//iclude the important files
include $func .'function.php';
include $lang . 'english.php';
include $tpl . "header.php ";

//include the navbar in All pages except the one which have variable called $noNavbar

if (!isset($noNavbar)) {
	
	include $tpl . "navbar.php ";
}




