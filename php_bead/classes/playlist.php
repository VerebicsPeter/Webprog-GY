<?php
class Playlist
{
    public $_id = null;
    public $name;
    public $creator;
    public $tracks;

    public function __construct($name = null, $creator = null, $tracks = null)
    {
        $this->name = $name;
        $this->creator = $creator;
        $this->tracks = $tracks;
    }

    public static function from_array(array $arr): Playlist
    {
        $instance = new Playlist();
        $instance->_id = $arr['_id'] ?? null;
        $instance->name = $arr['name'] ?? null;
        $instance->creator = $arr['creator'] ?? null;
        $instance->tracks = $arr['tracks'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): Playlist
    {
        return self::from_array((array) $obj);
    }
}

class PlaylistRepository
{
    private $storage;
    public function __construct()
    {
        $this->storage = new JsonStorage('data/playlists.json');
    }
    private function convert(array $arr): array
    {
        return array_map([Playlist::class, 'from_object'], $arr);
    }
    public function all()
    {
        return $this->convert($this->storage->all());
    }
    public function add(Playlist $post): string
    {
        return $this->storage->insert($post);
    }
}
?>