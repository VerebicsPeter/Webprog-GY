<?php
require_once "jsonstorage.php";

class Order
{
    public $_id = null;
    public $name;
    public $address;
    public $products;

    public function __construct($name = null, $address = null, $products = null)
    {
        $this->name = $name;
        $this->address = $address;
        $this->products = $products;
    }

    public static function from_array(array $arr): Order
    {
        $instance = new Order();
        $instance->_id = $arr['_id'] ?? null;
        $instance->name = $arr['name'] ?? null;
        $instance->address = $arr['address'] ?? null;
        $instance->products = $arr['products'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): Order
    {
        return self::from_array((array) $obj);
    }
}

class OrderRepository
{
    private $storage;
    public function __construct()
    {
        $this->storage = new JsonStorage('data/orders.json');
    }
    private function convert(array $arr): array
    {
        return array_map([Order::class, 'from_object'], $arr);
    }
    public function all()
    {
        return $this->convert($this->storage->all());
    }
    public function add(Order $order): string
    {
        return $this->storage->insert($order);
    }
}