<?php
require_once "jsonstorage.php";

class Project {
    public $_id = null;
    public $project_name;
    public $project_hours;
    public $employee_name;

    public function __construct($project_name = null, $project_hours = null, $employee_name = null)
    {
        $this->project_name = $project_name;
        $this->project_hours = $project_hours;
        $this->employee_name = $employee_name;
    }

    public static function from_array(array $arr): Project
    {
        $instance = new Project();
        $instance->_id = $arr['id'] ?? null;
        $instance->project_name = $arr['project_name'] ?? null;
        $instance->project_hours = $arr['project_hours'] ?? null;
        $instance->employee_name = $arr['employee_name'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): Project
    {
        return self::from_array((array) $obj);
    }
}

class ProjectRepository {
    private $storage;
    public function __construct()
    {
        $this->storage = new JsonStorage('data.json');
    }
    private function convert(array $arr): array
    {
        return array_map([Project::class, 'from_object'], $arr);
    }
    public function all()
    {
        return $this->convert($this->storage->all());
    }
    public function add(Project $proj): string
    {
        return $this->storage->insert($proj);
    }
    public function names()
    {
        $names = [];
        foreach ($this->all() as $proj) {
            if (!in_array($proj->employee_name, $names))
                array_push($names, $proj->employee_name);
        }
        return $names;
    }
    public function get_projects_by_name(string $name) : array
    {
        return $this->storage->filter(function ($proj) use ($name) {
            return $proj->employee_name === $name;
        });
    }
    public function is_available_project_name(string $project_name) : bool
    {
        $matches = $this->storage->filter(function ($proj) use ($project_name) {
            return $proj->project_name === $project_name;
        });
        return count($matches) === 0;
    }
    public function update_project(string $project_name, int $hours)
    {
        $this->storage->update(
            function ($proj) use ($project_name) {return $proj->project_name === $project_name;},
            function ($proj) use ($hours) {$proj->project_hours += $hours;}
        );
        $this->storage->delete(function ($proj){return $proj->project_hours <= 0;});
    }
}
?>