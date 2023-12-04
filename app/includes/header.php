<?php
// Get current page URL
$current_page = $_SERVER['REQUEST_URI'];

// Navbar links
$navbar_links = [
    '/jobs' => 'Search Jobs',
    '/saved' => 'Saved Jobs'
];

// id for active navbar link
$navbar_active_id = 'id="navbar-active"';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Search Jobs</title>
</head>
<body>
    <!-- Navbar -->
    <ul class="navbar">
        <li><img src="public/images/logo-black.png" alt="logo" class="navbar-logo"></li>
        <li class="navbar-links-container">
            <?php foreach ($navbar_links as $link => $text): ?>
                <a href="<?= $link ?>" <?php echo ($current_page == $link ? $navbar_active_id : '') ?>><?= $text ?></a>
            <?php endforeach; ?>
            <a href="/logout" id="logout-link">Log Out</a>
        </li>
    </ul>