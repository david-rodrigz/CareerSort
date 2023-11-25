<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function saveJob(isSaved, jobId) {
            $.ajax({
                url: '/request/jobs/save_job.php',
                type: 'POST',
                data: {
                    isSaved: isSaved,
                    jobId: jobId
                },
                success: function (response) {
                    console.log(response);
                }
            });
        }
    </script>
    <title>Job Board</title>
</head>
<body>
    <button class="save-job-btn" id="1" onclick="saveJob(false, 1)">Save Job1</button>
    <button class="save-job-btn" id="2" onclick="saveJob(false, 2)">Save Job2</button>
    <button class="save-job-btn" id="3" onclick="saveJob(false, 3)">Save Job3</button>
</body>
</html>