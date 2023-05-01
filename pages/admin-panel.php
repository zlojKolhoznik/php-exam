<?php
    require_once "../config/DB.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once "../scripts/authorize_only_admin.php";
    $db = DB::getInstance();
    $categories = $db->getCategories();
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
        <!-- TODO: create collapses for each table -->
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
                        <table class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Id</th>
                                    <th style="width: 60%;">Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($categories as $category): ?>
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
                        <table class="table table-sm table-striped table-bordered">
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