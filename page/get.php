<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "user_data");
$columns = array('doc', 'doe','subject','status','remark','exp');


$query = "SELECT * FROM todo where client_id =  '".$_POST["id"]."'";

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["todo_id"].'" data-column="Date of Creation">' . $row["doc"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["todo_id"].'" data-column="Date of Ending">' . $row["doe"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["todo_id"].'" data-column="Subject">' . $row["subject"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["todo_id"].'" data-column="Status">' . $row["status"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["todo_id"].'" data-column="Remark">' . $row["remark"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["todo_id"].'" data-column="Expenses">' . $row["exp"] . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["todo_id"].'">Delete</button>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM todo where client_id = '".$_POST["id"]."'";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>