<?php
    // Job post info
    $title = $job['title'];
    $company = $job['company_name'];
    $location = $job['location'];
    $extensions = $job['extensions'];
    $highlights = $job['job_highlights'];
    $description = str_replace("\n", "<br>", $job['description']);
?>

<div class="job-post" id="job-post<?= $index ?>">
    <!-- Heading and subheadings -->
    <h2><?= $title ?></h2>
    <br>
    <p><?= $company ?></p>
    <p><?= $location ?></p>
    <br>

    <!-- Job extensions -->
    <?php foreach ($extensions as $extension): ?>
        <p><?= $extension ?></p>
    <?php endforeach; ?>

    <!-- Job highlights -->
    <?php if (count($highlights) > 1 || count($highlights[0]['items']) > 1): ?>
        <br>
        <h3>Job Highlights</h3>
        <div>
            <?php foreach ($highlights as $highlight): ?>
                <div>
                    <br>
                    <h4><?= $highlight['title'] ?></h4>
                    <ul>
                        <?php foreach ($highlight['items'] as $item): ?>
                            <li><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br>

    <!-- Full job description -->
    <h3>Full Job Description</h3>
    <br>
    <p><?= $description ?></p>
</div>