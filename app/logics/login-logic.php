<?php

require_once '../app/core/constants.php';
require_once '../app/core/functions.php';

// if submit button is clicked

if (isset($_POST['submit'])) {
    //get the form data

    $usernameOrMail = filter_var($_POST['usernameOrMail'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate values

    if (!$usernameOrMail) {
        $_SESSION['login'] = "Type either username or e-Mail";
    } elseif (!$password) {
        $_SESSION['login'] = "Password is required";
    } else {
        // fetch users from database
        $fetchUserInfo = "SELECT * FROM users WHERE username='$usernameOrMail' OR email='$usernameOrMail' limit 2";
        $userInfo = sqlQueryBuilder($fetchUserInfo);


        if ($userInfo) {
            if (password_verify($password, $userInfo[0]['password'])) {
                // set a grant access session
                $_SESSION['userId'] = $userInfo[0]['id'];
                $_SESSION['isAdmin'] = $userInfo[0]['is_admin'];
                // set session if user is admin
                if ($userInfo[0]['is_admin'] == 1) {
                    $_SESSION['userAdmin'] = true;
                }
                //log user in
                header('location: dashboard');
            } else {
                $_SESSION['login'] = "Please check your password";
            }
        } else {
            // gives an error for username or email
            $_SESSION['login'] = "You are surely -at least we hope- a human but not an user. Please check your username.";
        }
    }

    if(isset($_SESSION['login'])) {
        $_SESSION['previouslyTypedLoginData'] = $_POST;
        header('location: login');
        die();
    }
} else {
    // if human being didn't click submit button
    header('location: /404');
    die();
}
