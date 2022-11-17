<?php
require_once '../app/core/constants.php';
require_once '../app/core/functions.php';
require_once '../app/logics/dashboard-logic.php';

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    function deletePost() {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM posts WHERE id=$id";
        $result = sqlQueryBuilder($query);
        if ($result) {
            $thumbnailName = $result[0]['thumbnail'];
            $thumbnailPath = 'images/' . $thumbnailName;
            if ($thumbnailPath) {
                unlink($thumbnailPath);
                $query = "DELETE FROM posts WHERE id=$id LIMIT 1";
                sqlQueryBuilder($query);
                $_SESSION['deletePostSucceed'] = "Post has been deleted. No joke.";
                header('location: dashboard');
            }
        }
    }

    if (isset($_SESSION['userAdmin'])) {
        deletePost();
    } elseif (isset($_SESSION['userId'])) {
        $query = "SELECT * FROM posts WHERE posts.id=$id";
        $post = sqlQueryBuilder($query);

        if ($post[0]['userid'] == $_SESSION['userId']) {
            deletePost();
        } else {
            header('location: dashboard');
        }
    } else {
        header('location: dashboard');
    }
} else {
    header('location: index');
}