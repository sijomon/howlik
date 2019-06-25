<?php

	
	$filename	=	$_SERVER['DOCUMENT_ROOT']."/.env";
	
	$_ENV		=	array();
	$handle 	=	fopen($filename, "r");
	if($handle) 
	{
		while (($line = fgets($handle)) !== false) 
		{
			if( strpos($line,"=") !== false) 
			{
				$var = explode("=",$line);
				$_ENV[$var[0]] = trim($var[1]);
			}
		}
		fclose($handle);
	} 
	else 
	{
		die('error opening .env'); 
	}
	
	// // Get the required codes from the configuration file
	$server 	= $_ENV['DB_HOST'];
	$username   = $_ENV['DB_USERNAME'];
	$password   = $_ENV['DB_PASSWORD'];
	$database	= $_ENV['DB_DATABASE'];

	
	$con = new mysqli($server,$username,$password,$database);
	if (!$con){
		die('Could not connect: ' . mysqli_connect_error($con));
	}
	
?>