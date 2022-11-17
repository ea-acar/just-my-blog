<?php
// Session starts
session_start();

// DB CONNECTION
if($_SERVER['SERVER_NAME'] == "localhost")
{
    define('DBUSER',"root");
    define('DBPASS',"1789_Ae_1826");
    define('DBNAME',"BlogSite");
    define('DBHOST',"localhost");
}else
{
    define('DBUSER',"username");
    define('DBPASS',"");
    define('DBNAME',"alternative");
    define('DBHOST',"domain");
}