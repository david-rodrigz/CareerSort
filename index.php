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

    // Retrieve username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check that username and password are not empty
    if (empty($username) || empty($password)) {
		$error = empty($username) && empty($password) ? "Username and password are required." 
            : (empty($username) ? "Username is required."
            : "Password is required.");
        
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        include 'app/views/signup.php';
        exit;
	}

    // Escape username and password for security
    $username = str_replace("'", "\'", $_POST['username']);
	$password = str_replace("'", "\'", $_POST['password']);

    // Validate login credentials
	if ($database->login($username, $password)) {
        header("Location: /dashboard");
        exit;
    }

    // Revert escaped apostrophes and escape HTML characters
    $username = str_replace("\'", "'", $_POST['username']);
    $username = htmlspecialchars($username);
	$password = str_replace("/'", "'", $_POST['password']);
    $password = htmlspecialchars($password);
    $error = "Incorrect username or password.";
    include 'app/views/login.php';
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

    // Retrieve username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check that username and password are not empty
	if (empty($username) || empty($password)) {
		$error = empty($username) && empty($password) ? "Username and password are required." 
            : (empty($username) ? "Username is required."
            : "Password is required.");
        
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        include 'app/views/signup.php';
        exit;
	}

    // Escape username and password for security
    $username = str_replace("'", "\'", $_POST['username']);
	$password = str_replace("'", "\'", $_POST['password']);

    // Create new user
	if ($database->signup($username, $password)) {
		header("Location: /login");
		exit;
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
