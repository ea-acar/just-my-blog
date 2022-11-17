<?php
// block user to see the page
if(!isset($_SESSION['userId'])) {
    header('location: /404');
    die();
}