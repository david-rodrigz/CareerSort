<?php

$title_input = isset($title_input) ? $title_input : "";
$location_input = isset($location_input) ? $location_input : "";

if (isset($job_data)) {
    $jobs_results = $job_data['jobs_results'];
    $chips = $job_data['chips'];

    $title_input = str_replace("\'", "'", $title_input);
    $location_input = str_replace("\'", "'", $location_input);
}

?>
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