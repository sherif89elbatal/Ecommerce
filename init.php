
<?php

// Error Reporting

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include "admin/connect.php";  // conection with database file

$sessionUser = '';

if (isset($_SESSION['user'])) {
	$sessionUser = $_SESSION['user'];
}

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





