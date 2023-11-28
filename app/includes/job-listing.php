<?php

// job listing info
$title = $job['title'];
$company = $job['company_name'];
$location = $job['location'];
$extensions = $job['extensions'];

// check if job is saved
$is_saved = $database->get_job(substr($job['job_id'], 0, 700)) > 0 ? "true" : "false";

// choose bookmark icon based on whether job is saved
$bookmark_icon = $is_saved == "true" ? "bookmark1.svg" : "bookmark0.svg";

// encode job data into JSON and escape HTML characters
$job_json = json_encode($job);
$job_json = htmlspecialchars($job_json, ENT_QUOTES);
$job_json = addslashes($job_json);
$job_json = str_replace("&#039;", "\\&#039;", $job_json);
?>

<div class="job-listing-container" onclick="displayJobPost(<?= $index ?>)">
    <div class="job-listing-info">
        <h3><?= $title ?></h3>
        <br>
        <p><?= $company ?></p>
        <p><?= $location ?></p>
        <br>
        <?php foreach ($extensions as $extension): ?>
            <p><?= $extension ?></p>
        <?php endforeach; ?>
    </div>
    <div class="bookmark-container">
        <img src="public/images/<?= $bookmark_icon ?>" class="bookmark-icon" 
        id="bookmark-icon<?= $index ?>" 
        onclick="bookmark(<?= $index ?>, <?= $is_saved ?>,'<?= $job_json ?>')"></img>
    </div>
</div>