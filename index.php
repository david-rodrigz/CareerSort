<!-- This page is the main entry point and handles the routing -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Images/favicon.jpg">
    <link rel="stylesheet" href="pages/style.css">
    <!-- CareerSort: AI Job Search Engine -->
    <title>CareerSort</title> <!-- make this dynamic later -->
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="?page=home">Home</a>
        <a href="?page=jobs">Jobs</a>
        <a href="?page=tailor">Tailor Application</a>
        <div class="logo-container">
            <img src="Images/logo-black.png" alt="">
        </div>
        <a href="?page=privacy">Privacy</a>
        <a href="?page=faq">FAQ</a>
        <div>
            <a href="#" class="log-in-link">Log In</a>
            <a href="#" class="sign-up-button">Sign Up</a>
        </div>
    </nav>

    <!-- Page routing -->
    <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        
        // Define an array of all website pages
        $pages = ['home', 'jobs', 'tailor', 'privacy', 'faq'];

        // Check if the requested page is allowed
        if (in_array($page, $pages)) {
            include('pages/' . $page . '.php');
        } else {
            echo '<h1>404 - Page Not Found</h1>';
            // Error page content for invalid page requests
        }
    ?>

    <!-- footer -->
    <footer>
        <div class="footer-logo-container">
            <img src="Images/logo-white.png" alt="">
        </div>
        <div class="contact-container">
            <h3>Questions?</h3>
            <br>
            <p>email: fake-address@email.com</p>
        </div>
        <div class="navigation-links-container">
            <a href="?page=jobs"><u>Jobs</u></a><br>
            <a href="?page=privacy"><u>Privacy</u></a><br>
            <a href="?page=faq"><u>FAQ</u></a>
        </div>
    </footer>
</body>
</html>
