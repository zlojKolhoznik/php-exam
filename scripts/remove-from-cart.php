<?php
    require_once "../config/DB.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $db = DB::getInstance();
    $db->removeProductFromCart($db->getActiveUserCart($_SESSION['user']->getId())->getId(), $_POST['product_id']);
    header("Location: ../pages/cart.php");
    exit();