<?php

/**
 * Middleware to check if a user is authenticated.
 * If user is not authenticated, redirect to login page.
 */
$checkAuthenticated = function() {
    global $database;

    // start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // check if user is authenticated
    if (!$database->is_authenticated()) {
        header("Location: /login");
    }
};

/**
 * Middleware to check if a user is not authenticated.
 * If user is authenticated, redirect to jobs page.
 */
$checkNotAuthenticated = function() {
    global $database;

    // start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // check if user is authenticated
    if ($database->is_authenticated()) {
        header("Location: /jobs");
    }
};