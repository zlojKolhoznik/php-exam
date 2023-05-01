<?
    require_once '../config/DB.php';
    $id = $_GET['id'];
    $db = DB::getInstance();
    $db->deleteProduct($id);
    header('Location: ../pages/admin-panel.php');