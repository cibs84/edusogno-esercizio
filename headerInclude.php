<?php
    require_once 'functions.php';
    require_once 'models/User.php';
    require_once 'models/Event.php';
    require_once 'view/top.php';

    // VARIABLES
    $currentPageUrl = $_SERVER['PHP_SELF'];
    $updateUserUrl = 'updateUser.php';
    $userControllerUrl = "controllers/UserController.php";

    require_once 'view/header.php';