<?php
session_start();

include("database/connection.php");
include("database/functions.php");

// Routes to (non-registered users)
$landing_pages = [
    '/' => 'pages/non-registered/home.php',
    '/jobs' => 'pages/non-registered/jobs.php',
    '/tailor-application' => 'pages/non-registered/tailor-application.php',
    '/faq' => 'pages/non-registered/faq.php',
    '/privacy' => 'pages/non-registered/privacy.php'
];

// Routes to authentication pages 
$auth_pages = [
    '/signup' => 'pages/non-registered/signup.php',
    '/login' => 'pages/non-registered/login.php'
];

// Routes to pages for registered users
$registered_pages = [
    '/job-board' => 'pages/registered/job-board.php',
    '/applied-jobs' => 'pages/registered/applied-jobs.php',
    '/saved-jobs' => 'pages/registered/saved-jobs.php'
];

// Get the requested path from the URL
$request_uri = $_SERVER['REQUEST_URI'];

// Remove any query parameters from the URL
$request_uri = strtok($request_uri, '?');

// check that registered users can only go to the pages for registered users
if (!is_null(get_logged_user($conn))) {
    if(array_key_exists($request_uri, $registered_pages)) {
        include $registered_pages[$request_uri];
    }
    else {
        header("Location: /job-board");
    }
    echo $request_uri;
}
// Check if the requested path exists in one of the route arrays
else if (array_key_exists($request_uri, $landing_pages)) {
    include 'includes/header.php'; // include header and navbar
    include $landing_pages[$request_uri];
    include 'includes/footer.php'; // include footer
} 
else if (array_key_exists($request_uri, $auth_pages)) {
    include $auth_pages[$request_uri];
}
else if (array_key_exists($request_uri, $registered_pages)) {
    header("Location: /");
}
else {
    echo "<b>404 error</b><br>This page does not exist.";
}