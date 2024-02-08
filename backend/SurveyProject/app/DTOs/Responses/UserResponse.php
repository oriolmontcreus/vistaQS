<?php
namespace App\DTOs\Responses;

class UserResponse
{
    public $id;
    public $name;
    public $email;
    public $created_at;
    public $city;

    public function __construct($id, $name, $email, $created_at, $city)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->city = $city;
    }
}