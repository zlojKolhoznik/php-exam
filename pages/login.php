<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/custom-styles.css">
        <title>Login - ShopyShop</title>
    </head>
    <body>
        <div class="container d-flex justify-content-center">
            <div class="card mt-5 p-3 col-6">
                <div class="card-title">
                    <h1 class="text-center">Log in</h1>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="form-floating mb-3 has-validation">
                                <input type="email" name="email" id="email" class="form-control" placeholder="name@example.com">
                                <label for="email">Email</label>
                                <div class="invalid-feedback">
                                    No user with this email exists.
                                </div>
                            </div>
                            <div class="form-floating mb-3 has-validation">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                <label for="password">Password</label>
                                <div class="invalid-feedback">
                                    Incorrect password.
                                </div>
                            </div>
                            <p class="text-muted mb-3">Do not have an account? <a href="signup.php">Sign up!</a></p>
                            <div class="form-group">
                                <input type="submit" value="Log in" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if ($_GET['error'] == 1): ?>
            <script>
                document.getElementById('email').classList.add('is-invalid');
            </script>
        <?php elseif ($_GET['error'] == 2): ?>
            <script>
                document.getElementById('password').classList.add('is-invalid');
            </script>
        <?php endif; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
<?php
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    exit();
}
include_once '../config/DB.php';
$email = $_POST['email'];
$password_hash = hash('sha256', $_POST['password']);
$remember_me = $_POST['remember'];
$db = DB::getInstance();
$user = $db->getUserByEmail($email);
if ($user == null) {
    header('Location: ?error=1');
    exit();
}
if ($user->getPasswordHash() != $password_hash) {
    header('Location: ?error=2');
    exit();
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['user'] = $user;
header('Location: ../index.php');
exit();
