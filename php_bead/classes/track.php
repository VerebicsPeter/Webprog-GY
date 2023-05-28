<?php
require_once "jsonstorage.php";

class Track
{
    public $_id = null;
    public $title;
    public $artist;
    public $length;
    public $year;
    public $genres;

    public function __construct($title = null, $artist = null, $length = null, $year = null, $genres = null)
    {
        $this->title = $title;
        $this->artist = $artist;
        $this->length = $length;
        $this->year = $year;
        $this->genres = $genres;
    }

    public static function from_array(array $arr): Track
    {
        $instance = new Track();
        $instance->_id = $arr['_id'] ?? null;
        $instance->title = $arr['title'] ?? null;
        $instance->artist = $arr['artist'] ?? null;
        $instance->length = $arr['length'] ?? null;
        $instance->year = $arr['year'] ?? null;
        $instance->genres = $arr['genres'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): Track
    {
        return self::from_array((array) $obj);
    }
}

class TrackRepository
{
    private $storage;
    public function __construct()
    {
        $this->storage = new JsonStorage('data/tracks.json');
    }
    private function convert(array $arr): array
    {
        return array_map([Track::class, 'from_object'], $arr);
    }
    public function all()
    {
        return $this->convert($this->storage->all());
    }
    public function add(Track $track): string
    {
        return $this->storage->insert($track);
    }
    public function get_track_by_id(string $id = null) : Track
    {
        foreach ($this->all() as $track) {
            if ($track->_id === $id) return $track;
        }
        return null;
    }
}

?>
