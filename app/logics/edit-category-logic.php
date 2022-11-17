<?php

require_once '../app/core/constants.php';
require_once '../app/core/functions.php';
require_once '../app/logics/dashboard-logic.php';

if($_SESSION['isAdmin'] === 0) {
    header('location: index');
    die();
}

if (isset($_POST['submit'])) {
    $id = $_SESSION['editCategoryId'];
    // get updated form data
    $category = filter_var($_POST['category'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // check for valid input
    if (!$category || !$description) {
        $_SESSION['editCategoryMessage'] = "Either category title or description left blank";
        header('location: manage-categories');
    } else {
        $query = "UPDATE categories SET category='$category', description='$description' WHERE id=$id LIMIT 1";
        $result = sqlQueryBuilder($query);

        $_SESSION['editCategorySucceed'] = "Category has been updated";
        header('location: manage-categories');
        die();
    }
} else {
    header('location: index');
    die();
}