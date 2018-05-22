<?php

session_start();

require '../config/create_db_conn.php';

if (empty($_POST['login-try']) ||
    false ==isset($_POST['login-try']) ||
    empty($_POST['password-try']) ||
    false == isset($_POST['password-try'])) {
    die('Some error...');
}

$email = $_POST['login-try'];
$password = $_POST['password-try'];

/** @var mysqli $conn */
$conn = create_db_conn();
$query = 'SELECT * FROM users WHERE email='."'".$email."'";

$result = $conn->query($query)->fetch_assoc();

if (password_verify($password, $result['password'])) {

    $_SESSION['logged'] = $email;

    header('Location: ../');
    exit();
}

$_SESSION['message'] = 'WRONG PASSWORD!';

header('Location: ../');
