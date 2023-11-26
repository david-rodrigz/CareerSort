<?php

/* ------------- Body ------------- */

$jobs_results = $job_data['jobs_results'];

$i = 0;
foreach($jobs_results as $job) {
    display_job_entry($job, $i);
    $i++;
}

/* ------------- Functions ------------- */

function display_job_entry($job, $i) {
    global $conn;
    
    // check if job is saved and set boolean
    $job_query = "SELECT job_id FROM jobs WHERE job_id = '" . substr($job['job_id'], 0, 700) . "';";
    $result = mysqli_query($conn, $job_query);
    $isSaved = mysqli_num_rows($result) > 0 ? "true" : "false";

    // encode job data into JSON and escape HTML characters
    $job_data = json_encode($job);
    $job_data = htmlspecialchars($job_data, ENT_QUOTES);
    $job_data = addslashes($job_data);
    $job_data = str_replace("&#039;", "\\&#039;", $job_data);

    // Save job button
    // Saves job if not already saved, else deletes it
    $job_id = "id=\"job-post-{$i}\"";
    $onclick = "onclick=\"saveJob({$i}, {$isSaved}, '{$job_data}')\"";
    $btn_text = $isSaved == "true" ? "Unsave Job" : "Save Job";
    echo "<button class=\"save-job-btn\" {$job_id} {$onclick}>{$btn_text} {$i}</button><br>";
}
?>