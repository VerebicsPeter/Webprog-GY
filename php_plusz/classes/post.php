<?php
require_once "jsonstorage.php";

class Post {
    public $_id = null;
    public $title;
    public $post_text;
    public $post_date;
    public $username;

    public function __construct($title = null, $post_text = null, $post_date = null, $username = null)
    {
        $this->title = $title;
        $this->post_text = $post_text;
        $this->post_date = $post_date;
        $this->username = $username;
    }

    public static function from_array(array $arr): Post
    {
        $instance = new Post();
        $instance->_id = $arr['_id'] ?? null;
        $instance->title = $arr['title'] ?? null;
        $instance->post_text = $arr['post_text'] ?? null;
        $instance->post_date = $arr['post_date'] ?? null;
        $instance->username = $arr['username'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): Post
    {
        return self::from_array((array) $obj);
    }
}

class PostRepository {
    private $storage;
    public function __construct()
    {
        $this->storage = new JsonStorage('data/posts.json');
    }
    private function convert(array $arr): array
    {
        return array_map([Post::class, 'from_object'], $arr);
    }
    public function all()
    {
        return $this->convert($this->storage->all());
    }
    public function add(Post $post): string
    {
        return $this->storage->insert($post);
    }
}

?>