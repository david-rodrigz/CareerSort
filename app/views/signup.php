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
    <link rel="stylesheet" href="public/admission.css">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <title>Sign Up</title>
</head>
<body>
    <div class="admission-container">
        <h1>Sign Up</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form method="post">
            <input class="admission-prompt" id="text" type="text" name="username" placeholder="username"
                <?php echo $username_value;?>>
            <br><br>
            <input class="admission-prompt" id="text" type="password" name="password" placeholder="password"
                <?php echo $password_value;?>>
            <br><br>
            <input class="admission-btn" id="button" type="submit" value="Create Free Account"><br>
    
            <p>Already a member? <a href="/login">Log In</a></p>
        </form>
    </div>
</body>
</html>