<?php
$connect = mysqli_connect("localhost", "root", "", "user_data");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM todo WHERE todo_id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
?>