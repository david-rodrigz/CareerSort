<a href="database/logout.php">Log out</a><br>
<?php
include 'database/connection.php';
require 'apis/google-search-results.php';
require 'apis/restclient.php';

$job_data = NULL;
$jobs_results = NULL;

if (isset($_POST['job-title']) || isset($_POST['location'])) {
    $query = [
     "engine" => "google_jobs",
     "q" => ($_POST['job-title'] . " " . $_POST['location']),
     "google_domain" => "google.com",
     "hl" => "en",
    ];
    
    $search = new GoogleSearchResults(getenv('SERP_API'));
    $result = json_encode($search->get_json($query));
    $job_data = json_decode($result, true);
    $jobs_results = $job_data['jobs_results'];
}

if (isset($_SESSION['user_id']) && isset($job_data) && isset($_GET['saved']) && isset($_GET['job'])) {
    $saved = $_GET['saved'];
    $job_i = $_GET['job'];
    
    // gather JSON job data
    $title = str_replace("'", "\'", $jobs_results[$job_i]['title']);
    $company_name = str_replace("'", "\'", $jobs_results[$job_i]['company_name']);
    $location = str_replace("'", "\'", $jobs_results[$job_i]['location']);
    $description = str_replace("'", "\'", $jobs_results[$job_i]['description']);
    $user_id = $_SESSION['user_id'];
    $job_id = substr($jobs_results[$job_i]['job_id'], 0, 700);
    $job_highlights = $jobs_results[$job_i]['job_highlights'];
    
    // insert company only if it does not alreadty exist in database 
    // check if company arleady exists
    $company_q = "SELECT company_name FROM companies WHERE company_name = " 
        . "'$company_name';";

    // save job data if not already saved, else delete it
    if ($saved == 0) {
        if (mysqli_num_rows(mysqli_query($conn, $company_q)) == 0) {
            $thumbnail_link = $jobs_results[$job_i]['thumbnail'];
            $website = count($jobs_results[$job_i]['related_links']) > 0
                ? $jobs_results[$job_i]['related_links'][0]['link'] : "";
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
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Job Board</title>
</head>
<body>
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
                $chips = $job_data['chips'];
                foreach ($chips as $c) {
                    $param = $c['param'];
                    $type = $c['type'];
                    $options = $c['options'];
                    echo "<select class=\"filter\" name=\"$param\" id=\"$param\">";
                    foreach ($options as $o) {
                        echo "<option value=\"{$o['value']}\">" 
                            . ($o['text'] == "All" ? $type : $o['text']) 
                            . "</option>";
                    }
                    echo "</select>";
                }
            }
            ?>
        </div>
    </form>
    <?php
    if (isset($job_data)) {
        include 'includes/job_posts.php';
    }
    ?>
</body>
</html>