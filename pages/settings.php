<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']) || empty($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: login.php');
    }
    $user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/custom-styles.css">
        <title>Settings - ShopyShop</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php' ?>
        <h1 class="text-center mt-3">Change password</h1>
        <hr>
        <div class="container">
            <form action="../scripts/change-password.php" method="post">
                <input type="hidden" name="id" value="<?php echo $user->getId() ?>">
                <div class="form-floating mb-3 has-validation">
                    <input placeholder="Password" class="form-control <?php if ($_GET['error'] == 1) echo 'is-invalid' ?>" name="old-password" type="password" required>
                    <label class="form-label" for="old-password">Old password</label>
                    <p class="invalid-feedback text-danger">Incorrect password!</p>
                </div>
                <div class="form-floating mb-3">
                    <input placeholder="Password" class="form-control" name="new-password" type="password" required>
                    <label class="form-label" for="new-password">New password</label>
                </div>
                <div class="form-floating mb-3 has-validation">
                    <input placeholder="Password" class="form-control <?php if ($_GET['error'] == 2) echo 'is-invalid' ?>" name="confirm-password" type="password" required>
                    <label class="form-label" for="confirm-password">Confirm password</label>
                    <p class="invalid-feedback text-danger">Passwords do not match!</p>
                </div>
                <input type="submit" id="submit" value="Change password" class="btn btn-primary">
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>