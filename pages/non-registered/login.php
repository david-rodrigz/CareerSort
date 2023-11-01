<?php 
include("database/connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//something was posted
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
					header("Location: /jobsboard");
					die;
				}
			}
		}
		
		echo "wrong username or password!";
	}
	else {
		echo "wrong username or password!";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
	<a href="/">&larr; Home</a>
    <h1>Log In</h1>
    <form method="post">
        <input id="text" type="text" name="username" placeholder="username"><br><br>
        <input id="text" type="password" name="password" placeholder="password"><br><br>

        <input id="button" type="submit" value="Login"><br><br>

        <a href="/signup">Create a Free Account</a>
    </form>
</body>
</html>