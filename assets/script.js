function displayJobPost(i) {
    // reset display of all other job posts to none
    const jobPosts = document.getElementsByClassName("job-post");
    for (j = 0; j < jobPosts.length; j++) {
        jobPosts[j].style.display = "none";
    }

    // display the selected job post
    const jobPostId = "job-post" + i;
    const jobPost = document.getElementById(jobPostId);
    jobPost.style.display = "block";
}

function bookmarkJob(i, iconNumber) {
    const bookmark = document.getElementById(`bookmark${i}`);
    const icon = bookmark.firstChild;

    if (iconNumber == 1) { // indicates that this job is NOT saved
        icon.src = `../Images/bookmark-icon2.svg`;
        // save job
        document.cookie = `job${i}=true`;
    }
    else { // indicates that this job is saved
        icon.src = `../Images/bookmark-icon1.svg`;
        // unsave job
        document.cookie = `job${i}=false`;
    }
}

window.addEventListener('beforeunload', function (e) {
});

/**
 * Dynamically adjust the size of job filters based on their content.
 */
const filters = document.getElementsByClassName("filter");
for (i = 0; i < filters.length; i++) {
    const width = filters[i].firstElementChild.innerHTML.length;
    filters[i].style.width = (width > 5 ? width*0.75 : width*1.2) + "rem";
}

$(document).ready(function() {
    // When button is clicked
    $(".bookmark-btn").click(function() {
        // Use AJAX to save the job
        $.ajax({
            type: "POST",
            url: "save-job.php",
            data: {
                job_id: $(this).attr("id")
            },
            success: function(data) {
                // Update the button
                if (data == "true") {
                    $(this).html("Unsave Job");
                }
                else {
                    $(this).html("Save Job");
                }
            }
        });
    });
});
