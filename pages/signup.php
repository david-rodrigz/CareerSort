<?php 
session_start();
include("../database/connection.php");
include '../database/functions.php';

if (!is_null(get_logged_user($conn))) {
	header('Location: jobs.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//something was posted
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

		header("Location: login.php");
		die;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>
    <form method="post">
        <input id="text" type="text" name="username" placeholder="username"><br><br>
        <input id="text" type="password" name="password" placeholder="password"><br><br>

        <input id="button" type="submit" value="Create Free Account"><br><br>

		<p>Already a member? <a href="login.php">Log In</a></p>
    </form>
</body>
</html>