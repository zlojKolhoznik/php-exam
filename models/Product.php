<?php

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $image_url;
    private $category_id;

    public function __construct($id, $name, $price, $description, $image_url, $category_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->category_id = $category_id;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function getName() 
    {
        return $this->name;
    }

    public function getPrice() 
    {
        return $this->price;
    }

    public function getDescription() 
    {
        return $this->description;
    }

    public function getImageUrl() 
    {
        return $this->image_url;
    }

    public function getCategoryId() 
    {
        return $this->category_id;
    }

    public function setName($name) 
    {
        $this->name = $name;
    }

    public function setPrice($price) 
    {
        $this->price = $price;
    }

    public function setDescription($description) 
    {
        $this->description = $description;
    }

    public function setImageUrl($image_url) 
    {
        $this->image_url = $image_url;
    }

    public function setCategoryId($category_id) 
    {
        $this->category_id = $category_id;
    }

    public static function ParseFromArray($arr)
    {
        return new Product($arr['id'], $arr['name'], $arr['price'], $arr['description'], $arr['image_url'], $arr['category_id']);
    }
}