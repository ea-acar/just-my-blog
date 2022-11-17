<?php
require_once '../app/core/constants.php';
require_once '../app/core/functions.php';

// signup from data if button is clicked

if (isset($_POST['submit'])) {

    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

// validate input values

    if (!$firstname) {
        $_SESSION['signup'] = "Please type your First Name";
    } elseif (!$lastname) {
        $_SESSION['signup'] = "Please type your Last Name";
    } elseif (!$username) {
        $_SESSION['signup'] = "Please type your Username";
    } elseif (!$email) {
        $_SESSION['signup'] = "Please type your e-Mail";
    } elseif (strlen($createpassword) < 8) {
        $_SESSION['signup'] = "Please human, password should be minimum 8 characters";
    } elseif (!$avatar) {
        $_SESSION['signup'] = "Add an avatar, beauty";
    } else {
        //check passwords
        if ($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "My dear, passwords should match";
        } else {
            //hash password
            $hashedPassword = password_hash($createpassword, PASSWORD_DEFAULT);
            //check username and e-mail
            $userCheckResult = sqlQueryBuilder("SELECT * FROM users WHERE username='$username' OR email='$email' limit 2");
            if ($userCheckResult) {
                $_SESSION['signup'] = "Username or e-mail, something is taken.";
            } else {
                // avatar control
                // rename avatar
                $time = time(); // to make every avatar unique
                $avatarName = $time . $avatar['name'];
                $avatarTmpName = $avatar['tmp_name'];
                $avatarDestinationPath = 'images/' . $avatarName;

                // allowed file ext on avatar
                $allowedFiles = ['png', 'jpg', 'jpeg', 'heiv', 'hevc'];
                $extension = explode('.', $avatarName);
                $extension = end($extension);

                if (in_array($extension, $allowedFiles)) {
                    // file type is OK. Now, size limit checker is due
                    if ($avatar['size'] < 2000000) {
                        // upload avatar
                        move_uploaded_file($avatarTmpName, $avatarDestinationPath);
                    } else {
                        $_SESSION['signup'] = "This is not Google Drive. Please, upload an avatar up to 2MB. Thanks!";
                    }
                } else {
                    $_SESSION['signup'] = "Only jpg, png, jpeg and weird iphone extensions are allowed";
                }
            }
        }
    }

    // redirect to signup page if there is a problem

    if(isset($_SESSION['signup'])) {
        // go back to signup page
        $_SESSION['previouslyTypedData'] = $_POST;
        header('location: signup');
    } else {
        // insert new user to database
        $queryForInsert = "INSERT INTO 
                            users (firstname, lastname, username, email, password, avatar, is_admin) 
                            VALUES('$firstname', '$lastname', '$username', '$email', '$hashedPassword', '$avatarName', 0)";

        sqlQueryBuilder($queryForInsert);

        $_SESSION['signupSucceed'] = "Registration successful. Please log in";
        header('location: login');
        die();
    }

} else {
    // go back to signup page
    header('location: /404');
    die();
}