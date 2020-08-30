<?php
//fetch.php
    $connect = mysqli_connect("localhost", "root", "", "user_data");
    $columns = array('client_tbl.client_name','todo.todo_id','todo.doe','todo.subject','todo.remark');

    $query = "SELECT client_tbl.client_name,todo.todo_id,todo.doe,todo.subject,todo.remark FROM client_tbl Inner Join todo On todo.client_id = client_tbl.client_id where todo.doe = '".$_POST["today"]."' AND todo.status = 'remaining'";

    $number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

    $result = mysqli_query($connect, $query);

    $data = array();

    while($row = mysqli_fetch_array($result))
    {
        $sub_array = array();
            $sub_array[] = '<div data-id="'.$row["client_name"].'" data-column="Client name">' . $row["client_name"] . '</div>';
            $sub_array[] = '<div data-id="'.$row["doe"].'" data-column="Date of Ending">' . $row["doe"] . '</div>';
            $sub_array[] = '<div data-id="'.$row["subject"].'" data-column="Subject">' . $row["subject"] . '</div>';
            $sub_array[] = '<div data-id="'.$row["remark"].'" data-column="Remark">' . $row["remark"] . '</div>';
            $sub_array[] = '<button type="button" name="comp" class="btn btn-success btn-xs comp " id="'.$row["todo_id"].'">Completed</button>';
        $data[] = $sub_array;
    }

    function get_all_data($connect)
    {
    $query = "SELECT client_tbl.client_name,todo.doe,todo.subject,todo.remark FROM client_tbl Inner Join todo On todo.client_id = client_tbl.client_id where todo.doe = '".$_POST["today"]."' AND todo.status = 'remaining'";
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