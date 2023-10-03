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

    <section class="tailor-section fit-navbar-section">
        <div class="tailor-results-contianer">
            <div class="tailor-toolbar">
                <div class="job-selected-container">
                    Applying to:
                    <a href="" class="job-selected-link">no job selected</a>
                </div>
                <div class="tailor-options-drop-down">
                    <span>
                        Resume 
                        <img class="drop-down-icon" src="Images/caret-down-solid.svg" alt="">
                    </span>
                    <div class="tailor-options-list">
                        <!-- <button class="tailor-resume-option">Resume</button> -->
                        <button class="generate-cover-lettter-option">Cover Letter</button>
                        <button class="interview-qa-option">Interview Q&A</button>
                    </div>
                </div>
                <a href="" class="update-resume-link">Update Bio</a>
            </div>
            <hr>
            <br>
            <p class="output-label">output:</p>
            <div class="ai-generated-content">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis nulla reiciendis soluta qui? Doloremque id quas dolore reprehenderit neque esse consequuntur eveniet porro totam ab pariatur, laborum quo consequatur. Nihil.
            </div>
            <button class="apply-button">Apply</button>
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