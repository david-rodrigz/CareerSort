<?php
// Retrieve username and password from POST request if they exist
if (isset($username)) {
    $username_value = 'value="' . $username . '"';
} else {
    $username_value = '';
}

if (isset($password)) {
    $password_value = 'value="' . $password . '"';
} else {
    $password_value = '';
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
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="post">
        <input id="text" type="text" name="username" placeholder="username"
            <?php echo $username_value;?>>
        <br><br>
        <input id="text" type="password" name="password" placeholder="password"
            <?php echo $password_value;?>>
        <br><br>
        <input id="button" type="submit" value="Create Free Account"><br><br>

		<p>Already a member? <a href="/login">Log In</a></p>
    </form>
</body>
</html>