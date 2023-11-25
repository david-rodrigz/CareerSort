<?php

$search_query = NULL;
$page = 1;

// for debugging (change this later)
function load_data($data) {
    setcookie('job_data', $data, time() + (86400 * 30), '/');
    $_COOKIE['job_data'] = $data;
}

function get_new_job_data($search_query) {
    // Load data from API
    $query = [
        "engine" => "google_jobs",
        "q" => ($search_query),
        "google_domain" => "google.com",
        "hl" => "en"
    ];
    
    // Save data to cookie
    $search = new GoogleSearchResults(getenv('SERP_API'));
    $result = json_encode($search->get_json($query));
    setcookie('job_data', $result, time() + (86400 * 30), '/');
    $_COOKIE['job_data'] = $result;
}

function load_more_jobs($page) {
    // Retrieve job query from cookie
    $job_data = json_decode($_COOKIE['job_data'], true);
    $job_query = $job_data['search_parameters']['q'];

    // Load data from the requested page of results from API
    $query = [
    "engine" => "google_jobs",
    "q" => ($job_query),
    "google_domain" => "google.com",
    "hl" => "en",
    "start" => ($page * 10)
    ];
    
    $search = new GoogleSearchResults(getenv('SERP_API'));
    $result = json_encode($search->get_json($query));
    
    // Append new jobs to job_data
    $new_job_data = json_decode($result, true);
    $_COOKIE['job_data'] = json_encode(array_merge_recursive($job_data, $new_job_data));
}
