<?php
require_once '../app/core/constants.php';
require_once '../app/core/functions.php';



if (isset($_SESSION['userId'])) {
    $id = filter_var($_SESSION['userId'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = sqlQueryBuilder($query);
    $avatar = $result[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>It is a blog</title>
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="css/style.css">
    <!-- GOOGLE FONT (MONTSERRAT) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <!-- ICON SCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>
<nav>
    <div class="container nav__container">
        <div class="nav__logo__items">
            <a href="/"><img class="nav__logo" src="images/logo.png" alt=""></a>
            <a href="/" style="font-weight: bold; font-size: x-large; color: deeppink">Just a Blog</a>
        </div>
        <ul class="nav__items">
            <li><a href="blog">Blog</a></li>
            <li><a href="about">About</a></li>
            <li><a href="services">Archive</a></li>
            <li><a href="contact">Contact</a></li>
            <?php if(isset($_SESSION['userId'])) : ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?='images/'. $avatar['avatar']?>" alt="">
                    </div>
                    <ul>
                        <li><a href="dashboard">Dashboard</a></li>
                        <li>
                            <a href="logout-logic" type="submit" methods="post" name="submit">Logout</a>
                        </li>
                    </ul>
                </li>
            <?php else : ?>
                <li><a href="login">Sign in</a></li>
            <?php endif; ?>
        </ul>
        <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
        <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
    </div>
</nav>
