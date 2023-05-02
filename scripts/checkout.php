<?php
    require_once "../config/DB.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $db = DB::getInstance();
    $cart = $db->getActiveUserCart($_SESSION['user']->getId());
    $db->updateCartStatus($cart->getId(), 'ordered');
    $db->addOrder($cart->getId());
    header("Location: ../index.php");
    exit();