<?php
    require_once "models/User.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<head>
    <?php include_once "includes/links.php" ?>
</head>
<body>
    <?php include_once "includes/navbar.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>