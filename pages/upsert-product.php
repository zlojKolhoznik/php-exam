<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../scripts/authorize_only_admin.php';

    $db = DB::getInstance();
    $categories = $db->getCategories();
    $product = isset($_GET['id']) ? $db->getProductById($_GET['id']) : null;
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_FILES['image'];
        if (empty($category)) {
            header('Location: ?error=1');
            exit();
        }
        if (!empty($image['name'])) {
            if ($product != null && !empty($product->getImageUrl())) {
                unlink($product->getImageUrl());
            }
            $imageUrl = time().'.'.end(explode('.', $image['name']));
            $imagePath = '../upload/'.$imageUrl;
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        if (isset($_GET['id'])) {
            $product = new Product($_GET['id'], $name, $price, $description, $imageUrl, $category);
            $db->updateProduct($product);
        } else {
            $db->addProduct($name, $price, $description, $imageUrl, $category);
        }
        header('Location: admin-panel.php');
        exit();
    } else
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/custom-styles.css">
        <title><?php echo isset($_GET['id']) ? 'Edit ' : 'Create new ' ?> product</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php' ?>
        <div class="container mt-4">
            <h1 class="text-center"><?php echo isset($_GET['id']) ? 'Edit ' : 'Create new ' ?> product</h1>
            <form method="post" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Name"
                        required
                        value="<?php echo isset($_GET['id']) ? $product->getName() : '' ?>"
                    >
                    <label for="name" class="form-label">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea
                        class="form-control"
                        id="description"
                        name="description"
                        placeholder="Description"
                        required
                        style="height: 7.5rem"
                    ><?php echo isset($_GET['id']) ? $product->getDescription() : null ?></textarea>
                    <label for="description" class="form-label">Description</label>
                </div>
                <div class="form-floating mb-3">
                    <input
                        type="number"
                        step="0.01"
                        class="form-control"
                        id="price"
                        name="price"
                        placeholder="Price"
                        required
                        value="<?php echo isset($_GET['id']) ? $product->getPrice() : '' ?>"
                    >
                    <label for="price" class="form-label">Price</label>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product image</label>
                    <input
                        type="file"
                        class="form-control"
                        id="image"
                        name="image"
                        accept="image/*"
                        required
                    >
                </div>
                <div class="mb-3 has-validation">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select <?php if ($_GET['error'] == 1) echo 'is-invalid' ?>" id="category" name="category">
                        <option 
                            disabled
                            <?php echo !isset($_GET['id']) ? 'selected' : '' ?>
                        >
                        Select category
                    </option>
                        <?php foreach ($categories as $category): ?>
                            <option
                                value="<?php echo $category->getId() ?>"
                                <?php echo isset($_GET['id']) && $product->getCategoryId() == $category->getId() ? 'selected' : '' ?>
                            >
                                <?php echo $category->getName() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="invalid-feedback text-danger">Please select a category</p>
                </div>
                <div class="mb-3 d-flex gap-3">
                    <button type="submit" name="submit" class="btn btn-primary"><?php echo isset($_GET['id']) ? 'Edit' : 'Create' ?></button>
                    <a href="admin-panel.php" class="btn btn-outline-primary">Cancel</a>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>