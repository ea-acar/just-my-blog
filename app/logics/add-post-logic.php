<?php
require_once '../app/core/constants.php';
require_once '../app/core/functions.php';
require_once '../app/logics/dashboard-logic.php';


if (isset($_POST['submit'])) {
    $author = $_SESSION['userId'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categoryId = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $isFeatured = filter_var($_POST['isFeatured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // control on isFeatured
    $isFeatured = $isFeatured == 1 ?: 0;

    // validation

    if (!$title) {
        $_SESSION['addPostErrorMessage'] = "Give the post a title";
    } elseif (!$categoryId) {
        $_SESSION['addPostErrorMessage'] = "Select the category of the post";
    } elseif (!$content) {
        $_SESSION['addPostErrorMessage'] = "Type something, eh?";
    } elseif (!$thumbnail['name']) {
        $_SESSION['addPostErrorMessage'] = "Choose a thumbnail to beautify";
    } else {
        $timeForThumbnail = time(); // to give a unique name
        $thumbnailName = $timeForThumbnail . $thumbnail['name'];
        $thumbnailTmpName = $thumbnail['tmp_name'];
        $thumbnailDestinationPath = 'images/' . $thumbnailName;

        // allowed file ext for thumbnails
        $allowedFiles = ['png', 'jpg', 'jpeg', 'heiv', 'hevc'];
        $extension = explode('.', $thumbnailName);
        $extension = end($extension);

        if (in_array($extension, $allowedFiles)) {
            // file type is OK. Now, size limit checker is due
            if ($thumbnail['size'] < 2000000) {
                // upload avatar
                move_uploaded_file($thumbnailTmpName, $thumbnailDestinationPath);
            } else {
                $_SESSION['addPostErrorMessage'] = "This is not Google Drive. Please, upload a thumbnail up to 2MB. Thanks!";
            }
        } else {
            $_SESSION['addPostErrorMessage'] = "Only jpg, png, jpeg and weird iphone extensions are allowed";
        }
    }

    //if there is an error message save the data

    if (isset($_SESSION['addPostErrorMessage'])) {

        $_SESSION['prevTypedPostData'] = $_POST;
        header('location: add-post');
        die();
    } else {

        // set all posts feature to zero if it is set to 1 for this post
        if ($isFeatured == 1) {
            $queryToSetFeatureToZero = "UPDATE posts SET is_featured=0 ";
            sqlQueryBuilder($queryToSetFeatureToZero);
        }

        $queryInsertPost = "INSERT INTO posts (userid, categoryid, title, content, thumbnail, is_featured)
                            VALUES ($author, $categoryId, '$title', '$content', '$thumbnailName', $isFeatured)";
        $result = sqlQueryBuilder($queryInsertPost);
        $_SESSION['postSucceed'] = "Post has been added";
        header('location: dashboard');
    }


} else {
    header('location: add-postß');
}
