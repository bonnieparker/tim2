<?php

require 'db_info.php';

function create_db_conn() {

    $conn = new mysqli(
        db_info::host,
        db_info::username,
        db_info::password,
        db_info::dbname
    );

    if ($conn->connect_error) {
        die("Conn error: " . $conn->connect_error);
    }

    return $conn;
}
