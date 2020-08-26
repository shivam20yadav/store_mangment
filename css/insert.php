<?php
	session_start();
	if(!isset($_SESSION["sess_name"])){
		header("Location: login.php");
	}

   	if(isset($_POST['btn_submit'])){
		$host = "localhost"; /* Host name */
		$user = "root"; /* User */
		$password = ""; /* Password */
		$dbname = "user_data"; /* Database name */

		$con = mysqli_connect($host, $user, $password,$dbname);
		// Check connection
		if (!$con) {
 			die("Connection failed: " . mysqli_connect_error());
		}
		
		$pro_name = mysqli_real_escape_string($con,$_POST['pro_nam']);
		$pro_qty = mysqli_real_escape_string($con,$_POST['pro_qty']);
		if($pro_name == ""){
			echo '<script>alert("please enter product name")</script>';
		}
		else{
			$sql = "select count(*) as pro from invt_tbl where product_name ='".$pro_name."'";
        	$result = mysqli_query($con,$sql);
        	$row = mysqli_fetch_array($result);
        	$count = $row['pro'];

        	if($count > 0){
				echo '<script>alert("Product already exist if you want to update go update tab ")</script>'; 
				header('Location: insert.php');
        	}
		}
		if($pro_qty == ""){
			echo '<script>alert("please enter product quantity")</script>';
		}
		else{
			$sql = "INSERT INTO invt_tbl (product_name, qty) VALUES ('$pro_name','$pro_qty')";
			$result = mysqli_query($con, $sql);
			if ($result)
        	{
            	echo '<script>alert("Product inserted")</script>';
        	}
		}
   }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Product Handler</title>
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:700, 600,500,400,300' rel='stylesheet'
		type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

		<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/data.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<link rel="manifest" href="manifest.json">
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
		.main input[type=text]{
			width:200px;
			margin-left:80px;
			margin-top:10px;
			border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
            font-family:'Comic Sans MS';
			font-size:13px;
			height:30px;
			padding-left:10px;
		}
		.main form{
			background-color:#9adab1;
		}
		.main input[type=submit]{
			width:200px;
			margin-top:10px;
			margin-left:80px;
			margin-bottom:10px;
			border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
			border-top-right-radius:7px;
			background-color:#5db95d;
			font-family:'Comic Sans MS';
		}
		.sec table{
			margin-bottom:10px;
			margin-left:50px;
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
			.main input[type=text]{
				display:inline-block;
				margin-left:20px;
				height:30px;
				font-size:18px;
				padding-bottom:5px;
			}
			.main input[type=submit]{
				margin-left:20px;
				font-size:20px;
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
			.main input[type=text]{
				display:inline-block;
			}
		}
		table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 50%;
		margin-left: 20px;
		margin-top: 20px;
		
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
                    <li class="active">
						<a href="insert.php">
							<span>Product Handler </span>
						</a>
                    </li>
                    <li>
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
				Insert
        </div>
        <div class="main">
			<div class="panel panel-default" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#collapse1">Insert Inventory</a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse">
					<!---->
					<form method="POST">
						<input type=text placeholder="insert product name" name="pro_nam" required>
						<input type=text placeholder="Product quantity "name="pro_qty" required>
						<input type=submit value="Insert" name="btn_submit">
					</form>			
				</div>
			</div>
        </div>
		<div class = "sec">
		<div class="panel panel-default" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#collapse3">Inventory data</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse">
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
						$result = mysqli_query($con,"SELECT * FROM invt_tbl");
					?>
					<table>
						<tr>
							<td>Prodcut Id</td>
							<td>Product Name</td>
							<td>qty</td>
						</tr>
						<?php
							$i=0;
							while($row = mysqli_fetch_array($result)) {
						?>
							<tr class="<?php if(isset($classname)) echo $classname;?>">
							<td><?php echo $row["product_id"]; ?></td>
							<td><?php echo $row["product_name"]; ?></td>
							<td><?php echo $row["qty"]; ?></td>
							</tr>
						<?php
							$i++;
						}
						?>
					</table>
				</div>
			</div>
        </div>
        <div class = "thi">
		<div class="panel panel-default" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#collapse2">Update Inventory</a>
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
						$result = mysqli_query($con,"SELECT * FROM invt_tbl");
					?>
					<table style="margin-bottom:10px;">
						<tr>
							<td>Prodcut Id</td>
							<td>Product Name</td>
							<td>qty</td>
							<td>action</td>
						</tr>
						<?php
							$i=0;
							while($row = mysqli_fetch_array($result)) {
						?>
							<tr class="<?php if(isset($classname)) echo $classname;?>">
							<td><?php echo $row["product_id"]; ?></td>
							<td><?php echo $row["product_name"]; ?></td>
							<td><?php echo $row["qty"]; ?></td>
							<td><a href="update.php?product_id=<?php echo $row["product_id"]; ?>">Update</a></td>
							</tr>
						<?php
							$i++;
						}
						?>
					</table>
				</div>
			</div>
        </div>
	</body>
</html>