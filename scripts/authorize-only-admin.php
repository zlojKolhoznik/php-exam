<?php
if (!isset($_SESSION['user']) || $_SESSION['user']->getRole() != 1) {
    header("Location: ../index.php");
}