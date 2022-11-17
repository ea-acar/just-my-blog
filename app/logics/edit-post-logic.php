<?php

require_once '../app/core/constants.php';
require_once '../app/core/functions.php';
require_once '../app/logics/dashboard-logic.php';

if (isset($_POST['submit'])) {

    $userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);

    if ($_SESSION['userAdmin'] || $userid == $_SESSION['userId']) {

        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $prevThumbnailName = filter_var($_POST['prevThumbnailName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $categoryId = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $isFeatured = filter_var($_POST['isFeatured'], FILTER_SANITIZE_NUMBER_INT);
        $thumbnail = $_FILES['thumbnail'];

        // set is_featured to 0 if it was unchecked
        $isFeatured = $isFeatured == 1 ?: 0;

        if (!$title) {
            $_SESSION['editPostErrorMessage'] = "Couldn't update post. Invalid form data on edit post page.";
        } elseif (!$categoryId) {
            $_SESSION['editPostErrorMessage'] = "Couldn't update post. Invalid form data on edit post page.";
        } elseif (!$content) {
            $_SESSION['editPostErrorMessage'] = "Couldn't update post. Invalid form data on edit post page.";
        } else {
            // to delete existing thumbnail
            if ($thumbnail['name']) {
                $prevThumbnailPath = 'images/' . $prevThumbnailName;
                if ($prevThumbnailPath) {
                    unlink($prevThumbnailPath);
                }
                // Rename image
                $time = time(); // to make each image name unique
                $thumbnailName = $time . $thumbnail['name'];
                $thumbnailTmpName = $thumbnail['tmp_name'];
                $thumbnailDestinationPath = 'images/' . $thumbnailName;

                // make sure file is an image
                $allowedFiles = ['png', 'jpg', 'jpeg', 'heiv', 'hevc'];
                $extension = explode('.', $thumbnailName);
                $extension = end($extension);
                if (in_array($extension, $allowedFiles)) {
                    // make sure avatar is not too large (2mb+)
                    if ($thumbnail['size'] < 2000000) {
                        // upload avatar
                        move_uploaded_file($thumbnailTmpName, $thumbnailDestinationPath);
                    } else {
                        $_SESSION['editPostErrorMessage'] = "Couldn't update the post. Thumbnail size too big. Should be less than 2mb since it's not your personal drive";
                    }
                } else {
                    $_SESSION['editPostErrorMessage'] = "Couldn't update the post. Thumbnail should be png, jpg or jpeg. Okay, also Apple ones.";
                }
            }
        }

        if(isset($_SESSION['editPostErrorMessage'])) {
            header('location: edit-post.php');
        } else {
            // set is_featured of all posts to 0 if for this post it is set
            if ($isFeatured == 1) {
                $setOtherFeaturesZeroQuery = "UPDATE posts SET is_featured=0";
                sqlQueryBuilder($setOtherFeaturesZeroQuery);
            }

            // to set a thumbnail name if there is a change
            $thumbnailToInsert = $thumbnailName ?? $prevThumbnailName;

            $query = "UPDATE posts SET title='$title', content='$content', thumbnail='$thumbnailToInsert', categoryid=$categoryId, is_featured=$isFeatured WHERE id=$id LIMIT 1";
            sqlQueryBuilder($query);
            $_SESSION['editPostSucceed'] = "Post has been edited and updated. Now it's greater than ever it has been";
            header('location: dashboard');
            die();
        }
    } else {
        header('location: index.php');
        die();
    }
} else {

    header('location: index');
    die();
}

