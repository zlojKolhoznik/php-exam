<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $db = DB::getInstance();
    $product = $db->getProductById($_POST['id']);
    $user = $_SESSION['user'];
    $cart = $db->getActiveUserCart($user->getId());
    if ($cart == null) {
        $db->addCart($user->getId());
        $cart = $db->getActiveUserCart($user->getId());
    }
    $db->addProductToCart($cart->getId(), $product->getId(), $_POST['quantity']);
    header("Location: ../pages/cart.php");
    exit();