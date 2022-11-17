<?php

require_once '../app/model/database.php';




$uri = parse_url(
    filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL)
)['path'];

$routes = [
    '/' => 'app/views/blog.php',
    '/index' => 'app/views/blog.php',
    '/blog' => 'app/views/blog.php',
    '/home' => 'app/views/blog.php',
    '/main' => 'app/views/blog.php',
    '/about' => 'app/views/about.php',
    '/add-category' => 'app/views/add-category.php',
    '/add-post' => 'app/views/add-post.php',
    '/add-user' => 'app/views/add-user.php',
    '/category-posts' => 'app/views/category-posts.php',
    '/contact' => 'app/views/contact.php',
    '/dashboard' => 'app/views/dashboard.php',
    '/edit-category' => 'app/views/edit-category.php',
    '/edit-post' => 'app/views/edit-post.php',
    '/edit-user' => 'app/views/edit-user.php',
    '/login' => 'app/views/login.php',
    '/manage-categories' => 'app/views/manage-categories.php',
    '/manage-user' => 'app/views/manage-user.php',
    '/post' => 'app/views/post.php',
    '/services' => 'app/views/services.php',
    '/signup' => 'app/views/signup.php',
    '/login-logic' => 'app/logics/login-logic.php',
    '/signup-logic' => 'app/logics/signup-logic.php',
    '/logout-logic' => 'app/logics/logout-logic.php',
    '/edit-user-logic' => 'app/logics/edit-user-logic.php',
    '/edit-post-logic' => 'app/logics/edit-post-logic.php',
    '/edit-category-delete-user-logic' => 'app/logics/edit-category-delete-user-logic.php',
    '/delete-post-logic' => 'app/logics/delete-post-logic.php',
    '/delete-user-logic' => 'app/logics/delete-user-logic.php',
    '/delete-category-logic' => 'app/logics/delete-category-logic.php',
    '/add-user-logic' => 'app/logics/add-user-logic.php',
    '/add-category-logic' => 'app/logics/add-category-logic.php',
    '/add-post-logic' => 'app/logics/add-post-logic.php',
    '/404' => 'app/views/404.php'
];

   if(array_key_exists($uri, $routes)) {
      require_once "../" . "$routes[$uri]";
    } else {
       require_once "../app/views/404.php";
   }