<?php

session_start();

require '../config/create_db_conn.php';

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

/** @var mysqli $conn */
$conn = create_db_conn();
$query = 'INSERT INTO users (id, email, password, verified) VALUES (NULL, ?, ?, 0)';

/** @var mysqli_stmt $stmt */
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $email, $password);

if (false == $stmt->execute()) {
    die('Error while inserting new member: ' . $stmt->error);
}

$stmt->close();
$conn->close();


mail($email, "Registration confirmation", '/confirm.php?email='.$email, "From: webmaster@example.com");

$_SESSION['message'] ='<b>' . $email . '</b>' . ' successfully registered! Confirmation link sent to email.';

header('Location: ../');
