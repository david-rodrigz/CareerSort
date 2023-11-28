<?php

$data_file = file_get_contents('json_data.json');
$job_data = json_decode($data_file, true);
$jobs_results = $job_data['jobs_results'];
$chips = $job_data['chips'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="public/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Search Jobs</title>
</head>
<body>
    <a href="../logout">Log Out</a>
    <form method="post">
        <div class="search-container">
            <!-- Job query goes here -->
            <input class="search-bar" type="text" name="job-title" placeholder="Search job title">
            <input class="search-bar" type="text" name="location" placeholder="Location or remote">
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
    <hr>
    <div class="job-board">
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
        <div id="job-posts-container">
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
    </div>
    <script src="public/script.js"></script>
</body>
</html>