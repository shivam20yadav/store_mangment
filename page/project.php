<?php
	session_start();
	if(!isset($_SESSION["sess_name"])){
		header("Location: login.php");
	}
	function fetch_data()  
 	{  
		$output = '';  
		$output2 = ''; 
		$connect = mysqli_connect("localhost", "root", "", "user_data");  
		  
		$sql = "SELECT * FROM payment where client_id= '". $_GET['client_id'] ."'";    
      	$result = mysqli_query($connect, $sql);  
      	while($row = mysqli_fetch_array($result))  
      	{       
        	$output .= '<tr>   
								<td>'.$row["date"].'</td>  
								<td style="color:red">'.$row["debit"].'</td>
                          		<td style="color:green">'.$row["credit"].'</td>  
                          		<td>'.$row["remark"].'</td>  
                     	</tr> 
                          ';  
		}  

		$result2 = mysqli_query($connect, "SELECT SUM(credit) AS abcd FROM payment where client_id = '". $_GET['client_id'] ."'"); 
    	$result3 = mysqli_query($connect, "SELECT SUM(debit) AS efgh FROM payment where client_id = '". $_GET['client_id'] ."'");  
		
		$row1 = mysqli_fetch_assoc($result2);  
		$row2 = mysqli_fetch_assoc($result3); 
		
		$d = $row1['abcd'];
		$sum = $row2['efgh'];
		$pro = $d - $sum;
		if ($pro < 0){
			$color="color:red";
		}	
		if($pro > 0){
			$color="color:green";
		}	
		$output .='<tr><td></td><td></td><td></td><td></td></tr><tr><td>TRANSACTION TOTAL</td><td>'.$sum.'</td><td> '.$d.'</td><td></td></tr><tr><td>PROFIT</td><td style='.$color.'>'.$pro.'</td></tr>';
		
		return $output;
		
 	}  
 	
 	if(isset($_POST["create_pdf"]))  
 	{ 
		$connect = mysqli_connect("localhost", "root", "", "user_data");  
    	$result = mysqli_query($connect, "SELECT client_name AS value_sum FROM client_tbl where client_id = '" . $_GET['client_id'] . "'");  
		$row = mysqli_fetch_assoc($result);
		$sum = $row['value_sum'];

		require_once('tcpdf.php');  
    	$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      	$obj_pdf->SetCreator(PDF_CREATOR);  
      	$obj_pdf->SetTitle('Client Name:- "'.$sum.'"');  
      	$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      	$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		$obj_pdf->SetDefaultMonospacedFont('helvetica');  
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
		$obj_pdf->setPrintHeader(false);  
		$obj_pdf->setPrintFooter(false);  
		$obj_pdf->SetAutoPageBreak(TRUE, 10);  
		$obj_pdf->SetFont('helvetica', '', 12);  
		$obj_pdf->AddPage();  
		$content = '';  
		$content .= '  
		<h3 align="center">balance sheet</h3><br /><br />  
		<table border="1" cellspacing="0" cellpadding="5">  
			<tr>  
				<th width="35%">Date</th>  
				<th width="25%">debit</th>  
				<th width="25%">credit</th>  
				<th width="20%">remark</th>  
			</tr>  
		';  
		$content .= fetch_data();  
		$content .= '</table>';  
		$obj_pdf->writeHTML($content);  
		$obj_pdf->Output('"'.$sum.'".pdf', 'I');  
 	}  
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<link rel="manifest" href="manifest.json">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Insert</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

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
							<span>DashBoard</span>
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
								<td>Action</td>
							</tr>
							<?php
								$i=0;
								while($row = mysqli_fetch_array($result)) {
							?>
							<tr>
								<td><?php echo $row["client_id"]; ?></td>
								<td><?php echo $row["client_name"]; ?></td>
								<td><?php echo $row["mobile_no"]; ?></td>
								<td><a href="clupdate.php?client_id=<?php echo $row["client_id"]; ?>">Update</a></td>
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
					    	<a data-toggle="collapse" href="#collapse3">Remaining Tasks</a>
						</h4>
					</div>
					<div id="collapse3" class="panel-collapse collapse">
                    	<div class="container box">
                        	<div class="table-responsive">
                            	<br />
                            	<div align="right">
                                	<button type="button" name="add" id="add" class="btn btn-info">Add</button>
                            	</div>
                            	<br />
                            	<div id="alert_message"></div>
                                <table id="data" class="table table-bordered table-striped">
                                   	<thead>
                                       	<tr>
                                           	<th>Date of Creation</th>
                                           	<th>Date of Ending</th>
                                           	<th>subject</th>
                                           	<th>Status</th>
                                           	<th>Remark</th>
											<th>Action</th>
                                       	</tr>
                                   	</thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="thr" id="thr">
            	<div class="panel panel-default" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
			    	<div class="panel-heading">
				    	<h4 class="panel-title">
					    	<a data-toggle="collapse" href="#collapse4">Completed task</a>
						</h4>
					</div>
					<div id="collapse4" class="panel-collapse collapse">
                    	<div class="container box">
                        	<div class="table-responsive">
                            	<br />
                            	<div id="alert_message"></div>
                                <table id="data_comp" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date of Creation</th>
                                            <th>Date of Ending</th>
                                            <th>subject</th>
                                            <th>Status</th>
                                            <th>Remark</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="for">
            	<div class="panel panel-default" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
			    	<div class="panel-heading">
				    	<h4 class="panel-title">
					    	<a data-toggle="collapse" href="#collapse5">Payment Sheet</a>
						</h4>
					</div>
					<div id="collapse5" class="panel-collapse collapse">
                    	<div class="container box">
                        	<div class="table-responsive">
                            	<br />
                            	<div align="right">
                                	<button type="button" name="add" id="add_pay" class="btn btn-info">Add</button>
                            	</div>
                            	<br/>
                                <table id="data_payment" class="table table-bordered table-striped">
                                   	<thead>
                                       	<tr>
                                           	<th>Date</th>
                                           	<th>Debit</th>
                                           	<th>Credit</th>
                                           	<th>Remark</th>
											<th>Action</th>
                                       	</tr>
                                   	</thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="main">
				<div class="panel panel-default" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse6">Client Data</a>
						</h4>
					</div>
					<div id="collapse6" class="panel-collapse collapse">
						<!---->
						<div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="10%">Date</th>  
                               <th width="15%">Debit</th>  
                               <th width="15%">Credit</th>  
                               <th width="10%">remark</th>  
                          </tr>  
                     <?php  
                     echo fetch_data();  
                     ?>
                     </table> 
                </div> 
                     <br />  
                     <form method="post">  
                          <input type="submit" name="create_pdf" class="btn btn-danger" value="Create PDF" />  
                     </form> 
					</div>
				</div>
        	</div>

        </div>
 </body>
 </html>
 <?php 
	function add(){
		return $_GET['client_id'];
	  }
 ?>

<script type="text/javascript" language="javascript" >
	var id = <?php echo add();?>;
	$(document).ready(function()
	{
		fetch_data();
		function fetch_data()
		{
			var dataTable = $('#data').DataTable({
				"processing" : true,
				"serverSide" : true,
				"order" : [],
				"ajax" : {
					url:"get.php",
					method:"POST",
					data:{id:id}
				}
			});
		}		
		function update_data(todo_id, column_name, value)
  		{
			  
   			$.ajax({
    		url:"update.php",
    		method:"POST",
    		data:{todo_id:todo_id, column_name:column_name, value:value},
    		success:function(data)
    		{
     			$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     			$('#data').DataTable().destroy();
     			fetch_data();
    		}
   			});
   			setInterval(function(){
    			$('#alert_message').html('');
   			}, 5000);
  		}
		$(document).on('blur', '.update', function(){
   			var todo_id = $(this).data("id");
   			var column_name = $(this).data("column");
   			var value = $(this).text();
   			update_data(todo_id, column_name, value);
  		});

		$('#add').click(function(){
   			var html = '<tr>';
   			html += '<td contenteditable id="data1"><input type = "date" id="doc"></td>';
   			html += '<td contenteditable id="data2"><input type="date" id="doe"></td>';
   			html += '<td contenteditable id="data3" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32 || (event.charCode >= 48 && event.charCode <= 57));"></td>';
   			html += '<td contenteditable id="data4"><select id="do"><option value="remaining">remaining</option><option value="Completed">Completed</option></td>';
   			html += '<td contenteditable id="data5" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32 || (event.charCode >= 48 && event.charCode <= 57));"></td>';
   			html += '<td><button type="button" name="insert" id="payins" class="btn btn-success btn-xs">Insert</button></td>';
   			html += '</tr>';
   			$('#data tbody').prepend(html);
  		});

		$(document).on('click', '#payins', function(){
   			var doc = document.getElementById("doc").value;		
   			var doe =document.getElementById("doe").value;
			var subject = $('#data3').text();
			var status = document.getElementById("do").value;
			var remark = $('#data5').text();
			var exp = $('#data6').text();
   			if(subject != '' && status != '')
   			{
				   
    			$.ajax({
     				url:"insert.php",
     				method:"POST",
     				data:{doc:doc, doe:doe, subject:subject, status:status, remark:remark,exp:exp,id:id},
     				success:function(data)
     				{
      					$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      					$('#data').DataTable().destroy();
      					fetch_data();
     				}
    			});
    			setInterval(function(){
     			$('#alert_message').html('');
    			}, 5000);
   			}
   			else
   			{
    			alert("You forgot to fill Fields is required");
   			}
  		});	
		$(document).on('click', '.delete', function(){
   			var id = $(this).attr("id");
   			if(confirm("Are you sure you want to remove this?"))
   			{
    			$.ajax({
     				url:"delete.php",
     				method:"POST",
     				data:{id:id},
     				success:function(data){
      				$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      				$('#data').DataTable().destroy();
      				fetch_data();
     		}
    		});
    		setInterval(function(){
     			$('#alert_message').html('');
    			}, 5000);
   			}
  		});
		$(document).on('click', '.comp', function(){
			
			var id = $(this).attr("id");
   			if(confirm("Are you sure you completed this task?"))
   			{
    			$.ajax({
     				url:"comp.php",
     				method:"POST",
     				data:{id:id},
     				success:function(data){
      					$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      					$('#data').DataTable().destroy();
      				fetch_data();
     		}
    		});
    		setInterval(function(){
     			$('#alert_message').html('');
    			}, 5000);
   			}
			   document.location.reload(true);
  		});

	});
</script>
<script>
	$(document).ready(function()
		{
			fetch_data();
			
			function fetch_data()
			{
				var dataTable = $('#data_comp').DataTable({
				"processing" : true,
				"serverSide" : true,
				"order" : [],
				"ajax" : {
					url:"show.php",
					method:"POST",
					data:{id:id}
				}
			});
		}	
	});
</script>
<script>
	$(document).ready(function()
	{
		fetch_data();
		
		function fetch_data()
		{
			var dataTable = $('#data_payment').DataTable({
			"processing" : true,
			"serverSide" : true,
			"order" : [],
			"ajax" : {
				url:"payshow.php",
				method:"POST",
				data:{id:id}
			}
			});
		}	
		$('#add_pay').click(function(){
   			var html = '<tr>';
   			html += '<td contenteditable id="data1"><input type = "date" id="paydat"></td>';
   			html += '<td contenteditable id="data2" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32 || (event.charCode >= 48 && event.charCode <= 57));"></td>';
   			html += '<td contenteditable id="data3" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32 || (event.charCode >= 48 && event.charCode <= 57));"></td>';
   			html += '<td contenteditable id="data4" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32 || (event.charCode >= 48 && event.charCode <= 57));"></td>';
   			html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
   			html += '</tr>';
   			$('#data_payment tbody').prepend(html);
  		});

		$(document).on('click', '#insert', function(){
   			var doc = document.getElementById("paydat").value;		
			var debit = $('#data2').text();
			var credit = $('#data3').text();
			var remark = $('#data4').text();
   			if(doc != '')
   			{
				   
    			$.ajax({
     				url:"payadd.php",
     				method:"POST",
     				data:{doc:doc, debit:debit, credit:credit, remark:remark,id:id}
    			});
   			}
   			else
   			{
    			alert("You forgot to fill date is required");
   			}
			   document.location.reload(true);
  		});	
		$(document).on('click', '.delete1', function(){
			var id = $(this).attr("id");
			if(confirm("Are you sure you want to remove this payment?"))
   			{
    			$.ajax({
     				url:"paydel.php",
     				method:"POST",
     				data:{id:id},
					success:function(data){
      				$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      				$('#data_payment').DataTable().destroy();
      				fetch_data();
					}
				});		
     		}
    	});   			
	});
</script>