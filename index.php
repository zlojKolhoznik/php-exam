<?php
    require_once "models/User.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once "config/DB.php";
    $db = DB::getInstance();
    $products = $db->getProducts();
    $temp = [];
    $doSearch = isset($_GET['q']) && !empty($_GET['q']);
    $doFilter = isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] != "all";
    if ($doSearch) {
        foreach($products as $product) {
            if (strpos(strtolower($product->getName()), strtolower($_GET['q'])) !== false) {
                array_push($temp, $product);
            }
        }
    }
    $products = $doSearch ? $temp : $products;
    $temp = [];
    if ($doFilter) {
        foreach($products as $product) {
            if ($product->getCategoryId() == $_GET['category']) {
                array_push($temp, $product);
            }
        }
    }
    $products = $doFilter ? $temp : $products;
?>
<head>
    <?php include_once "includes/links.php" ?>
    <title>Home - ShopyShop</title>
</head>
<body>
    <?php include_once "includes/navbar.php" ?>
    <h1 class="text-center text-primary my-3">Products</h1>
    <hr>
    <div class="position-fixed fixed-left ms-4 p-2" style="background-color: #E5E5E5;">
        <form method="get">
            <label for="category" class="form-label">
                <p class="text-center text-primary my-2">Filter by category</p>
            </label>
            <select name="category" id="category" class="form-select">
                <option value="all">All</option>
                <?php foreach($db->getCategories() as $category): ?>
                    <option value="<?php echo $category->getId() ?>"><?php echo $category->getName() ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($_GET['q'])): ?>
                <input type="hidden" name="q" value="<?php echo $_GET['q'] ?>">
            <?php endif; ?> 
            <button type="submit" class="btn btn-primary my-2">Filter</button>
        </form>
    </div>
    <div class="container">
        <?php if (count($products) == 0): ?>
            <h3 class="text-center text-secondary my-5">No products found</h3>
        <?php endif; ?>
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