const filters = document.getElementsByClassName("filter");
for (i = 0; i < filters.length; i++) {
    const width = filters[i].firstElementChild.innerHTML.trim().length;
    filters[i].style.width = (width > 5 ? width*0.8 : width*1.4) + "rem";
}

/* ================================== */
/* -------- Helper Functions -------- */
/* ================================== */

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

/* ================================== */
/* -------------- AJAX -------------- */
/* ================================== */

$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
        console.log("bottom");
        // ajax call get data from server and append to the div
    }
});

function bookmark(jobIndex, isSaved, jobDataStr) {
    const jobData = JSON.parse(jobDataStr);

    // add isSaved to jobData
    jobData.isSaved = isSaved;

    $.ajax({
        url: '/bookmark',
        type: 'POST',
        data: {job_data: jobData},
        success: function(response) {
            console.log(response);
            // escape characters that need to be escaped
            jobDataStr = addslashes(jobDataStr);

            // get bookmark
            const icon = $(`#bookmark-icon${jobIndex}`);

            if(response == "saved") {
                // change icon to filled bookmark and change onclick function to unsave
                icon.attr("src", "public/images/bookmark1.svg");
                icon.attr("onclick", `bookmark(${jobIndex}, true, '${jobDataStr}')`);
            }
            else if(response == "unsaved") {
                // change icon to empty bookmark and change onclick function to save
                icon.attr("src", "public/images/bookmark0.svg");
                icon.attr("onclick", `bookmark(${jobIndex}, false, '${jobDataStr}')`);
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
