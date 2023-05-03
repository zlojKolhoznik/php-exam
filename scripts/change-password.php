<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']) || empty($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: login.php');
    }
    $user = $_SESSION['user'];
    $oldPassword = hash('sha256', $_POST['old-password']);
    if ($oldPassword != $user->getPasswordHash()) {
        header('Location: ../pages/settings.php?error=1');
        exit();
    }
    if ($_POST['new-password'] != $_POST['confirm-password']) {
        header('Location: ../pages/settings.php?error=2');
        exit();
    }
    $db = DB::getInstance();
    $user->setPasswordHash(hash('sha256', $_POST['new-password']));
    $db->updateUser($user);
    header('Location: ../pages/profile.php');
    exit();