<?php

$path = $_SERVER['REQUEST_URI'];
$query_index = strpos($path, '?');
if ($query_index !== false) {
    $path = substr($path, 0, $query_index);
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ShopyShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php if ($path == "/" || $path == "/index.php") echo "active" ?>" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($path == "/cart.php") echo "active" ?>" href="#">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($path == "/contacts.php") echo "active" ?>" href="#">Contacts</a>
                </li>
                <?php if (isset($_SESSION['user']) || $_SESSION['user'] !== null): ?>
                    <li class="nav-item dropdown mx-3">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hello, <?php echo $_SESSION['user']->getName() ?>
                        </a>
                        <div class="dropdown-menu" data-bs-popper="static">
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item" href="#">Orders</a>
                            <a class="dropdown-item" href="#">Settings</a>
                            <?php if ($_SESSION['user']->getRole() == 1): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="pages/admin-panel.php">Admin panel</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="includes/logout.php">Logout</a>
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
            <?php if ($path == "/" || $path == "/index.php"): ?>
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="search" placeholder="Enter product's name">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>