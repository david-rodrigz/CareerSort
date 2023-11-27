<?php

include_once "app/middleware/AuthMiddleware.php"; // middleware
include_once "app/router.php"; // router

// Create a new Router instance
$router = new Router();

// home route
$router->addRoute('GET', '/', $authMiddleware, function () {
    echo "Welcome to my <b>home</b> page!";
    exit;
});

// blogs route
$router->addRoute('GET', '/blogs', null, function () {
    echo "Welcome to my <b>blogs</b> page!";
    exit;
});

$router->matchRoute();
