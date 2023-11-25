<?php

/* ------------- Body ------------- */

$job_data = json_decode($_COOKIE['job_data'], true);
$jobs_results = $job_data['jobs_results'];

$i = 0;
foreach($jobs_results as $job) {
    display_job_entry($job, $i);
    $i++;
}

/* ------------- Functions ------------- */

function display_job_entry($job, $i) {
    // check if job is saved
    global $conn;
    $job_query = "SELECT job_id FROM jobs WHERE job_id = '" . substr($job['job_id'], 0, 700) . "';";
    $result = mysqli_query($conn, $job_query);
    $isSaved = mysqli_num_rows($result) > 0 ? "true" : "false";

    // Save job button
    // Saves job if not already saved, else deletes it
    echo "saveJob({$isSaved}, {$i})"; // for debugging (change this later)
    echo "<button class=\"save-job-btn\" onclick=\"saveJob({$isSaved}, {$i})\">Save Job{$i}</button>";
    echo "<i class=\"saved-status\" id=\"saved-status-{$i}\"></i><br>";
}
?>