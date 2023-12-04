<?php

// Get user id from session
$user_id = $_SESSION['user_id'];

// Query all jobs saved by user
$query = "SELECT * FROM jobs WHERE user_id = '$user_id'";

// Execute query
$conn = $database->get_connection();
$jobs = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Declare job results array
$jobs_results = array();

// Add job information to job results array
foreach ($jobs as $job) {
    // Create an associative array for the current job
    $current_job = array();

    // Add job details to the current job array
    $current_job['job_id'] = $job['job_id'];
    $current_job['title'] = $job['title'];
    $current_job['company_name'] = $job['company_name'];
    $current_job['location'] = $job['location'];

    // Set extentions as an empty array
    $current_job['extensions'] = array();

    // Query job highlights
    $query = "SELECT * FROM job_highlights WHERE job_id = '{$job['job_id']}'";
    $highlights = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

    // Add job highlights to the current job array
    $current_job['job_highlights'] = array();
    foreach ($highlights as $highlight) {
        $highlight_items = explode("\n", substr($highlight['items'], 1));
        $current_job['job_highlights'][] = array(
            'title' => $highlight['title'],
            'items' => $highlight_items
        );
    }

    $current_job['description'] = $job['description'];

    // Add the current job array to the job results array
    $jobs_results[] = $current_job;
}
?>
<!-- TODO: Style this element properly -->
<div class="search-form"><br><br><h2>Saved Jobs</h2></div>

<!-- Job board -->
<div class="job-board">
    <?php if (isset($jobs_results) && count($jobs_results) > 0): ?>
        <!-- This shows all the job search results -->
        <div class="jobs-list-container">
            <?php
            $index = 0;
            foreach ($jobs_results as $job) {
                include 'app/includes/job-listing.php';
                $index++;
            }
            ?>
        </div>

        <!-- This shows a full job post -->
        <div class="job-posts-container" id="job-posts-container">
            <?php
            $index = 0;
            foreach($jobs_results as $job) {
                include 'app/includes/job-post.php';
                $index++;
            }
            ?>
        </div>
    <?php else: ?>
        <br>
        <h3 class="no-saved-message"><i>No jobs saved yet.</i></h3>
    <?php endif; ?>
</div>