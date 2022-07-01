<?php
    session_start();
    require ('../../../../vendor/autoload.php'); 
    $users = new \Classes\View\UsersView();
    $log = $_GET['user'];

    $users->showMessages();
?>