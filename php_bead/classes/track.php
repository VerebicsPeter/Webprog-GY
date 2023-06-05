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

    public function get_genre_string() : string
    {
        return implode(", ", $this->genres);
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
    public function edit(string $id, Track $edited) {
        $this->storage->update(
            function ($track) use ($id) {return $track->_id === $id;},
            function ($track) use ($edited) {
                $track->year = $edited->year;
                $track->title = $edited->title;
                $track->artist = $edited->artist;
                $track->genres = $edited->genres;
                $track->length = $edited->length;
            }
        );
    }
    public function get_track_by_id(string $id = null) : Track
    {
        if (isset($this->all()[$id])) return $this->all()[$id];
        return null;
    }
    public function get_tracks_by_title(string $title = null) : array
    {
        return $this->convert($this->storage->filter(function ($track) use ($title) {
            return str_contains($track->title, $title);
        }));
    }
    public function get_tracks_by_artist(string $artist = null) : array
    {
        return $this->convert($this->storage->filter(function ($track) use ($artist) {
            return str_contains($track->artist, $artist);
        }));
    }
    public function get_tracks_by_genres(string $genres = null) : array
    {
        return $this->convert($this->storage->filter(function ($track) use ($genres) {
            $genres_string = implode(", ", $track->genres);
            return str_contains($genres_string, $genres);
        }));
    }
}

?>
