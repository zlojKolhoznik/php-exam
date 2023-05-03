<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SESSION['user'] == null) {
        echo "<script>alert('You must be logged in to add products to cart!')</script>";
        header("Location: ../pages/login.php");
        exit();
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