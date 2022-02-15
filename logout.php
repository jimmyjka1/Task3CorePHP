<?php
require_once "Utilities/helpers.php";
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['email']);
unset($_SESSION['fname']);
unset($_SESSION['lname']);
header("Location: index.php");
die();
?>