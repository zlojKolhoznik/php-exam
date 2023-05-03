<?php
    require_once "../config/DB.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once "../scripts/authorize-only-admin.php";
    $db = DB::getInstance();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/custom-styles.css">
        <title>Admin panel - ShopyShop</title>
    </head>
    <body>
        <?php include_once "../includes/navbar.php" ?>
        <div class="container mt-4">
            <h1 class="text-center">Admin panel</h1>
            <div class="d-flex flex-column">
                <button id="categoriesToggle" 
                        class="btn btn-link border-bottom text-decoration-none text-start" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#categoryCollapse" 
                        aria-expanded="false" 
                        aria-controls="categoryCollapse">
                        Categories
                </button>
                <div class="collapse" id="categoryCollapse">
                    <div class="p-2">
                        <div class="mb-3">
                            <a href="upsert-category.php" class="btn btn-sm btn-success">Add new category</a>
                        </div>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Id</th>
                                    <th style="width: 60%;">Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($db->getCategories() as $category): ?>
                                    <tr>
                                        <td><?php echo $category->getId() ?></td>
                                        <td><?php echo $category->getName() ?></td>
                                        <td>
                                            <a href="upsert-category.php?id=<?php echo $category->getId() ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="../scripts/delete-category.php?id=<?php echo $category->getId() ?>" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button id="usersToggle" 
                        class="btn btn-link border-bottom text-decoration-none text-start" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#usersCollapse" 
                        aria-expanded="false" 
                        aria-controls="usersCollapse">
                        Users
                </button>
                <div class="collapse" id="usersCollapse">
                    <div class="p-2">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Id</th>
                                    <th style="width: 20%;">Name</th>
                                    <th style="width: 20%;">Phone</th>
                                    <th style="width: 20%;">Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($db->getUsers() as $user): ?>
                                    <tr>
                                        <td><?php echo $user->getId() ?></td>
                                        <td><?php echo $user->getName() ?></td>
                                        <td><?php echo $user->getPhone() ?></td>
                                        <td><?php echo $user->getRole() == 1 ? 'Admin' : 'Customer' ?></td>
                                        <td>
                                            <a href="upsert-user.php?id=<?php echo $user->getId() ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="../scripts/delete-user.php?id=<?php echo $user->getId() ?>" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button id="productsToggle" 
                        class="btn btn-link border-bottom text-decoration-none text-start" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#productsCollapse" 
                        aria-expanded="false" 
                        aria-controls="productsCollapse">
                        Products
                </button>
                <div class="collapse" id="productsCollapse">
                    <div class="p-2">
                    <div class="mb-3">
                            <a href="upsert-product.php" class="btn btn-sm btn-success">Add new product</a>
                        </div>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Id</th>
                                    <th style="width: 20%;">Name</th>
                                    <th style="width: 20%;">Price</th>
                                    <th style="width: 20%;">Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($db->getProducts() as $product): ?>
                                    <tr>
                                        <td><?php echo $product->getId() ?></td>
                                        <td><?php echo $product->getName() ?></td>
                                        <td><?php echo $product->getPrice() ?></td>
                                        <td><?php echo $db->getCategoryById($product->getCategoryId())->getName() ?></td>
                                        <td>
                                            <a href="upsert-product.php?id=<?php echo $product->getId() ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="../scripts/delete-product.php?id=<?php echo $product->getId() ?>" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button id="ordersToggle" 
                        class="btn btn-link border-bottom text-decoration-none text-start" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#ordersCollapse" 
                        aria-expanded="false" 
                        aria-controls="ordersCollapse">
                        Orders
                </button>
                <div class="collapse" id="ordersCollapse">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Id</th>
                                <th style="width: 20%;">Recipient name</th>
                                <th style="width: 20%;">Total</th>
                                <th style="width: 20%;">Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($db->getOrders() as $order): ?>
                                <tr>
                                    <td><?php echo $order->getId() ?></td>
                                    <td><?php echo $order->getRecipientFullname() ?></td>
                                    <td><?php echo $db->getOrderTotal($order) ?>₴</td>
                                    <td class="<?php echo $order->getStatus() == 'completed' ? 'text-success' : '' ?>"><?php echo $order->getStatus() ?></td>
                                    <td>
                                        <?php if ($order->getStatus() == 'pending'): ?>
                                            <a href="../scripts/new-order-status.php?id=<?php echo $order->getId() ?>" class="btn btn-sm btn-success">Accept</a>
                                            <a href="../scripts/delete-order.php?id=<?php echo $order->getId() ?>" class="btn btn-sm btn-danger">Cancel</a>
                                        <?php elseif ($order->getStatus() == 'accepted'): ?>
                                            <a href="../scripts/new-order-status.php?id=<?php echo $order->getId() ?>" class="btn btn-sm btn-success">Deliver</a>
                                            <a href="../scripts/delete-order.php?id=<?php echo $order->getId() ?>" class="btn btn-sm btn-danger">Cancel</a>
                                        <?php elseif ($order->getStatus() == 'delivering'): ?>
                                            <a href="../scripts/new-order-status.php?id=<?php echo $order->getId() ?>" class="btn btn-sm btn-success">Complete</a>
                                        <?php endif ?>
                                        <a href="cart.php?id=<?php echo $order->getCartId(); ?>" class="btn btn-sm btn-primary">View cart</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    <script>
        let buttons = document.querySelectorAll('button[data-bs-toggle="collapse"]');
        let activeButtonId = null;

        function hideShownCollapse(pressedId) {
            if (activeButtonId == pressedId) {
                activeButtonId = null;
                return;
            }
            if (activeButtonId != null) {
                let button = document.getElementById(activeButtonId);
                button.click();
            }
            activeButtonId = pressedId;
        }

        buttons.forEach(button => button.addEventListener('click', e => hideShownCollapse(e.target.id)));
    </script>
</html>