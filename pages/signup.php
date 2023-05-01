<?php 
include_once '../config/DB.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['submit'])) {
    if (!isset($_POST['email'])) {
        header('Location: signup.php?error=2');
        exit();
    } elseif (!isset($_POST['password'])) {
        header('Location: signup.php?error=3');
        exit();
    } elseif (!isset($_POST['password2'])) {
        header('Location: signup.php?error=4');
        exit();
    } elseif (!isset($_POST['name'])) {
        header('Location: signup.php?error=5');
        exit();
    } elseif (!isset($_POST['phone'])) {
        header('Location: signup.php?error=6');
        exit();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    if ($password !== $password2) {
        header('Location: signup.php?error=7');
        exit();
    }

    $db = DB::getInstance();
    $user = $db->getUserByEmail($email);
    if ($user !== null) {
        header('Location: signup.php?error=1');
        exit();
    }
    $db->addUser($email, hash('sha256', $password), $name, $phone, 0);
    $user = $db->getUserByEmail($email);
    $_SESSION['user'] = $user;
    if (isset($_POST['remember'])) {
        setcookie('userId', $user->getId(), time() + 60 * 60 * 24 * 30, '/');
    }
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/custom-styles.css">
        <title>Sign up - ShopyShop</title>
    </head>
    <body>
    <div class="container d-flex justify-content-center">
            <div class="card mt-5 p-3 col-6">
                <div class="card-title">
                    <h1 class="text-center">Sign up</h1>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="form-floating mb-3 has-validation">
                                <input type="text" name="name" id="name" class="form-control" placeholder="John Doe">
                                <label for="name">Name</label>
                                <div class="invalid-feedback">
                                    Please enter your name.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-floating mb-3 has-validation">
                                <input type="email" name="email" id="email" class="form-control" placeholder="name@example.com">
                                <label for="email">Email</label>
                                <div class="invalid-feedback">
                                    Account with this email already exists.
                                </div>
                                <p class="text-muted">We won't share your email with anyone.</p>
                            </div>
                            <div class="form-floating mb-3 has-validation">
                                <input type="tel" name="phone" id="phone" class="form-control" placeholder="+3809700000">
                                <label for="phone">Phone number</label>
                                <div class="invalid-feedback">
                                    Please enter your phone number.
                                </div>
                                <p class="text-muted">We won't share your phone number with anyone.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-floating mb-3 has-validation">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                <label for="password">Password</label>
                                <div class="invalid-feedback">
                                    Please enter password.
                                </div>
                            </div>
                            <div class="form-floating mb-3 has-validation">
                                <input type="password" name="password2" id="password2" class="form-control" placeholder="Password">
                                <label for="password2">Confirm password</label>
                                <div class="invalid-feedback">
                                    Passwords do not match.
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <p class="text-muted mb-3">Already have an account? <a href="login.php">Log in!</a></p>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Sign up" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
