<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $db = DB::getInstance();
    $cart = null;
    if (isset($_GET['id'])) {
        $cart = $db->getCartById($_GET['id']);
    } else {
        $cart = $db->getActiveUserCart($_SESSION['user']->getId());
        if ($cart == null) {
            $db->addCart($_SESSION['user']->getId());
            $cart = $db->getActiveUserCart($_SESSION['user']->getId());
        }
    }
    $products_info = $cart->getProductsInfo();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/custom-styles.css">
        <title>Cart - ShopyShop</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php' ?>
        <h1 class="text-center text-primary my-3">Cart <?php if (isset($_GET['id'])) echo '#'.$cart->getId() ?></h1>
        <hr>
        <div class="container">
            <?php if (count($products_info) == 0): ?>
                <h3 class="text-center text-secondary my-5">Your cart is empty</h3>
            <?php else: ?>
                <?php foreach($products_info as $product_info):
                    $product = $db->getProductById($product_info['id']);
                    $quantity = $product_info['quantity'];?>
                    <div class="row my-3 border-top border-bottom border-3 p-3">
                        <div class="col-3">
                            <img src="../upload/<?php echo $product->getImageUrl() ?>" alt="<?php echo $product->getName() ?>" class="img-fluid">
                        </div>
                        <div class="col-9">
                            <h3><?php echo $product->getName() ?></h3>
                            <p>Price: <?php echo $product->getPrice() ?>₴</p>
                            <p>Quantity: <?php echo $quantity ?></p>
                            <p>Total: <?php echo $product->getPrice() * $quantity ?>₴</p>
                            <?php if (!isset($_GET['id'])): ?>
                            <form action="../scripts/remove-from-cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product->getId() ?>">
                                <button type="submit" class="btn btn-danger">Remove from cart</button>
                            </form>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach ?>
                <p class="text-waring" style="font-size: 4rem">
                    Total: <?php $total = 0; 
                    foreach($products_info as $product_info) {
                            $product = $db->getProductById($product_info['id']);
                            $quantity = $product_info['quantity']; 
                            $total += $product->getPrice() * $quantity;
                        } 
                    echo $total; ?>₴
                </p>
                <a class="btn btn-success mb-3" href="order-details.php?total=<?php echo $total ?>">Checkout <?php if (isset($_GET['id'])) echo 'again' ?></a>
            <?php endif ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>