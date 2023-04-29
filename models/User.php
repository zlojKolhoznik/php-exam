<?php

class User
{
    private $id;
    private $name;
    private $email;
    private $phone;
    private $password_hash;
    private $role;

    public function __construct($id, $name, $email, $phone, $password_hash, $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password_hash = $password_hash;
        $this->role = $role;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function getName() 
    {
        return $this->name;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function getPhone() 
    {
        return $this->phone;
    }

    public function getPasswordHash() 
    {
        return $this->password_hash;
    }

    public function getRole() 
    {
        return $this->role;
    }

    public function setName($name) 
    {
        $this->name = $name;
    }

    public function setEmail($email) 
    {
        $this->email = $email;
    }

    public function setPhone($phone) 
    {
        $this->phone = $phone;
    }

    public function setPasswordHash($password_hash) 
    {
        $this->password_hash = $password_hash;
    }

    public function setRole($role) 
    {
        $this->role = $role;
    }

    public function isAdmin()
    {
        return $this->role == 1;
    }

    public static function ParseFromArray($arr)
    {
        return new User($arr['id'], $arr['name'], $arr['email'], $arr['phone'], $arr['password_hash'], $arr['role']);
    }
}