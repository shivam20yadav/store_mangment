<?php
//fetch.php
    $connect = mysqli_connect("localhost", "root", "", "user_data");
    if(isset($_POST["doc"], $_POST["doe"], $_POST["subject"], $_POST["status"], $_POST["remark"]))
    {
        $doc = mysqli_real_escape_string($connect, $_POST["doc"]);
        $doe = mysqli_real_escape_string($connect, $_POST["doe"]);
        $subject = mysqli_real_escape_string($connect, $_POST["subject"]);
        $status = mysqli_real_escape_string($connect, $_POST["status"]);
        $remark = mysqli_real_escape_string($connect, $_POST["remark"]);
        $query = "INSERT INTO todo(client_id,doc,doe,subject,status,remark) VALUES('".$_POST["id"]."','$doc', '$doe', '$subject', '$status', '$remark')";
        
        
        if(mysqli_query($connect, $query))
        {
            echo 'Data Inserted';
        }
    }
?>