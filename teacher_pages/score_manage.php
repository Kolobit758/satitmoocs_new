<?php
include "../includes/db.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user_id = $_POST['user_id'];
    $submission_id = $_POST['submission_id'];
    $assign_id = $_POST['assign_id'];
    $course_id = $_POST['course_id'];
    $score = $_POST['score'];
    var_dump($user_id);
    var_dump($submission_id);
    var_dump($assign_id);
    var_dump($course_id);
    var_dump($score);


    $sql = "UPDATE submissions SET score = :score WHERE user_id = :user_id AND assign_id = :assign_id";
    $stmt = $con->prepare($sql);
    $stmt->execute([
        ":score" => $score,
        ":user_id" => $user_id,
        ":assign_id" => $assign_id
    ]);

   header("location: assign_view.php?id=$course_id&assign_id=$assign_id");
   exit();
}

?>