<?php

require_once '../models\Category.php';
require_once '../models\Product.php';
require_once '../models\User.php';
require_once '../models\Cart.php';
require_once '../models\Order.php';

class DB
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $this->connection = new PDO('mysql:host=localhost;dbname=shop;', 'root', '');
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    // CRUD - Read

    public function getCategoryById($id)
    {
        $statement = $this->connection->prepare('SELECT * FROM categories WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $category = $statement->fetch(PDO::FETCH_ASSOC);

        return Category::ParseFromArray($category);
    }

    public function getCategories()
    {
        $statement = $this->connection->prepare('SELECT * FROM categories');
        $statement->execute();
        $categories_from_db = $statement->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach($categories_from_db as $category_from_db) {
            $categories[] = Category::ParseFromArray($category_from_db);
        }

        return $categories;
    }

    public function getProductById($id)
    {
        $statement = $this->connection->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        return Product::ParseFromArray($product);
    }

    public function getProductsByCategoryId($category_id)
    {
        $statement = $this->connection->prepare('SELECT * FROM products WHERE category_id = :category_id');
        $statement->bindParam(':category_id', $category_id);
        $statement->execute();
        $products_from_db = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach($products_from_db as $product_from_db) {
            $products[] = Product::ParseFromArray($product_from_db);
        }

        return $products;
    }

    public function getProducts()
    {
        $statement = $this->connection->prepare('SELECT * FROM products');
        $statement->execute();
        $products_from_db = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach($products_from_db as $product_from_db) {
            $products[] = Product::ParseFromArray($product_from_db);
        }

        return $products;
    }

    public function getUserByEmail($email) 
    {
        $statement = $this->connection->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindParam(':email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user === false) {
            return null;
        }

        return User::ParseFromArray($user);
    }

    public function getUserById($id)
    {
        $statement = $this->connection->prepare('SELECT * FROM users WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return User::ParseFromArray($user);
    }

    public function getUsers()
    {
        $statement = $this->connection->prepare('SELECT * FROM users');
        $statement->execute();
        $users_from_db = $statement->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach($users_from_db as $user_from_db) {
            $users[] = User::ParseFromArray($user_from_db);
        }

        return $users;
    }

    public function getCart($id)
    {
        $statement = $this->connection->prepare('SELECT * FROM carts WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $cart_from_db = $statement->fetch(PDO::FETCH_ASSOC);

        $products_info = $this->getProductsByCartId($cart_from_db['id']);

        return Cart::ParseFromArrays($cart_from_db, $products_info);
    }

    public function getCartsByUserId($user_id)
    {
        $statement = $this->connection->prepare('SELECT * FROM carts WHERE user_id = :user_id');
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();
        $carts_from_db = $statement->fetchAll(PDO::FETCH_ASSOC);
        $carts = [];

        foreach($carts_from_db as $cart_from_db) {
            
            $products_info = $this->getProductsByCartId($cart_from_db['id']);
            $carts[] = Cart::ParseFromArrays($cart_from_db, $products_info);
        }

        return $carts;
    }

    public function getOrder($id)
    {
        $statement = $this->connection->prepare('SELECT * FROM orders WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $order = $statement->fetch(PDO::FETCH_ASSOC);

        return Order::ParseFromArray($order);
    }

    public function getOrdersByUserId($user_id)
    {
        $statement = $this->connection->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();
        $orders_from_db = $statement->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];
        foreach($orders_from_db as $order_from_db) {
            $orders[] = Order::ParseFromArray($order_from_db);
        }

        return $orders;
    }

    // CRUD - Create

    public function addCategory($name)
    {
        $statement = $this->connection->prepare('INSERT INTO categories (name) VALUES (:name)');
        $statement->bindParam(':name', $name);
        $statement->execute();
    }

    public function addProduct($name, $price, $description, $image_url, $category_id)
    {
        $statement = $this->connection->prepare('INSERT INTO products (name, price, description, image_url, category_id) VALUES (:name, :price, :description, :image_url, :category_id)');
        $statement->bindParam(':name', $name);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':image_url', $image_url);
        $statement->bindParam(':category_id', $category_id);
        $statement->execute();
    }

    public function addUser($email, $password_hash, $name, $phone, $role)
    {
        $statement = $this->connection->prepare('INSERT INTO users (email, password_hash, name, phone, role) VALUES (:email, :password, :name, :phone, :role)');
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password_hash);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':role', $role);
        $statement->execute();
    }

    public function addCart($user_id)
    {
        $statement = $this->connection->prepare('INSERT INTO carts (user_id, status) VALUES (:user_id, "active")');
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();
    }

    public function addProductToCart($cart_id, $product_id, $quantity)
    {
        $statement = $this->connection->prepare('INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)');
        $statement->bindParam(':cart_id', $cart_id);
        $statement->bindParam(':product_id', $product_id);
        $statement->bindParam(':quantity', $quantity);
        $statement->execute();
    }

    public function addOrder($cart_id) {
        $statement = $this->connection->prepare('INSERT INTO orders (cart_id, status) VALUES (:cart_id, "pending")');
        $statement->bindParam(':cart_id', $cart_id);
        $statement->execute();
    }

    // CRUD - Update

    public function updateCategory($id, $new_name) {
        $statement = $this->connection->prepare('UPDATE categories SET name = :new_name WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->bindParam(':new_name', $new_name);
        $statement->execute();
    }

    public function updateCartStatus($cart_id, $status) {
        $statement = $this->connection->prepare('UPDATE carts SET status = :status WHERE id = :cart_id');
        $statement->bindParam(':cart_id', $cart_id);
        $statement->bindParam(':status', $status);
        $statement->execute();
    }

    public function updateOrderStatus($order_id, $status) {
        $statement = $this->connection->prepare('UPDATE orders SET status = :status WHERE id = :order_id');
        $statement->bindParam(':order_id', $order_id);
        $statement->bindParam(':status', $status);
        $statement->execute();
    }

    public function updateProductQuantity($cart_id, $product_id, $quantity) {
        $statement = $this->connection->prepare('UPDATE cart_products SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id');
        $statement->bindParam(':cart_id', $cart_id);
        $statement->bindParam(':product_id', $product_id);
        $statement->bindParam(':quantity', $quantity);
        $statement->execute();
    }

    public function updateUser($user) {
        $statement = $this->connection->prepare('UPDATE users SET email = :email, password_hash = :password_hash, name = :name, phone = :phone, role = :role WHERE id = :id');
        $id = $user->getId();
        $email = $user->getEmail();
        $password_hash = $user->getPasswordHash();
        $name = $user->getName();
        $phone = $user->getPhone();
        $role = $user->getRole();
        $statement->bindParam(':id', $id);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password_hash', $password_hash);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':role', $role);
        $statement->execute();
    }

    public function updateProduct($product) {
        $statement = $this->connection->prepare('UPDATE products SET name = :name, price = :price, description = :description, image_url = :image_url, category_id = :category_id WHERE id = :id');
        $id = $product->getId();
        $name = $product->getName();
        $price = $product->getPrice();
        $description = $product->getDescription();
        $image_url = $product->getImageUrl();
        $category_id = $product->getCategoryId();
        $statement->bindParam(':id', $id);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':image_url', $image_url);
        $statement->bindParam(':category_id', $category_id);
        $statement->execute();
    }

    // CRUD - Delete

    public function deleteCategory($category_id) {
        $statement = $this->connection->prepare('SELECT COUNT(*) FROM products WHERE category_id = :category_id');
        $statement->bindParam(':category_id', $category_id);
        $statement->execute();
        $count = $statement->fetchColumn();
        if ($count > 0) {
            throw new Exception('Cannot delete category with products');
        }

        $statement = $this->connection->prepare('DELETE FROM categories WHERE id = :category_id');
        $statement->bindParam(':category_id', $category_id);
        $statement->execute();
    }

    public function deleteProduct($product_id) {
        $statement = $this->connection->prepare('DELETE FROM products WHERE id = :product_id');
        $statement->bindParam(':product_id', $product_id);
        $statement->execute();
    }

    public function deleteUser($user_id) {
        $statement = $this->connection->prepare('SELECT COUNT(*) FROM carts LEFT JOIN orders ON orders.cart_id = carts.id WHERE user_id = :user_id AND (carts.status = "active" OR orders.status = "pending")');
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();
        $carts_count = $statement->fetchColumn();
        if ($carts_count > 0) {
            throw new Exception('Cannot delete user with active carts or pending orders');
        }

        $statement = $this->connection->prepare('DELETE FROM users WHERE id = :user_id');
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();
    }

    public function deleteCart($cart_id) {
        $statement = $this->connection->prepare('SELECT COUNT(*) FROM orders WHERE cart_id = :cart_id AND status = "pending"');
        $statement->bindParam(':cart_id', $cart_id);
        $statement->execute();
        $orders_count = $statement->fetchColumn();
        if ($orders_count > 0) {
            throw new Exception('Cannot delete cart with pending orders');
        }

        $statement = $this->connection->prepare('DELETE FROM carts WHERE id = :cart_id');
        $statement->bindParam(':cart_id', $cart_id);
        $statement->execute();
    }

    public function deleteOrder($order_id) {
        $statement = $this->connection->prepare('DELETE FROM orders WHERE id = :order_id');
        $statement->bindParam(':order_id', $order_id);
        $statement->execute();
    }

    private function deleteCartProducts($cart_id) {
        $statement = $this->connection->prepare('DELETE FROM cart_products WHERE cart_id = :cart_id');
        $statement->bindParam(':cart_id', $cart_id);
        $statement->execute();
    }

    private function deleteProductByCategory($category_id) {
        $statement = $this->connection->prepare('DELETE FROM products WHERE category_id = :category_id');
        $statement->bindParam(':category_id', $category_id);
        $statement->execute();
    }

    private function getProductsByCartId($cart_id) {
        $statement = $this->connection->prepare('SELECT * FROM cart_products WHERE cart_id = :cart_id');
        $statement->bindParam(':cart_id', $cart_id);
        $statement->execute();
        $cart_products_from_db = $statement->fetchAll(PDO::FETCH_ASSOC);

        $products_info = [];
        foreach ($cart_products_from_db as $cart_product_from_db) {
            $products_info[] = [
                'id' => $cart_product_from_db['product_id'],
                'quantity' => $cart_product_from_db['quantity']
            ];
        }
        return $products_info;
    }
}


// Database Schema:
// NAME: shop
// TABLE `categories`: 'id' - int not null auto_increment primary key, 'name' - varchar(255) not null unique
// TABLE `products`: 'id' - int not null auto_increment primary key, 'name' - varchar(255) not null, 'price' - decimal not null, 'description' - text, 'image_url' - varchar(255) not null, 'category_id' - int not null foreign key references categories(id)
// TABLE `users`: 'id' - int not null auto_increment primary key, 'name' - varchar(255) not null, 'email' - varchar(255) not null unique, 'phone' - varchar(20) not null unique, 'password_hash' - varchar(255) not null, 'role' - int not null
// TABLE `carts`: 'id' - int not null auto_increment primary key, 'user_id' - int not null foreign key references users(id), `status` - varchar(255) not null
// TABLE `carts_products`: 'id' - int not null auto_increment primary key, 'cart_id' - int not null foreign key references carts(id), 'product_id' - int not null foreign key references products(id), 'quantity' - int not null
// TABLE `orders`: 'id' - int not null auto_increment primary key, 'cart_id' - int not null foreign key references carts(id), 'status' - varchar(255) not null