<?php

include_once('database.php');

class Grade extends Database {

    function __construct($id) {
        $sql = "SELECT G.*,C.name,C.max_degree FROM grades as G join courses as C on (G.course_id = C.id) WHERE G.student_id = ('$id');";
        //$sql = "SELECT * FROM grades WHERE id = $id;";
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

    public static function all($id) {
        //$sql = "SELECT G.*,C.name,C.max_degree FROM grades as G join courses as C on (G.course_id = C.id) WHERE G.student_id = ('$id');";
        $sql = "SELECT * FROM grades WHERE student_id = ('$id');";
        $statement = Database::$db->prepare($sql);
        $statement->execute();
        $grades = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $grades[] = new Grade($row['id']);
        }
        return $grades;
    }

}

?>