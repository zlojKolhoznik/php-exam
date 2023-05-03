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
    $orders = $db->getOrdersByUserId($user->getId());
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' href='../css/bootstrap.css'>
        <link rel='stylesheet' href='../css/custom-styles.css'>
        <title>My orders - ShopyShop</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php'; ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mt-5">My orders</h1>
                    <table class="table table-striped mt-5">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Total price</th>
                                <th scope="col">Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <th scope="row"><?php echo $order->getId(); ?></th>
                                    <td><?php echo $db->getOrderTotal($order); ?></td>
                                    <td><?php echo $order->getStatus(); ?></td>
                                    <td>
                                        <?php if ($order->getStatus() == 'delivered'): ?>
                                            <a href="../scripts/new-order-status.php?id=<?php echo $order->getId(); ?>" class="btn btn-success">Confirm reception</a>
                                        <?php endif ?>
                                        <a href="cart.php?id=<?php echo $order->getCartId(); ?>" class="btn btn-primary">View cart</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>