<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Images/favicon.jpg">
    <link rel="stylesheet" href="src/style.css">
    <title>CareerSort: AI Job Search Engine</title>
</head>
<body>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="jobs.php">Jobs</a>
        <a href="tailor.php">Tailor Application</a>
        <div class="logo-container">
            <img src="Images/logo-black.png" alt="">
        </div>
        <a href="privacy.php">Privacy</a>
        <a href="faq.php">FAQ</a>
        <div>
            <a href="#" class="log-in-link">Log In</a>
            <a href="#" class="sign-up-button">Sign Up</a>
        </div>
    </nav>

    <section class="jobs-section">
        <div class="job-filters">
            <form action="" class="jobs-search-bar">
                <input type="text" id="job" name="job" placeholder="search jobs or keywords">
            </form>
            <div class="filter">
                <span>Location</span>
                <div class="filter-content">
                    Filters go here
                </div>
            </div>
            <div class="filter">
                <span>Date Posted</span>
                <div class="filter-content">
                    Filters go here
                </div>
            </div>
            <div class="filter">
                <span>Type</span>
                <div class="filter-content">
                    Filters go here
                </div>
            </div>
            <div class="filter">
                <span>Pay</span>
                <div class="filter-content">
                    Filters go here
                </div>
            </div>
            <div class="filter">
                <span>Experience Level</span>
                <div class="filter-content">
                    Filters go here
                </div>
            </div>
            <div class="filter">
                <span>Education</span>
                <div class="filter-content">
                    Filters go here
                </div>
            </div>
        </div>
        <div class="jobs-result">
            <div class="jobs-list">
                <div>Job goes here.</div>
                <div>Job goes here.</div>
                <div>Job goes here.</div>
            </div>
            <div class="job-post-container">
                <div class="job-post">
                    <h1>Job title goes here</h1>
                    <br>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempore itaque quibusdam adipisci provident corporis dolorum quis pariatur reiciendis odit cum dolore in architecto delectus accusamus quam, voluptatum et. Labore, corrupti!</p>
                </div>
            </div>
        </div>
    </section>
    
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
            <a href="jobs.php"><u>Jobs</u></a><br>
            <a href="privacy.php"><u>Privacy</u></a><br>
            <a href="faq.php"><u>FAQ</u></a>
        </div>
    </footer>
</body>
</html>