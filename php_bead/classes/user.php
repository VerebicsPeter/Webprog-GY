<?php
require_once "jsonstorage.php";

class User
{
    public $_id = null;
    public $username;
    public $password;
    public $email;
    public $is_admin;

    public function __construct($username = null, $password = null, $email = null, $is_admin = null) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->is_admin = $is_admin;
    }

    public static function from_array(array $arr): User
    {
        $instance = new User();
        $instance->_id = $arr['_id'] ?? null;
        $instance->username = $arr['username'] ?? null;
        $instance->password = $arr['password'] ?? null;
        $instance->email = $arr['email'] ?? null;
        $instance->is_admin = $arr['is_admin'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): User
    {
        return self::from_array((array) $obj);
    }
}

class UserRepository extends JsonStorage
{
    public function __construct()
    {
        parent::__construct('./data/users.json');
    }
}