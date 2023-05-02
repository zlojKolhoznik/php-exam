<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $db = DB::getInstance();
    $id = $_GET['id'];
    $order = $db->getOrder($id);
    if ($order->getStatus() == 'pending') {
        $db->updateOrderStatus($id, 'accepted');
    } elseif ($order->getStatus() == 'accepted') {
        $db->updateOrderStatus($id, 'delivering');
    } elseif ($order->getStatus() == 'delivering') {
        $db->updateOrderStatus($id, 'delivered');
    } elseif ($order->getStatus() == 'delivered') {
        $db->updateOrderStatus($id, 'completed');
    }
    if ($_SESSION['user']->getRole() == 1 && $order->getStatus() != 'delivered') {
        header('Location: ../pages/admin-panel.php');
    } else {
        header('Location: ../pages/orders.php');
    }
    exit();