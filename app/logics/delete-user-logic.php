<?php
require_once '../app/core/constants.php';
require_once '../app/core/functions.php';
require_once '../app/logics/dashboard-logic.php';

if(isset($_SESSION['userAdmin'])) {

    if (isset($_GET['id']) && $_GET['id'] > 0) {

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM users WHERE id=$id";
        $result = sqlQueryBuilder($query);
        $user = $result;

        $deleteUserQuery = "DELETE FROM users WHERE id=$id";
        $result = sqlQueryBuilder($deleteUserQuery);
        header('location: manage-user');

    } else {
        header('location: manage-user');
        $_SESSION['deleteUserMessage'] = "User is not deleted";
        die();
    }
} else {
    header('location: index');
    die();
}
