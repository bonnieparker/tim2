<?php

session_start();

require '../config/create_db_conn.php';

$title = $_POST['new-title'];
$text = $_POST['new-text'];

/** @var mysqli $conn */
$conn = create_db_conn();
$query = 'INSERT INTO news (id, title, `text`) VALUES (NULL, ?, ?)';

/** @var mysqli_stmt $stmt */
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $title, $text);

if (false == $stmt->execute()) {
    die('Error while inserting news: ' . $stmt->error);
}

$query = 'SELECT email FROM users WHERE news=1';
$result = $conn->query($query)->fetch_assoc();

$stmt->close();
$conn->close();

$_SESSION['message'] ='<b>' . $title . '</b>' . ' successfully added!';

foreach ($result as $key => $email) {
	mail($email, "Hot news!", "title: " . $title . " text: " . $text, "From: webmaster@example.com");
}

header('Location: ../');
