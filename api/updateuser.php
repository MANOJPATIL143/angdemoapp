<?php
include_once("database.php");
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))
{
    $request = json_decode($postdata);
    $id = trim($request->id);
    $name = trim($request->name);
    // $email = mysqli_real_escape_string($mysqli, trim($request->email));
   // $sql = "INSERT INTO users(name,password,email) VALUES ('$name','$pwd','$email')";
    $sql = "UPDATE `users` SET `name`='$name' WHERE `id`='$id'";

    if ($mysqli->query($sql) === TRUE) {
        // $authdata = [
        //                 'name' => $name,
        //                 'pwd' => '',
        //                 'email' => $email,
        //                 'Id' => mysqli_insert_id($mysqli)
        //                 ];
        $authdata['status'] = "succefully";
        echo json_encode($authdata);
    }
}

?>
