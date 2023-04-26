<?php
include_once("database.php");
// $postdata = file_get_contents("php://input");
$request = json_decode($postdata);
// if(isset($postdata) && !empty($postdata))
// {

// echo "<pre>";print_r($_GET);exit;
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	$sql = "SELECT * FROM users where id=".$_GET['id'];
	if($result = mysqli_query($mysqli, $sql))
	{
		$rows = array();
		while($row = mysqli_fetch_assoc($result))
		{
			$rows[] = $row;
		}

	if (!empty($rows[0])) { 
		echo json_encode($rows[0]);
	}
	} else {
	http_response_code(404);
	}
} else {
	http_response_code(404);
	}
// }
?>
