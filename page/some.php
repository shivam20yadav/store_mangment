<?php  
 function fetch_data()  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "user_data");  
      $sql = "SELECT * FROM payment ORDER BY payment_id ASC";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {       
        $output .= '<tr>  
                          <td>'.$row["payment_id"].'</td>   
                          <td>'.$row["date"].'</td>  
                          <td style="color:red">'.$row["payment"].'</td>  
                          <td>'.$row["exp"].'</td>
                          <td>'.$row["remark"].'</td>  
                     </tr> 
                          ';  
      }  

      return $output;  
 }  
 function fetch(){
    $output = '';  
    $connect = mysqli_connect("localhost", "root", "", "user_data");  
    $result = mysqli_query($connect, 'SELECT SUM(payment) AS value_sum FROM payment'); 

    $result2 = mysqli_query($connect, 'SELECT SUM(exp) AS val FROM payment'); 

    $row2 = mysqli_fetch_assoc($result2);  
    $row = mysqli_fetch_assoc($result); 

    $d = $row2['val'];
    $sum = $row['value_sum'];
    $output .='<tr> <td></td><td></td><td>total='.$sum.'</td><td>'.$d.'</td> </tr>';
    return $output;  

 }

 if(isset($_POST["create_pdf"]))  
 {  
      require_once('tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
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
      <h3 align="center">Export HTML Table data to PDF using TCPDF in PHP</h3><br /><br />  
      <table border="1" cellspacing="0" cellpadding="5">  
           <tr>  
                <th width="5%">ID</th>  
                <th width="30%">Name</th>  
                <th width="10%">Gender</th>  
                <th width="45%">Designation</th>  
                <th width="10%">Age</th>  
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('sample.pdf', 'I');  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Export HTML Table data to PDF using TCPDF in PHP</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />          
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:700px;">  
                <h3 align="center">Export HTML Table data to PDF using TCPDF in PHP</h3><br />  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="5%">ID</th>  
                               <th width="30%">Date</th>  
                               <th width="30%" id="try">payment</th>  
                               <th width="45%">exp</th>  
                               <th width="10%">remark</th>  
                          </tr>  
                     <?php  
                     echo fetch_data();
                     echo fetch();  
                     ?>
                     </table> 
                </div> 
                     <br />  
                     <form method="post">  
                          <input type="submit" name="create_pdf" class="btn btn-danger" value="Create PDF" />  
                     </form>     
           </div>  
      </body>  
 </html>  