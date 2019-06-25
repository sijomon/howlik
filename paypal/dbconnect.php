<?php
// // Get the required codes from the configuration file
$server = "localhost";
$username   = "root";
$password   = "12345";
$database	="test";


$con = new mysqli($server,$username,$password,$database);
if (!$con){
die('Could not connect: ' . mysqli_connect_error($con));
}




/*
CREATE TABLE IF NOT EXISTS `infotuts_transection_tbl` (
  `TID` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `payer_email` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `amount` float NOT NULL,
  `currency` varchar(50) NOT NULL,  
  `country` varchar(50) NOT NULL,
  `txn_id` varchar(100) NOT NULL,
  `txn_type` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `payment_metod` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL,
  `payment_date` datetime NOT NULL,
  PRIMARY KEY (`TID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

**/
// if (mysqli_query($con,$tbl)) {
  // echo "Table persons created successfully";
// } else {
  // echo "Error creating table: " . mysqli_error($con);
// }


?>