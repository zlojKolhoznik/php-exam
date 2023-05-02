<?php
    require_once '../config/DB.php';
    $db = DB::getInstance();
    $id = $_GET['id'];
    $order = $db->getOrder($id);
    $cart = $db->getCart($order->getCartId());
    $db->deleteOrder($id);
    $db->deleteCart($cart->getId());
    foreach($cart->getProductsInfo() as $productInfo) {
        $db->removeProductFromCart($cart->getId(), $productInfo['id']);
    }
    header('Location: ../pages/admin-panel.php');
    exit();