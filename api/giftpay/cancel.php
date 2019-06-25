<!DOCTYPE html>
<html lang="en">
	<head>
		<title> Howlik </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
			.payment-result-section{
				float:left;
				position:relative;
				width:100%;
				height:auto;
			}
			.payment-result-box{
				width:350px;
				height:auto;
				position:relative;
				margin:100px auto;
				text-align:center;
				padding:50px 30px 15px;
			}
			.payment-result-box-fail{
				background: linear-gradient(180deg, #F50057, #AD1457);
			}
			.payment-result-box-success{
				background: linear-gradient(180deg, #00f5ea, #1475ad);
			}
			.payment-result-box .status-icon{
				color:#FFF;
				font-size:40px;
				padding:10px;
				border:1px solid #fff;
				border-radius:100px;
			}
			.payment-result-box .status-icon2{
				color:#FFF;
				font-size:40px;
				padding:10px 20px;
				border:1px solid #fff;
				border-radius:100px;
			}
			.payment-result-box p{
				margin-top:50px;
				font-size:16px;
			}
			.btn-prb1{
				background:#F50057;
				border-radius:0 !important;
				color:#ccc;
				text-transform:uppercase;
				padding:8px !important;
				box-shadow:3px 3px 0px 0px #000;
				transition:ease-in-out .5s;
			}
			.btn-prb1:focus{
				box-shadow:none;
			}
			.btn-prb2{
				background:#fff;
				border-radius:0 !important;
				position:relative;
				top:53px;
				box-shadow:0 10px 10px #ccc;
				color:#212121;
				padding:10px !important;
			}
			.btn-sucs{
				background:#1475ad;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="payment-result-section">
					<div class="payment-result-box payment-result-box-fail"> <span class="fa fa-exclamation status-icon2"></span>
						<p> Transaction Canceled </p>
						<hr width="80%" style="margin:30px 10% 30px">
						<a href="http://www.howlik.com/<?php echo $_GET[lang]; ?>/account" role="button" class="btn btn-block btn-prb1"> Back To Home </a>
						<a href="http://www.howlik.com/<?php echo $_GET[lang]; ?>/create/<?php echo $_GET[id]; ?>/certificate" role="button" class="btn btn-block btn-prb2"> Try Again </a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>