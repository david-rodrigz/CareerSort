<?php

/**
 * checks if a user is authenticated
 */
function is_authenticated(): bool {
    global $conn;

    // start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM USERS WHERE user_id = '$id' LIMIT 1";

        $result = mysqli_query($conn,$query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return true;
        }
    }
    return false;
};

/**
 * Middleware to check if a user is authenticated.
 * If user is not authenticated, redirect to login page.
 */
$checkAuthenticated = function() {
    // start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // check if user is authenticated
    if (!is_authenticated()) {
        header("Location: /login");
    }
};

/**
 * Middleware to check if a user is not authenticated.
 * If user is authenticated, redirect to dashboard page.
 */
$checkNotAuthenticated = function() {
    // start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // check if user is authenticated
    if (is_authenticated()) {
        header("Location: /dashboard");
    }
};