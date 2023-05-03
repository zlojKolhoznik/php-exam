<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/User.php';
$path = $_SERVER['REQUEST_URI'];
$query_index = strpos($path, '?');
if ($query_index !== false) {
    $path = substr($path, 0, $query_index);
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">ShopyShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php if ($path == "/" || $path == "/index.php") echo "active" ?>" href="/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($path == "/pages/cart.php") echo "active" ?>" href="/pages/cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($path == "/pages/contacts.php") echo "active" ?>" href="/pages/contacts.php">Contacts</a>
                </li>
                <?php if (isset($_SESSION['user']) || $_SESSION['user'] !== null): ?>
                    <li class="nav-item dropdown mx-3">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Hello, <?php echo $_SESSION['user']->getName() ?>
                        </a>
                        <div class="dropdown-menu" data-bs-popper="static">
                            <a class="dropdown-item" href="/pages/profile.php">Profile</a>
                            <a class="dropdown-item" href="/pages/orders.php">Orders</a>
                            <a class="dropdown-item" href="/pages/settings.php">Settings</a>
                            <?php if ($_SESSION['user']->getRole() == 1): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/pages/admin-panel.php">Admin panel</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/scripts/logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown mx-3">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Account
                        </a>
                        <div class="dropdown-menu" data-bs-popper="static">
                            <a href="pages/login.php" class="dropdown-item">Log in</a>
                            <a href="pages/signup.php" class="dropdown-item">Sign up</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <form class="d-flex" method="get" action="/index.php">
                <input class="form-control me-sm-2" type="search" name="q"  value="<?php echo $_GET['q'] ?>" placeholder="Enter product's name">
                <?php if (isset($_GET['category'])): ?>
                    <input type="hidden" name="category" value="<?php echo $_GET['category'] ?>">
                <?php endif; ?>
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>