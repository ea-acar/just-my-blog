<?php
require_once '../app/core/constants.php';
require_once '../app/core/functions.php';
require_once '../app/logics/dashboard-logic.php';
// if user is not admin, can not see this page

if(isset($_SESSION['userAdmin'])) {

    if (isset($_GET['id']) && $_GET['id'] > 0) {

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM categories WHERE id=$id";
        $category = sqlQueryBuilder($query);

        $queryForPostToRelocate = "UPDATE posts SET categoryid=14 WHERE categoryid=$id";
        sqlQueryBuilder($queryForPostToRelocate);

        $categoryDeleteQuery = "DELETE FROM categories WHERE id=$id AND NOT id=14 LIMIT 1";
        $resultDeleteRequest = sqlQueryBuilder($categoryDeleteQuery);

        if(isset($resultDeleteRequest)) {

            if($category[0]['id']==14) {
                $_SESSION['categoryDeleteForbidden'] = "Category can not be deleted. Simply, it is forbidden.";
                header("location: manage-categories");
            } else {
                $_SESSION['categoryDeleteSucceed'] = "Category has been deleted";
                header("location: manage-categories");
            }

        } else {
            $_SESSION['deleteCategoryErrorMessage'] = "Category is not deleted";
            header('location: manage-categories');
        }
    } else {
        header('location: manage-categories');
        die();
    }
} else {
    header('location: index');
    die();
}
