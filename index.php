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
        $(window).scroll(function() {
            if($(window).scrollTop() == $(document).height() - $(window).height()) {
                console.log("bottom");
                // ajax call get data from server and append to the div
            }
        });

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

                    // escape characters that need to be escaped
                    jobDataStr = addslashes(jobDataStr);

                    // get button
                    const btn = $(`#job-post-${jobResultId}`);

                    if(response == "saved") {
                        // change button text
                        btn.text(`Unsave Job ${jobResultId}`);
                        btn.attr("onclick", `saveJob(${jobResultId}, true, '${jobDataStr}')`);
                    }
                    else if(response == "unsaved") {
                        // change button text
                        btn.text(`Save Job ${jobResultId}`);
                        btn.attr("onclick", `saveJob(${jobResultId}, false, '${jobDataStr}')`);
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

        function addslashes(string) {
            return string.replace(/\\/g, '\\\\').
                replace(/\u0008/g, '\\b').
                replace(/\t/g, '\\t').
                replace(/\n/g, '\\n').
                replace(/\f/g, '\\f').
                replace(/\r/g, '\\r').
                replace(/'/g, '\\\'').
                replace(/"/g, '\\"');
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
    <!-- make a div large enough to scroll -->
    <div style="height: 1000px;"></div>
</body>
</html>