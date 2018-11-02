<?php

include_once('database.php');

class Grade extends Database {

    function __construct($id, $src) {
        if ($src == "std") {
            $sql = "SELECT G.*,C.name as crs_name,C.max_degree,S.name as std_name FROM grades as G join courses as C on (G.course_id = C.id) join students as S on (G.student_id = S.id) WHERE G.id = ('$id');";
            $statement = Database::$db->prepare($sql);
            $statement->execute();
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            if (empty($data)) {
                return;
            }
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        } else if ($src == "crs") {
            $sql = "SELECT G.*,S.name as std_name FROM grades as G join students as S on (G.student_id = S.id) WHERE G.id = ('$id');";
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
    }

    public function delete() {
        $sql = "DELETE FROM grades WHERE id = $this->id;";
        Database::$db->query($sql);
    }

    public function save() {
        $sql = "UPDATE grades SET degree = ?,examine_at = ? WHERE id = ?;";
        Database::$db->prepare($sql)->execute([$this->degree, $this->examine_at, $this->id]);
    }

    public static function std_all($id, $cloumn, $order) {
        if ($cloumn == null) {
            $cloumn = "course_id";
        }
        if ($order == null) {
            $order = "ASC";
        }
        $sql = "SELECT G.*,C.name as crs_name,C.max_degree FROM grades as G join courses as C on (G.course_id = C.id) WHERE G.student_id = ('$id') ORDER BY $cloumn $order;";
        $statement = Database::$db->prepare($sql);
        $statement->execute();
        $grades = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $grades[] = new Grade($row['id'], "std");
        }
        return $grades;
    }

    public static function crs_all($id, $cloumn, $order) {
        if ($cloumn == null) {
            $cloumn = "student_id";
        }
        if ($order == null) {
            $order = "ASC";
        }
        $sql = "SELECT G.*,S.name as std_name FROM grades as G join students as S on (G.student_id = S.id) WHERE G.course_id = ('$id') ORDER BY $cloumn $order;";
        $statement = Database::$db->prepare($sql);
        $statement->execute();
        $grades = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $grades[] = new Grade($row['id'], "crs");
        }
        return $grades;
    }

    public static function add($course_id, $student_id) {
        $sql = "INSERT INTO grades (course_id,student_id,degree,examine_at) VALUES (?,?,NULL,NULL)";
        Database::$db->prepare($sql)->execute([$course_id, $student_id]);
    }

}

?>