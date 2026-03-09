<?php

session_start();
include "config/db.php";

if(isset($_POST['fan'])){

$status = $_POST['fan'];
$user = $_SESSION['user_id'];

$sql = "INSERT INTO fan_status (status,user_id) VALUES ('$status','$user')";
$conn->query($sql);

}

header("Location: dashboard.php");
exit();

?>