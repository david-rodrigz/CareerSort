<?php

$data_file = file_get_contents('json_data.json'); // remove later
$job_data = json_decode($data_file, true); // remove later

$title_input = isset($title_input) ? $title_input : "";
$location_input = isset($location_input) ? $location_input : "";

if (isset($job_data)) {
    $jobs_results = $job_data['jobs_results'];
    $chips = $job_data['chips'];

    $title_input = str_replace("\'", "'", $title_input);
    $location_input = str_replace("\'", "'", $location_input);
}

// Get current page URL
$current_page = $_SERVER['REQUEST_URI'];

// Navbar links
$navbar_links = [
    '/jobs' => 'Search Jobs',
    '/saved' => 'Saved Jobs',
    '/profile' => 'Profile'
];

// id for active navbar link
$navbar_active_id = 'id="navbar-active"';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Search Jobs</title>
</head>
<body>
    <!-- Navbar -->
    <ul class="navbar">
        <li><img src="public/images/logo-black.png" alt="logo" class="navbar-logo"></li>
        <li class="navbar-links-container">
            <?php foreach ($navbar_links as $link => $text): ?>
                <a href="<?= $link ?>" <?php echo ($current_page == $link ? $navbar_active_id : '') ?>><?= $text ?></a>
            <?php endforeach; ?>
            <a href="/logout" id="logout-link">Log Out</a>
        </li>
    </ul>

    <!-- Search bar and filters -->
    <form class="search-form" method="post">
        <div class="search-container">
            <!-- Job query goes here -->
            <input class="search-bar" type="text" name="job-title" placeholder="Search job title" value="<?= $title_input ?>" required>
            <input class="search-bar" type="text" name="location" placeholder="Location or remote" value="<?= $location_input ?>">
            <input class="search-btn" type="submit" value="Search">
        </div>
        <div class="filters-container">
            <!-- All search filters (aka chips) go here -->
            <?php
            if (isset($job_data)) {
                foreach ($chips as $c) {
                    $param = $c['param'];
                    $type = $c['type'];
                    $options = $c['options'];
                    echo "<select class=\"filter\" name=\"$param\" id=\"$param\">";
                    foreach ($options as $o) {
                        $value = isset($o['value']) ? $o['value'] : $o['text'];
                        echo "<option value=\"{$value}\">" 
                            . ($o['text'] == "All" ? $type : $o['text']) 
                            . "</option>";
                    }
                    echo "</select>";
                }
            }
            ?>
        </div>
    </form>

    <!-- Job board -->
    <div class="job-board">
        <?php if (isset($job_data)): ?>
            <!-- This shows all the job search results -->
            <div class="jobs-list-container">
                <?php
                if (isset($job_data)) {
                    $index = 0;
                    foreach ($jobs_results as $job) {
                        include 'app/includes/job-listing.php';
                        $index++;
                    }
                }
                ?>
            </div>

            <!-- This shows a full job post -->
            <div class="job-posts-container" id="job-posts-container">
                <?php
                if (isset($job_data)) {
                    $index = 0;
                    foreach($jobs_results as $job) {
                        include 'app/includes/job-post.php';
                        $index++;
                    }
                }
                ?>
            </div>
        <?php else: ?>
            <br>
            <h3 class="no-search-message"><i>No search results yet.</i></h3>
        <?php endif; ?>
    </div>
    <script src="public/script.js"></script>
</body>
</html>