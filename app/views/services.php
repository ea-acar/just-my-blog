<?php

include_once "../app/templates/parser.php";
include_once "../app/core/constants.php";
include_once "../app/core/functions.php";

if (isset($_SESSION['userId'])) {
    $id = filter_var($_SESSION['userId'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = sqlQueryBuilder($query);
    $avatar = $result[0];
    $avatarPath = $avatar['avatar'];
}

$services = new Template("../app/templates/services.template");
$services->set("css", "css/style.css");
$services->set("title", "Services");
$services->set("logo", "images/logo.png");
$services->set("content", "Archive Page");
$services->set("avatar", "images/$avatarPath");
$services->set("root", "../../");
if (isset($_SESSION['userId'])) {
    $services->set("noUser", "none");
    $services->set("isUser", "");
} else {
    $services->set("noUser", "");
    $services->set("isUser", "none");
}

echo $services->output();