<?php
//fetch.php
    $connect = mysqli_connect("localhost", "root", "", "user_data");

    $doc = mysqli_real_escape_string($connect, $_POST["doc"]);
    $subject = mysqli_real_escape_string($connect, $_POST["debit"]);
    $status = mysqli_real_escape_string($connect, $_POST["credit"]);
    $remark = mysqli_real_escape_string($connect, $_POST["remark"]);
    $query = "INSERT INTO payment(client_id,date,payment,exp,remark) VALUES('".$_POST["id"]."','$doc','$subject', '$status', '$remark')";
    if(mysqli_query($connect, $query))
    {
        echo 'Data Inserted';
    }
?>