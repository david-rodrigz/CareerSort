<?php
session_start();

include("database/connection.php");
include("database/functions.php");

// Routes to authentication pages 
$auth_pages = [
    '/' => 'pages/login.php',
    '/login' => 'pages/login.php',
    '/signup' => 'pages/signup.php'
];

// Get the requested path from the URL
$request_uri = $_SERVER['REQUEST_URI'];

// Remove any query parameters from the URL
$request_uri = strtok($request_uri, '?');

// if user is registered, go to '/jobs'
if (!is_null(get_logged_user($conn))) {
    include 'pages/jobs.php';
}
// else if an auth page is requested, go to the requested auth page
else if (array_key_exists($request_uri, $auth_pages)) {
    include $auth_pages[$request_uri];
}
// else echo 404 error
else {
    echo "<b>404 error</b><br>This page does not exist.";
}