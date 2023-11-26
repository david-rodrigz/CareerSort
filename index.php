<?php
require 'database/connection.php';
require 'requests/jobs/JobData.php';

// For debugging (change this later)
$data_file = file_get_contents('json_data.json');
load_data($data_file);

// set job_data based on previous search
// if (isset($_SESSION['last_search'])) {
//     get_new_job_data($_SESSION['last_search']);
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function saveJob(jobResultId, isSaved, jobDataStr) {
            const jobData = JSON.parse(jobDataStr);

            // add isSaved to jobData
            jobData.isSaved = isSaved;

            $.ajax({
                url: '/requests/jobs/save_job.php',
                type: 'POST',
                data: {job_data: jobData},
                success: function(response) {
                    console.log(response);
                    console.log(`#job-post-${jobResultId}`);

                    // get button
                    const btn = $(`#job-post-${jobResultId}`);

                    if(response == "saved") {
                        // change button text
                        btn.text("Unsave Job");
                        btn.attr("onclick", `saveJob("true", '${jobDataStr}')`);
                    }
                    else if(response == "unsaved") {
                        // change button text
                        btn.text("Save Job");
                        btn.attr("onclick", `saveJob("false", '${jobDataStr}')`);
                    }
                    else {
                        console.error(response);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
    <title>Job Board</title>
</head>
<body>
    <?php
    if (isset($job_data)) {
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