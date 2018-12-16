<?php


function lang($phrase){

	static $lang =array(

		// Navbar links 

		'HOME_ADMIN' 		=> "HOME",
		'CATEGORIES'	    => "Categories",
		'ITEMS'				=> "items",
		'MEMBERS'			=> "Members",
		'COMMENTS'			=> "Comments",
		'STATISTICS'		=> "Statistics",
		'LOGS'				=> "Logs",
		''					=> "",
		''					=> "",
		''					=> ""

	);

	return $lang[$phrase];

}
