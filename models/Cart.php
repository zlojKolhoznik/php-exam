<?php

class Cart
{
    private $id;
    private $user_id;
    private $status;
    private $products_info; // [["id" => id, "quantity" => quantity], ["id" =>  id, "quantity" => quantity], ...]

    public function __construct($id, $user_id, $status, $products_info)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->status = $status;
        $this->products_info = $products_info;
    }

    public static function ParseFromArrays($cart_array, $products_array)
    {
        $products_info = [];
        foreach ($products_array as $product_info) {
            $products_info[] = ["id" => $product_info['id'], "quantity" => $product_info['quantity']];
        }
        return new Cart($cart_array['id'], $cart_array['user_id'], $cart_array['status'], $products_info);
    }

    public function getId() 
    {
        return $this->id;
    }

    public function getUserId() 
    {
        return $this->user_id;
    }

    public function getStatus() 
    {
        return $this->status;
    }

    public function getProductsInfo() 
    {
        return $this->products_info;
    }

    public function setUserId($user_id) 
    {
        $this->user_id = $user_id;
    }

    public function setStatus($status) 
    {
        $this->status = $status;
    }

    public function setProductsIds($products_info) 
    {
        $this->products_info = $products_info;
    }

    public function addProduct($product_id, $quantity)
    {
        $this->products_info[] = ["id" => $product_id, "quantity" => $quantity];
    }

    public function removeProduct($product_id)
    {
        foreach ($this->products_info as $key => $product_info) {
            if ($product_info['id'] == $product_id) {
                unset($this->products_info[$key]);
                break;
            }
        }
    }
}