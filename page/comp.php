<?php
$connect = mysqli_connect("localhost", "root", "", "user_data");
if(isset($_POST["id"]))
{
        $query = "UPDATE todo SET status = 'completed' WHERE todo_id = '".$_POST["id"]."'";
        if(mysqli_query($connect, $query))
        {
            echo 'Data Updated';
        }
}

?>