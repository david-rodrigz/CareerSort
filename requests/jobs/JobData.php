<?php

$job_data = NULL;
$page = 1;

// for debugging (change this later)
function load_data($data) {
    global $job_data;
    $job_data = json_decode($data, true);
}

function get_new_job_data($search_query) {
    global $job_data, $page;

    // Save search query to session
    $_SESSION['last_search'] = $search_query;
    $page = 1;

    // Load data from API
    $query = [
        "engine" => "google_jobs",
        "q" => ($search_query),
        "google_domain" => "google.com",
        "hl" => "en"
    ];
    
    // Set job data
    $search = new GoogleSearchResults(getenv('SERP_API'));
    $result = json_encode($search->get_json($query));
    $job_data = json_decode($result, true);
}

function load_more_jobs() {
    global $job_data, $page;
    
    // Load next page of results from API
    $page++;
    $query = [
    "engine" => "google_jobs",
    "q" => ($job_data['search_parameters']['q']),
    "google_domain" => "google.com",
    "hl" => "en",
    "start" => ($page * 10)
    ];
    
    // Append new jobs to job_data
    $search = new GoogleSearchResults(getenv('SERP_API'));
    $result = json_encode($search->get_json($query));
    $new_job_data = json_decode($result, true);
    $job_data['jobs_results'] = array_merge($job_data['jobs_results'], $new_job_data['jobs_results']);
}
