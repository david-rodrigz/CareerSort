<?php
require 'app/config/database.php';
include_once "app/middleware/AuthMiddleware.php"; // middleware
include_once "app/router.php"; // router

// start session if not already started
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// Create a database connection
$database = new Database();

// Create a new Router instance
$router = new Router();

// home route
$router->addRoute('GET', '/', $checkNotAuthenticated, function () {
    echo "Welcome to my <b>home</b> page!";
    exit;
});

// dashboard route
$router->addRoute('GET', '/dashboard', $checkAuthenticated, function () {
    echo "<p><a href='/logout'>Logout</a></p>";
    echo "Welcome to my <b>dashboard</b> page!";
    exit;
});

// login route
$router->addRoute('GET', '/login', $checkNotAuthenticated, function () {
    include 'app/views/login.php';
    exit;
});

// login POST request
$router->addRoute('POST', '/login', $checkNotAuthenticated, function () {
    global $database;

    $username = str_replace("'", "\'", $_POST['username']);
	$password = str_replace("'", "\'", $_POST['password']);

	if (!empty($username) && !empty($password) && !is_numeric($username)) {
        if($database->login($username, $password)) {
            header("Location: /dashboard");
            exit;
        }
    }

    echo "<p class=\"error-message\">Invalid username or password.</p>";
    exit;
});

// signup route
$router->addRoute('GET', '/signup', $checkNotAuthenticated, function () {
    include 'app/views/signup.php';
    exit;
});

// signup POST request
$router->addRoute('POST', '/signup', $checkNotAuthenticated, function () {
    global $database;

    $username = str_replace("'", "\'", $_POST['username']);
	$password = str_replace("'", "\'", $_POST['password']);

	if (empty($username)) {
		echo "<p class=\"error-message\">Please provide a username.</p>";
	}
	if (empty($password)) {
		echo "<p class=\"error-message\">Please provide a password.</pp>";
	}

	if ($database->signup($username, $password)) {
		header("Location: /login");
		die;
	}

    exit;
});

// logout route
$router->addRoute('GET', '/logout', $checkAuthenticated, function () {
    session_destroy();
    header("Location: /");
    exit;
});

$router->matchRoute();
