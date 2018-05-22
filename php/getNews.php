<?php

require 'config/create_db_conn.php';

function getNews() {
	/** @var mysqli $conn */
	$conn = create_db_conn();
	$query = 'SELECT * FROM news';

	return $conn->query($query)->fetch_all();
}
