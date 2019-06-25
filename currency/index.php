<?php

	require_once('dbconnect.php');
	
	$listCur	= '';
	
	// retrive all active countries with country code
	$sql 		= "SELECT currency_code FROM countries WHERE active='1'";
	$result 	= mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) 
	{
		// output data of active currencies
		while($row = mysqli_fetch_assoc($result))
		{
			$actvCur[]	=	$row[currency_code];
			$listCur   .=	$row[currency_code].',';
		}
	}
	
	// check existency in database
	if(isset($listCur) && $listCur != '') 
	{
		$exstCur 	= "SELECT cv_cur_code FROM bmd_currency_values";
		$resultt	= mysqli_query($con, $exstCur);
		if (mysqli_num_rows($resultt) > 0) 
		{
			// output data of exist currencies
			while($roww = mysqli_fetch_assoc($resultt))
			{
				$exstArr[]	=	$roww[cv_cur_code];
			}
		}
	}
	
	// set API Endpoint, Access Key, required parameters
	$endpoint	= 'live';
	$access_key = 'c9e398ba5326474e6f0c16a0111bf5bb';
	$cur		= $listCur.'USD';

	// initialize CURL:
	$ch = curl_init('http://apilayer.net/api/'.$endpoint.'?access_key='.$access_key.'&&currencies='.$cur.'&format=1');   
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// get the (still encoded) JSON data:
	$json = curl_exec($ch);
	//echo $json;
	curl_close($ch);

	// Decode JSON response:
	$conversionResult = json_decode($json, true);
	
	$jsonArr	=	$conversionResult[quotes]; // all currency values.
	
	$baseCur	=	$conversionResult[source]; // take code from json.
	
	if(isset($actvCur) && count($jsonArr) > 0 && $baseCur != '')
	{
		foreach($actvCur as $key => $value){
			
			if(isset($jsonArr[$baseCur.$value]))
			{
				if(in_array($value,$exstArr))
				{
					$curVal = $jsonArr[$baseCur.$value];
					mysqli_query($con,"UPDATE bmd_currency_values SET cv_cur_val='". round($curVal,2) ."' WHERE cv_cur_code='". $value ."'");			
				}
				else
				{
					$curVal = $jsonArr[$baseCur.$value];
					mysqli_query($con,"INSERT INTO bmd_currency_values (cv_base, cv_cur_code, cv_cur_val) VALUES ('". $baseCur ."','". $value ."','". round($curVal,2) ."')");				
				}
			}
		}
	}
	mysqli_close($con);
	
?>