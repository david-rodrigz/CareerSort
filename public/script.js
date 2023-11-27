function displayJobPost(i) {
    console.log(i);
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

const filters = document.getElementsByClassName("filter");
for (i = 0; i < filters.length; i++) {
    const width = filters[i].firstElementChild.innerHTML.length;
    filters[i].style.width = (width > 5 ? width*0.75 : width*1.2) + "rem";
}
