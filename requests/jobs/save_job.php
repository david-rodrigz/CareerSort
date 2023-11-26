<?php
require '../../database/connection.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_data = $_POST['job_data'];

    // gather JSON job data
    $title = str_replace("'", "\'", $job_data['title']);
    $company_name = str_replace("'", "\'", $job_data['company_name']);
    $location = str_replace("'", "\'", $job_data['location']);
    $description = str_replace("'", "\'", $job_data['description']);
    $job_id = substr($job_data['job_id'], 0, 700);
    $job_highlights = $job_data['job_highlights'];

    // get user id from session
    // $user_id = $_SESSION['user_id']; // for debugging (change this later)
    $user_id = 2; // for debugging (change this later)
    
    // insert company only if it does not alreadty exist in database 
    // check if company arleady exists
    $company_q = "SELECT company_name FROM companies WHERE company_name = " 
        . "'$company_name';";
    
    // save job data if not already saved, else delete it
    if ($job_data['isSaved'] == "false") {
        if (mysqli_num_rows(mysqli_query($conn, $company_q)) == 0) {
            $thumbnail_link = $job_data['thumbnail'];
            $website = count($job_data['related_links']) > 0
                ? $job_data['related_links'][0]['link'] : "";
            $insert_company = "INSERT INTO companies (company_name, thumbnail_link, website) "
                . "VALUES ('$company_name', '$thumbnail_link', '$website');";
            mysqli_query($conn, $insert_company);
        }
    
        // prepare insert statements
        $insert_job = "INSERT INTO jobs (job_id, title, location, description, company_name, user_id) "
            . "VALUES ('$job_id', '$title', '$location', '$description', '$company_name', $user_id);";
        $insert_apply_options = "INSERT INTO apply_options (link, job_id) " 
            . "VALUES ('fake-link.com', '$job_id');"; // for debugging (change this later)
            
        // insert data into database
        mysqli_query($conn, $insert_job);
        mysqli_query($conn, $insert_apply_options);
    
        // add job highlights only if it is not a reiteration of the job description
        if (count($job_highlights) > 1 || count($job_highlights[0]['items']) > 1) {
            foreach ($job_highlights as $highlight) {
                // gather title and items from "job_highlits" in JSON
                $highlight_title = str_replace("'", "\'", $highlight['title']);
                $highlight_items = "";
                foreach ($highlight['items'] as $item) {
                    $highlight_items = $highlight_items . "\n" . str_replace("'", "\'", $item);
                }
    
                // set up insert statement
                $insert_job_highlights = "INSERT INTO job_highlights (title, items, job_id) " 
                    . "VALUES ('$highlight_title', '$highlight_items', '$job_id');";
    
                // insert highlight
                mysqli_query($conn, $insert_job_highlights);
            }
        }
        echo "saved";
    }
    else {
        // prepare delete statements
        $delete_job_highlights = "DELETE FROM job_highlights WHERE job_id = '$job_id';";
        $delete_apply_options = "DELETE FROM apply_options WHERE job_id = '$job_id';";
        $delete_job = "DELETE FROM jobs WHERE job_id = '$job_id';";
    
        // delete data
        mysqli_query($conn, $delete_job_highlights);
        mysqli_query($conn, $delete_apply_options);
        mysqli_query($conn, $delete_job);

        echo "unsaved";
    }
}
