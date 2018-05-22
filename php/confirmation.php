<?php

session_start();

require '../config/create_db_conn.php';

$email = $_POST['email'];

/** @var mysqli $conn */
$conn = create_db_conn();
$query = 'UPDATE * FROM users SET confirmation=1 WHERE email='."'".$email."'";

$_SESSION['message'] ='<b>' . $login . '</b>' . ' successfully confirmed!';

header('Location: ../');
