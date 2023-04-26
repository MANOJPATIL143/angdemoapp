<?php
include_once("database.php");
// $postdata = file_get_contents("php://input");
// $request = json_decode($postdata);
// if(isset($postdata) && !empty($postdata))
// {

// echo "<pre>";print_r($_GET);exit;
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	$sql = "DELETE FROM users where id='".$_GET['id']."'";
	if(mysqli_query($mysqli, $sql))
	{
		echo json_encode("success");
	} else {
		http_response_code(404);
	}
} else {
		http_response_code(404);
	}
// }
?>
