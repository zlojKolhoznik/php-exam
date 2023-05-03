<?
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $db = DB::getInstance();
    $product = $db->getProductById($_GET['id']);
    $cart = null;
    if (isset($_SESSION['user'])) {
        $cart = $db->getActiveUserCart($_SESSION['user']->getId());
    }
    $already_in_cart = false;
    if ($cart != null) {
        foreach($cart->getProductsInfo() as $product_info) {
            if ($product_info['id'] == $product->getId()) {
                $already_in_cart = true;
                break;
            }
        }
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
        <title>Document</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php' ?>
        <h1 class="text-center text-primary mt-3">
            <?php echo $product->getName() ?>
        </h1>
        <hr>
        <div class="container mt-2">
            <div class="row">
                <div class="col-6 p-3">
                    <img src="../upload/<?php echo $product->getImageUrl() ?>" alt="" style="max-width: 100%; max-height: 40rem;">
                </div>
                <div class="col-6 p-5">
                    <h3 class="text-primary">
                        <?php echo $product->getName() ?>
                    </h3>
                    <p class="text-muted" style="font-size: 1rem;">
                        <?php echo $db->getCategoryById($product->getCategoryId())->getName() ?>
                    </p>
                    <p class="text-primary">
                        <?php echo $product->getDescription() ?>
                    </p>
                    <p class="text-warning" style="font-size: 3rem;">
                        <?php echo $product->getPrice() ?>₴
                    </p>
                    <form action="../scripts/add-to-cart.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $product->getId() ?>">
                        <input type="number" name="quantity" value="1" min="1" max="100" class="form-control w-25 d-inline">
                        <?php if ($already_in_cart): ?>
                            <button type="button" class="btn btn-success" disabled>Already in cart</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success">Add to cart</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>