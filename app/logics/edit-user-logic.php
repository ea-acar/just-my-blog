<?php
require_once '../app/core/constants.php';
require_once '../app/core/functions.php';
require_once '../app/logics/dashboard-logic.php';

if($_SESSION['isAdmin'] === 0) {
    header('location: index');
    die();
}

if (isset($_POST['submit'])) {

    $id = $_SESSION['editUserId'];

    // get updated form data
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);

    // check for valid input
    if (!$firstname || !$lastname) {
        $_SESSION['editUserMessage'] = "Either firstname or lastname left blank";
    } else {
        // update user
        $query = "UPDATE users SET firstname='$firstname', lastname='$lastname', username='$username', is_admin=$is_admin WHERE id=$id LIMIT 1";
        $result = sqlQueryBuilder($query);

        $_SESSION['editUserSucceed'] = "Registration successful. Please log in";
        header('location: manage-user');
        die();

    }
} else {
    header('location: manage-user');
    die();
}

