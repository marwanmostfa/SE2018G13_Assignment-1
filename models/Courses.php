<?php

include_once('database.php');

class Courses extends Database {

    function __construct($id) {
        $sql = "SELECT * FROM courses WHERE id = $id;";
        $statement = Database::$db->prepare($sql);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($data)) {
            return;
        }
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function add($name, $study_year, $max_degree) {
        $sql = "INSERT INTO courses (name,study_year,max_degree) VALUES (?,?,?)";
        Database::$db->prepare($sql)->execute([$name, $study_year, $max_degree]);
    }

    public function delete() {
        $sql = "DELETE FROM courses WHERE id = $this->id;";
        Database::$db->query($sql);
    }

    public static function all($keyword, $cloumn, $order) {
        if ($cloumn == null) {
            $cloumn = "id";
        }
        if ($order == null) {
            $order = "ASC";
        }
        $keyword = str_replace(" ", "%", $keyword);
        $sql = "SELECT * FROM courses WHERE name like ('%$keyword%') ORDER BY $cloumn $order;";
        $statement = Database::$db->prepare($sql);
        $statement->execute();
        $courses = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Courses($row['id']);
        }
        return $courses;
    }

    public function save() {
        $sql = "UPDATE courses SET name = ?,study_year = ?,max_degree=? WHERE id = ?;";
        Database::$db->prepare($sql)->execute([$this->name, $this->study_year, $this->max_degree, $this->id]);
    }

}

?>
