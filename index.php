<?php
require 'database/connection.php';
require 'requests/jobs/JobData.php';

// For debugging (change this later)
$data_file = file_get_contents('json_data.json');
load_data($data_file);

// set job_data based on previous search
// if (isset($_COOKIE['job_data'])) {
//     $job_data = json_decode($_COOKIE['job_data'], true);
//     $job_query = $job_data['search_parameters']['q'];
//     get_new_job_data($job_query);
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function saveJob(isSaved, jobId) {
            $.ajax({
                url: '/requests/jobs/save_job.php',
                type: 'POST',
                data: {
                    isSaved: isSaved,
                    jobId: jobId
                },
                success: function (response) {
                    console.log(response);
                    $(`#saved-status-${jobId}`).text(" " + response);
                }
            });
        }
    </script>
    <title>Job Board</title>
</head>
<body>
    <?php
    if (isset($_COOKIE['job_data'])) {
        // display jobs
        require 'jobs_results.php';
    }
    else {
        // call to action
        echo "<p><i>No jobs searched yet.</i></p>";
        echo "<h3>Start getting hired!</h3>";
    }
    ?>
</body>
</html>