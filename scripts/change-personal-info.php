<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']) || empty($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: login.php');
    }
    $user = $_SESSION['user'];
    $db = DB::getInstance();
    $user->setName($_POST['name']);
    $user->setEmail($_POST['email']);
    $user->setPhone($_POST['phone']);
    $db->updateUser($user);
    header('Location: ../pages/profile.php');
    exit();