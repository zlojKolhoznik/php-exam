<?php

class Order
{
    private $id;
    private $cart_id;
    private $status;

    public function __construct($id, $cart_id, $status)
    {
        $this->id = $id;
        $this->cart_id = $cart_id;
        $this->status = $status;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function getCartId() 
    {
        return $this->cart_id;
    }

    public function getStatus() 
    {
        return $this->status;
    }

    public function setCartId($cart_id) 
    {
        $this->cart_id = $cart_id;
    }

    public function setStatus($status) 
    {
        $this->status = $status;
    }

    public static function ParseFromArray($order_array)
    {
        return new Order($order_array['id'], $order_array['cart_id'], $order_array['status']);
    }
}