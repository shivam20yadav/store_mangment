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
    if(isset($_POST["todo_id"]))
    {
        $value = mysqli_real_escape_string($con, $_POST["value"]);
        $query = "UPDATE todo SET ".$_POST["column_name"]."='".$value."' WHERE todo_id = '".$_POST["todo_id"]."'";
        if(mysqli_query($con, $query))
        {
            echo 'Data Updated';
        }
    }
?>