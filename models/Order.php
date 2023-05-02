<?php

class Order
{
    private $id;
    private $cart_id;
    private $status;
    private $delivery_address;
    private $recipient_fullname;

    public function __construct($id, $cart_id, $status, $delivery_address, $recipient_fullname)
    {
        $this->id = $id;
        $this->cart_id = $cart_id;
        $this->status = $status;
        $this->delivery_address = $delivery_address;
        $this->recipient_fullname = $recipient_fullname;
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

    public function getDeliveryAddress() 
    {
        return $this->delivery_address;
    }

    public function getRecipientFullname() 
    {
        return $this->recipient_fullname;
    }

    public function setCartId($cart_id) 
    {
        $this->cart_id = $cart_id;
    }

    public function setStatus($status) 
    {
        $this->status = $status;
    }

    public function setDeliveryAddress($delivery_address) 
    {
        $this->delivery_address = $delivery_address;
    }

    public function setRecipientFullname($recipient_fullname) 
    {
        $this->recipient_fullname = $recipient_fullname;
    }

    public static function ParseFromArray($order_array)
    {
        return new Order($order_array['id'], $order_array['cart_id'], $order_array['status'], $order_array['delivery_address'], $order_array['recipient_fullname']);
    }
}