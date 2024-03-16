<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'pos_system');

/* Attempt to connect to MySQL database */

$connect = mysqli_connect(
    DB_SERVER,
    DB_USERNAME,
    DB_PASSWORD,
    DB_NAME
);

// Check connection

if (!$connect) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
