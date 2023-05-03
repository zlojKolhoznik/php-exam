<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']) || empty($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: login.php');
    }
    $user = $_SESSION['user'];
    $db = DB::getInstance();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <title><?php echo $user->getName() ?>'s profile - ShopyShop</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php' ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Profile</h1>
                </div>
            </div>
            <hr>
            <form action="../scripts/change-personal-info.php" method="post">
                <input type="hidden" name="id" value="<?php echo $user->getId() ?>">
                <div class="row">
                    <div class="col-12">
                        <p>Welcome, <input name="name" class="form-control" value="<?php echo $user->getName() ?>" required></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>Your email is <input name="email" type="email" class="form-control" value="<?php echo $user->getEmail() ?>" required></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>Your phone number is <input name="phone" type="tel" class="form-control" value="<?php echo $user->getPhone() ?>" required></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>Your role is <?php echo $user->getRole() == 1 ? 'Admin' : 'Customer' ?></p>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" value="Save changes">
            </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
