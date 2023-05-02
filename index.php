<?php
    require_once "models/User.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once "config/DB.php";
    $db = DB::getInstance();
    $products = $db->getProducts();
?>
<head>
    <?php include_once "includes/links.php" ?>
    <title>Home - ShopyShop</title>
</head>
<body>
    <?php include_once "includes/navbar.php" ?>
    <div class="container">
        <div class="d-flex flex-wrap gap-3 p-2">
            <?php foreach($products as $product): ?>
                <div class="card justify-content-between" style="max-width: 15em;">
                    <img src="upload/<?php echo $product->getImageUrl() ?>" alt="<?php echo $product->getName() ?>" class="card-img-top">
                    <h5 class="card-title m-2">
                        <?php echo $product->getName() ?>
                    </h5>
                    <p class="card-text m-2">
                        <?php echo strlen($product->getDescription()) < 40 ? $product->getDescription() : substr($product->getDescription(), 0, 40).'...' ?>
                    </p>
                    <p class="card-text text-warning m-2">
                        <?php echo $product->getPrice() ?>₴
                    </p>
                    <div class="card-footer p-2" style="height: 4em;">
                        <a href="pages/product.php?id=<?php echo $product->getId() ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>