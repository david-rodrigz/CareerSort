<?php
require 'app/config/database.php';
include_once "app/middleware/AuthMiddleware.php"; // middleware
include_once "app/router.php"; // router

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
    global $conn;

    $username = $_POST['username'];
	$password = $_POST['password'];

	if (!empty($username) && !empty($password) && !is_numeric($username)) {

		//read from database
		$query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
		$result = mysqli_query($conn, $query);

		if ($result) {
			if ($result && mysqli_num_rows($result) > 0) {

				$user_data = mysqli_fetch_assoc($result);

				// compare hashed password from database with 
				// hashed password from user's input
				$storedHashedPassword = $user_data['password'];
				if (password_verify($password, $storedHashedPassword)) {
					$_SESSION['user_id'] = $user_data['user_id'];
					header("Location: /dashboard");
					die;
				}
			}
		}
		
		echo "wrong username or password!";
	}
	else {
		echo "wrong username or password!";
	}
    exit;
});

// signup route
$router->addRoute('GET', '/signup', $checkNotAuthenticated, function () {
    include 'app/views/signup.php';
    exit;
});

// signup POST request
$router->addRoute('POST', '/signup', $checkNotAuthenticated, function () {
    global $conn;

    $username = $_POST['username'];
	$password = $_POST['password'];

	// hash password for security
	$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

	if (empty($username)) {
		echo "<p class=\"error message\">Please provide a username.</p>";
	}
	else if (empty($password)) {
		echo "<p class=\"error message\">Please provide a password.</pp>";
	}
	else {
		// add user to database
		$query = "INSERT INTO users (username,password) VALUES ('$username','$hashedPassword')";

		mysqli_query($conn, $query);

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
