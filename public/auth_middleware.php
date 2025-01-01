<?php
function checkAuth() {
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: components/signup/login.html');
        exit();
    }
    return true;
}

function logout() {
    session_start();
    session_destroy();
    header('Location: components/signup/login.html');
    exit();
}

// Prevent session fixation
function regenerateSession() {
    if (isset($_SESSION['last_regeneration'])) {
        if (time() - $_SESSION['last_regeneration'] > 3600) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    } else {
        $_SESSION['last_regeneration'] = time();
    }
}
?>