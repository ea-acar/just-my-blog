<?php
include_once "../app/partials/header.php";
require_once '../app/logics/dashboard-logic.php';
// if user is not admin, can not see this page
if($_SESSION['isAdmin'] === 0) {
    header('location: /404');
    die();
}

if (isset($_POST['submit'])) {

    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title) {
        $_SESSION['errorMessageCategory'] = "";
    } elseif (!$description) {
        $_SESSION['errorMessageCategory'] = "";
    }

    if (isset($_SESSION['errorMessageCategory'])) {
        $_SESSION['addCategoryData'] = $_POST;
        header('location: add-category');
    } else {

        $query = "INSERT INTO categories (category, description) 
                    VALUES ('$title', '$description')";
        $result = sqlQueryBuilder($query);

        $_SESSION['addCategorySucceed'] = "Category has been added";
        header('location: manage-categories');
        die();
    }
}