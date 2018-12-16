<?php

	$dsn = "mysql:host=localhost;dbname=shop";  // data source name 
	$user ='root';
	$pass = '';
	$option = array(

		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', // to make it support Arabic and english

	);


	try{

		$con = new PDO($dsn,$user,$pass,$option); // connect to data base
		$con ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to activate error exception if found
	}

	catch(PDOException $e){   //catch the erorr if  found

		echo "Faild Connect" . $e->getMessage();

	}