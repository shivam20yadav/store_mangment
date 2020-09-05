<?php
$connect = mysqli_connect("localhost", "root", "", "user_data");
if(isset($_POST["id"]))
{
    $query = "DELETE FROM todo WHERE client_id = '".$_POST["id"]."'";
    if(mysqli_query($connect, $query))
    {
        echo 'Data Deleted';
    }

    $query1 = "DELETE FROM payment WHERE client_id = '".$_POST["id"]."'";
    if(mysqli_query($connect, $query1))
    {
        echo 'Data Deleted';
    }

    $query2 = "DELETE FROM client_tbl WHERE client_id = '".$_POST["id"]."'";
    if(mysqli_query($connect, $query2))
    {
        echo 'Data Deleted';
    }
}

?>