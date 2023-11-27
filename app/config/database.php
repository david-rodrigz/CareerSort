<?php

$host = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_NAME');

$conn = mysqli_connect($host,$username,$password,$database);

if(!$conn) {
	die("failed to connect!");
}