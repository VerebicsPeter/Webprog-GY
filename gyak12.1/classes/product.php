<?php
require_once "jsonstorage.php";

class Product
{
    public $_id = null;
    public $name;
    public $category;
    public $price;

    public function __construct($name = null, $category = null, $price = null)
    {
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public static function from_array(array $arr): Product
    {
        $instance = new Product();
        $instance->_id = $arr['_id'] ?? null;
        $instance->name = $arr['name'] ?? null;
        $instance->category = $arr['category'] ?? null;
        $instance->price = $arr['price'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): Product
    {
        return self::from_array((array) $obj);
    }
}

class ProductRepository
{
    private $storage;
    public function __construct()
    {
        $this->storage = new JsonStorage('data/products.json');
    }
    private function convert(array $arr): array
    {
        return array_map([Product::class, 'from_object'], $arr);
    }
    public function all()
    {
        return $this->convert($this->storage->all());
    }
    public function add(Product $product): string
    {
        return $this->storage->insert($product);
    }
    public function getProductsByCategory(string $category = null): array
    {
        return $this->convert($this->storage->filter(function ($product) use ($category) {
            return $product->category === $category;
        }));
    }
}