<hr>
<div class="job-board">
    <!-- This shows all the job search results -->
    <div class="jobs-list-container">
        <?php
        $i = 0;
        foreach ($jobs_results as $job) {
            echo "<button class=\"job-list-option\" onclick=\"displayJobPost($i)\">";
            echo "<div>";
            echo "<h3>" . $job['title'] . "</h3><br>";
            echo "<p>" . $job['company_name'] . "</p>";
            echo "<p>" . $job['location'] . "</p><br>";
            foreach ($job['extensions'] as $e) {
                echo "<p>" . $e . "</p>";
            }
            echo "</div>";
            echo "<div class=\"save-icon-container\">";
            $job_query = "SELECT job_id FROM jobs WHERE job_id = '" . substr($job['job_id'], 0, 700) . "';";
            $result = mysqli_query($conn, $job_query);
            // display bookmark-icon2.svg if this job is already saved
            // else display bookmark-icon1.svg
            $bookmark = "bookmark-icon1";
            if (mysqli_num_rows($result) > 0) {
                $bookmark = "bookmark-icon2";
            }
            // pass in parameters to href: saved={1|0} and job={job index}
            echo "<a href=\"{$_SERVER['REQUEST_URI']}?saved=" . (mysqli_num_rows($result) > 0 ? "1" : "0") 
                . "&job=$i\"><img src=\"../../Images/$bookmark.svg\"></img></a>";
            echo "</div>";
            echo "</button>";
            $i++;
        }
        ?>
    </div>

    <!-- This shows a full job post -->
    <div id="job-posts-container">
        <?php
        $i = 0;
        foreach($jobs_results as $job) {
            echo "<div class=\"job-post\" id=job-post$i>";
            echo "<h2>" . $job['title'] . "</h2>";
            echo "<br><p>" . $job['company_name'] . "</p>";
            echo "<p>" . $job['location'] . "</p><br>";
            $extensions = $job['extensions'];
            foreach($extensions as $extension) {
                echo "<p>$extension</p>";
            }
            $job_highlights = $job['job_highlights'];
            if (count($job_highlights) > 1 || count($job_highlights[0]['items']) > 1) {
                echo "<br><h3>Job Highlights</h3>";
                echo "<div>";
                    foreach($job_highlights as $highlight) {
                        echo "<div>";
                        echo "<br><h4>" . $highlight['title'] . "</h4>";
                        echo "<ul>";
                        $items = $highlight['items'];
                        foreach($items as $item) {
                            echo "<li>$item</li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                    }
                echo "</div>";
            }
            echo "<br><h3>Full Job Description</h3><br>";
            echo "<p>" . str_replace("\n", "<br>", $job['description']) ."</p>";
            echo"</div>";
            $i++;
        }
        ?>
    </div>
</div>
<script src="../../assets/script.js"></script>