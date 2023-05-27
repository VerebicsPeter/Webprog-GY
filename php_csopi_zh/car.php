<?php

include_once "jsonstorage.php";

class Car {
    public $plate = null;
    public $color;
    public $brand;
    public $year;

    public function __construct($plate = null, $color = null, $brand = null, $year = null)
    {
        $this->plate = $plate;
        $this->color = $color;
        $this->brand = $brand;
        $this->year = $year;
    }

    public static function from_array(array $arr): Car
    {
        $instance = new Car();
        $instance->plate = $arr['plate'] ?? null;
        $instance->color = $arr['color'] ?? null;
        $instance->brand = $arr['brand'] ?? null;
        $instance->year = $arr['year'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): Car
    {
        return self::from_array((array) $obj);
    }
}

class CarRepository {
    private $storage;
    public function __construct()
    {
        $this->storage = new JsonStorage('data/autok.json');
    }
    private function convert(array $arr): array
    {
        return array_map([Car::class, 'from_array'], $arr);
        // valamiért a from_object - el fatal errort kap
    }
    public function all()
    {
        return $this->convert($this->storage->all());
    }
    public function add(Car $order): string
    {
        return $this->storage->insert($order);
    }
    public function getCarsByBrand(string $brand = null): array
    {
        return $this->convert($this->storage->filter(
            function ($car) use ($brand) {return $car->brand === $brand;}
        ));
    }
}

?>