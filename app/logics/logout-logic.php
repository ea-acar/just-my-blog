<?php

require_once '../app/core/constants.php';
require_once '../app/core/functions.php';

//destroy sessions and go to index page
session_destroy();
header('location: index');