<?php
    require_once '../config/DB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../scripts/authorize_only_admin.php';
    $db = DB::getInstance();
    $user = isset($_GET['id']) ? $db->getUserById($_GET['id']) : null;
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password_hash = $_POST['password_hash'];
        $role = $_POST['role'];
        $phone = $_POST['phone'];
        $user = new User($id, $name, $email, $phone, $password_hash, $role);
        isset($_GET['id']) ? $db->updateUser($user) : $db->addUser($email, $password_hash, $name, $phone, $role);
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
        <title><?php echo isset($_GET['id']) ? 'Edit ' : 'Create new '?> user profile</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php' ?>
        <div class="container mt-4">
            <h1 class="text-center"><?php echo isset($_GET['id']) ? 'Edit ' : 'Create new '?> user profile</h1>
            <form method="post">
                <div class="form-group mb-2">
                    <div class="form-floating mb-3">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="name" 
                            name="name" 
                            placeholder="Name"
                            value="<?php echo isset($_GET['id']) ? $user->getName() : '' ?>"
                        >
                        <label for="name" class="form-label">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="tel"
                            class="form-control"
                            id="phone"
                            name="phone"
                            placeholder="Phone"
                            value="<?php echo isset($_GET['id']) ? $user->getPhone() : '' ?>"
                        >
                        <label for="phone" class="form-label">Phone</label>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <div class="form-floating mb-3">
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email" 
                            placeholder="Email"
                            value="<?php echo isset($_GET['id']) ? $user->getEmail() : '' ?>"
                        >
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="role" name="role" placeholder="Role">
                            <option value="1" <?php echo isset($_GET['id']) && $user->getRole() == 1 ? 'selected' : '' ?>>Admin</option>
                            <option value="0" <?php echo (isset($_GET['id']) && $user->getRole() == 0) || !isset($_GET['id']) ? 'selected' : '' ?>>Customer</option>
                        </select>
                        <label for="role" class="form-label">Role</label>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0 ?>">
                <input type="hidden" name="password_hash" value="<?php echo $user != null ? $user->getPasswordHash() : '' ?>">
                <div class="mb-3 d-flex gap-3">
                    <button type="submit" name="submit" class="btn btn-primary"><?php echo isset($_GET['id']) ? 'Edit' : 'Create' ?></button>
                    <a href="admin-panel.php" class="btn btn-outline-primary">Cancel</a>
                </div>
            </form>
        </div>
    </body>
</html>