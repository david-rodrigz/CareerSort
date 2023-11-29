<?php

// Get database connection
$conn = $database->get_connection();

// Get job data from POST request
$job_data = $_POST['job_data'];

// Disect JSON job data
$title = str_replace("'", "\'", $job_data['title']);
$company_name = str_replace("'", "\'", $job_data['company_name']);
$location = str_replace("'", "\'", $job_data['location']);
$description = str_replace("'", "\'", $job_data['description']);
$job_id = substr($job_data['job_id'], 0, 700);
$job_highlights = $job_data['job_highlights'];
$thumbnail_link = isset($job_data['thumbnail']) ? $job_data['thumbnail'] : "NULL";
$website = isset($job_data['related_links']) && count($job_data['related_links']) > 0 ? $job_data['related_links'][0]['link'] : "";

// Delete job data if already saved, else save it
if ($job_data['isSaved'] == "false") {
    // Check if company already exists
    $company_q = "SELECT company_name FROM companies WHERE company_name = " 
    . "'$company_name';";
    
    // Add company only if it does not already exist in database
    if ($conn->query($company_q)->rowCount() == 0) {
        $insert_company = "INSERT INTO companies (company_name, thumbnail_link, website) "
            . "VALUES (:company_name, :thumbnail_link, :website);";
        $stmt = $conn->prepare($insert_company);
        $stmt->bindParam(':company_name', $company_name);
        $stmt->bindParam(':thumbnail_link', $thumbnail_link);
        $stmt->bindParam(':website', $website);
        $stmt->execute();
    }

    // Prepare insert statements: one for job data, one for apply options
    $insert_job = "INSERT INTO jobs (job_id, title, location, description, company_name, user_id) "
        . "VALUES (:job_id, :title, :location, :description, :company_name, :user_id);";
    $insert_apply_options = "INSERT INTO apply_options (link, job_id) "
        . "VALUES ('fake-link.com', :job_id);"; // TODO: (change 'fake-link.com' later)
    
    // Insert job data into database
    $stmt = $conn->prepare($insert_job);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':company_name', $company_name);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();

    // Insert apply options into database
    $stmt = $conn->prepare($insert_apply_options);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();

    // Add job highlights only if it is not a reiteration of the job description
    if (count($job_highlights) > 1 || count($job_highlights[0]['items']) > 1) {
        foreach ($job_highlights as $highlight) {
            // Get title and items from "job_highlights" in JSON
            $highlight_title = str_replace("'", "\'", $highlight['title']);
            $highlight_items = "";
            foreach ($highlight['items'] as $item) {
                $highlight_items = $highlight_items . "\n" . str_replace("'", "\'", $item);
            }

            // Set up insert statement
            $insert_job_highlights = "INSERT INTO job_highlights (title, items, job_id) " 
                . "VALUES (:highlight_title, :highlight_items, :job_id);";

            // Insert highlight
            $stmt = $conn->prepare($insert_job_highlights);
            $stmt->bindParam(':highlight_title', $highlight_title);
            $stmt->bindParam(':highlight_items', $highlight_items);
            $stmt->bindParam(':job_id', $job_id);
            $stmt->execute();
        }
    }
    echo "saved";
}
else {
    // Prepare delete statements
    $delete_job_highlights = "DELETE FROM job_highlights WHERE job_id = :job_id;";
    $delete_apply_options = "DELETE FROM apply_options WHERE job_id = :job_id;";
    $delete_job = "DELETE FROM jobs WHERE job_id = :job_id;";

    // Delete job highlights
    $stmt = $conn->prepare($delete_job_highlights);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();

    // Delete apply options
    $stmt = $conn->prepare($delete_apply_options);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();

    // Delete job
    $stmt = $conn->prepare($delete_job);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();

    echo "unsaved";
}