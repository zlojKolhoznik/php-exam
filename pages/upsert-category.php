<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../includes/authorize_only_admin.php';
    $db = DB::getInstance();
    $category = isset($_GET['id']) ? $db->getCategory($_GET['id']) : null;
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        if (isset($_GET['id'])) {
            $db->updateCategory($_GET['id'], $name);
        } else {
            $db->addCategory($name);
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
        <title><?php echo isset($_GET['id']) ? 'Edit ' : 'Create new ' ?> category</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php' ?>
        <div class="container mt-4">
            <h1 class="text-center"><?php echo isset($_GET['id']) ? 'Edit ' : 'Create new ' ?> category</h1>
            <form action="" method="POST">
                <div class="form-floating mb-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="name" 
                        name="name" 
                        placeholder="Name"
                        value="<?php echo isset($_GET['id']) ? $category->getName() : '' ?>"
                    >
                    <label for="name" class="form-label">Name</label>
                </div>
                <div class="mb-3 d-flex gap-3">
                    <button type="submit" name="submit" class="btn btn-primary"><?php echo isset($_GET['id']) ? 'Edit' : 'Create' ?></button>
                    <a href="admin-panel.php" class="btn btn-outline-primary">Cancel</a>
                </div>
            </form>
    </body>
</html>