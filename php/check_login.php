<?php

require '../config/create_db_conn.php';

if (empty($_POST['email']) || !isset($_POST['email'])) {
    echo '0';
    exit();
}

$email = $_POST['email'];

/** @var mysqli $conn */
$conn = create_db_conn();
$query = 'SELECT * FROM `users` WHERE email="' . $email . '"';

$result = $conn->query($query);
$conn->close();

if ($result->num_rows > 0) {
    echo '0';
} else {
    echo '1';
}
