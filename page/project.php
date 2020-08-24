<?php
	session_start();
	if(!isset($_SESSION["sess_name"])){
		header("Location: login.php");
	}
	if(isset($_POST['btn-submit']))
	{
		$host = "localhost"; /* Host name */
		$user = "root"; /* User */
		$password = ""; /* Password */
		$dbname = "user_data"; /* Database name */
		
		$con = mysqli_connect($host, $user, $password,$dbname);
		// Check connection
		if (!$con) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$client_name = mysqli_real_escape_string($con,$_POST['cli_nam']);
		$client_number = mysqli_real_escape_string($con,$_POST['cli_num']);
		$client_money = mysqli_real_escape_string($con,$_POST['cli_mon']);
		if($client_name == ""){
			echo '<script>alert("please enter client name")</script>';
		}
		if($client_number == ""){
			echo '<script>alert("please enter client Mobile Number")</script>';
		}
		if($client_money == ""){
			echo '<script>alert("please enter Fix amount")</script>';
		}
		else{
			$sql = "INSERT INTO client_tbl (client_name,mobile_no,money) VALUES ('$client_name',$client_number,$client_money)";
			$result = mysqli_query($con, $sql);
			if ($result)
        	{
				echo '<script>alert("Client inserted")</script>';
				header('Location: buyer.php');
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<link rel="manifest" href="manifest.json">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Insert</title>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:700, 600,500,400,300' rel='stylesheet'
		type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<style type="text/css">
		* {
			box-sizing: border-box;
		}
		body {
			margin: 0;
			padding: 0;
			font-family: 'Source Sans Pro', sans-serif;
			background-color: #d5dae5;
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
		}
		.header {
			position: absolute;
			width: 100%;
			z-index: 3;
			height: 44px;
			background-color: #fff;
			border-bottom: 3px solid #2d3d51;
		}
		/* logo in header(mobile version) and side-nav (tablet & desktop) */
		.logo {
			height: 44px;
			padding: 10px;
			font-weight: 700;
		}
		.header .logo {
			color: #233245;
		}
		.side-nav .logo {
			background-color: #233245;
			color: #fff;
		}
		.header .logo {
			float: left;
		}
		.header .logo {
			height: 44px;
			z-index: 1;
			padding: 10px;
			font-weight: 700;
			color: #233245;
		}
		.logo  i {
			font-size: 22px;
		}
		.logo span {
			margin-left: 5px;
			text-transform: uppercase;
		}
		.nav-trigger {
			position: relative;
			float: right;
			width: 20px;
			height: 44px;
			right: 30px;
			display: block;	
		}
		.nav-trigger span, .nav-trigger span:before, span:after {
			width: 20px;
			height: 2px;
			background-color: #35475e;
			position: absolute;
		}
		.nav-trigger span {
			top: 50%;
		}
		.nav-trigger span:before, .nav-trigger span:after {
			content: '';
		}
		.nav-trigger span:before {
			top: -6px;
		}
		.nav-trigger span:after {
			top: 6px;
		}
		/* side navigation styles */
		.side-nav {
			position: absolute;
			width: 100%;
			height: 100vh;
			background-color: #35475e;
			z-index: 1;
			display: none;
		}
		.side-nav.visible {
			display: block;
		}
		.side-nav ul {
			margin: 0;
			padding: 0;
		}
		.side-nav ul li {
			padding: 16px 16px;
			border-bottom: 1px solid #3c506a;
			position: relative;
		}
		.side-nav ul li.active:before {
			content: '';
			position: absolute;
			width: 4px;
			height: 100%;
			top: 0;
			left: 0;
			background-color: #fff;
		}
		.side-nav ul li a {
			color: #fff;
			display: block;
			text-decoration: none;
		}
		.side-nav ul li i {
			color: #0497df;
			min-width: 20px;
			text-align: center;
		}
		.side-nav ul li span:nth-child(2) {
			margin-left: 10px;
			font-size: 14px;
			font-weight: 600;
		}
		/* main content styles */
		.main-content {
			padding: 40px;
			margin-top: 0;
			padding: 0;
			padding-top: 44px;
			height: 100%;
		}
		.main-content .title {
			background-color: #eef1f7;
			border-bottom: 1px solid #b8bec9;
			padding: 10px 20px;
			font-weight: 700;
			color: #333;
			font-size: 18px;
		}
		.main input[type=text]{
			width:200px;
			margin-left:60px;
			margin-top:10px;
			border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
            font-family:'Comic Sans MS';
			font-size:13px;
			height:30px;
			padding-left:10px;
			margin-bottom:10px;
		}
		.main input[type=submit]{
			border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
			height:30px;
			margin-left:5px;
			margin-bottom:10px;
		}
		/* set element styles to fit tablet and higher(desktop) */
		@media screen and (min-width: 600px) {
			.header {
				background-color: #35475e;
				z-index: 1;
			}
			.header .logo {
				display: none;
			}
			.nav-trigger {
				display: none;
			}
			.nav-trigger span, .nav-trigger span:before, span:after {
				background-color: #fff;
			}
			.side-nav {
				display: block;
				width: 100px;
				z-index: 2;
			}
			.side-nav ul li span:nth-child(2) {
				display: none;
			}
			.side-nav .logo i {
				padding-left: 12px;
			}
			.side-nav .logo span {
				display: none;
			}
			.side-nav ul li i {
				font-size: 26px;
			}
			.side-nav ul li a {
				text-align: center;
			}
			.main-content {
				margin-left: 100px;
			}
		}
		/* set element styles for desktop */
		@media screen and (min-width: 800px) {
			.side-nav {
				width: 200px;
			}
			.side-nav ul li span:nth-child(2) {
				display: inline-block;
			}
			.side-nav ul li i {
				font-size: 16px;
			}
			.side-nav ul li a {
				text-align: left;
			}
			.side-nav .logo i {
				padding-left: 0;
			}
			.side-nav .logo span {
				display: inline-block;
			}
			.main-content {
				margin-left: 200px;
			}
		}
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 50%;
			margin-left: 20px;
			margin-top: 20px;
			margin-bottom: 10px;
		}

		td, th {
			border: 1px solid black	;
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}
	</style>
	<script>
		$(document).ready(function() {
		$('.nav-trigger').click(function() {
		$('.side-nav').toggleClass('visible');
	});
});
	</script>
	</head>
	<body>
		<div class="header">
			<div class="logo">
				<i class="fa fa-tachometer"></i>
				<span>Kairav</span>
			</div>
			<a href="#" class="nav-trigger"><span></span></a>
		</div>
		<div class="side-nav">
			<div class="logo">
				<i class="fa fa-tachometer"></i>
				<span>Kairav</span>
			</div>
			<nav>
				<ul>
					<li>
						<a href="index.php">
							<span>DashBorad</span>
						</a>
                    </li>
                    <li>
						<a href="insert.php">
							<span>Product Handler</span>
						</a>
                    </li>
                    <li class="active">
						<a href="buyer.php">
							<span>Buyer</span>
						</a>
					</li>
					<li>
						<a href="logout.php">
							<span>Logout</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>
		<div class="main-content">
			<div class="title">
				client management
        	</div>
		
        <div class="main">
			<div class="panel panel-default" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#collapse2">Client Data</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse">
					<!---->
					<?php
						$host = "localhost"; /* Host name */
						$user = "root"; /* User */
						$password = ""; /* Password */
						$dbname = "user_data"; /* Database name */
				
						$con = mysqli_connect($host, $user, $password,$dbname);
						// Check connection
						if (!$con) {
							die("Connection failed: " . mysqli_connect_error());
						}
						$result = mysqli_query($con,"SELECT * FROM client_tbl where client_id = '" . $_GET['client_id'] . "'");
					?>
					<table>
						<tr>
							<td>Client Id</td>
							<td>Client Name</td>
							<td>Contact Number</td>
							<td>Fix amount</td>
							<td>Remaining amount</td>
						</tr>
						<?php
							$i=0;
							while($row = mysqli_fetch_array($result)) {
						?>
						<tr>
							<td><?php echo $row["client_id"]; ?></td>
							<td><?php echo $row["client_name"]; ?></td>
							<td><?php echo $row["mobile_no"]; ?></td>
							<td><?php echo $row["money"]; ?></td>
						</tr>
						<?php
							$i++;
							}
						?>
					</table>
				</div>
			</div>
        </div>
        <div class="sec">
            <div class="panel panel-default" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
			    <div class="panel-heading">
				    <h4 class="panel-title">
					    <a data-toggle="collapse" href="#collapse3">Project TODO</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse">
                        <p>asd</p>
                </div>
        </div>
	</body>
</html>