<?php
session_start();
include "../includes/db.php";
$user = $_SESSION['userdata'];
$useripass = $user['useripass'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $course_id = $_POST['id'] ?? "";
    $content_type = $_POST['content_type'] ?? "";
    $description = $_POST['description'] ?? "";
    $created_at = date("Y-m-d H:i:s") ?? "";
    $action = $_POST['action'] ?? "";
    $chapter_id = $_POST['chapter_id'] ?? "";


    if (!empty($_FILES['file']['name'])) {
        $uploadDir = "../Uploads/upload_file/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 07777, true);
        }
        $file_name = basename($_FILES['file']['name']);
        $file_path = time() . "_" . basename($_FILES['file']['name']);
        $targetFile = $uploadDir . $file_path;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            if ($action === "add_chapter") {

                // 1. insert เข้า course_content
                $sql1 = "INSERT INTO course_contents 
                (chapter_id, useripass, title, detail, is_visible, created_at, content_type_int) 
                VALUES (:chapter_id, :useripass, :title, :detail, :is_visible, :created_at, :content_type_int)";

                $stmt1 = $con->prepare($sql1);
                $stmt1->execute([
                    ':chapter_id' => $chapter_id,
                    ':useripass' => $useripass,
                    ':title' => $file_name,
                    ':detail' => $description,
                    ':is_visible' => 1,
                    ':created_at' => $created_at,
                    ':content_type_int' => $content_type
                ]);

                // ดึงค่า content_id ล่าสุด
                $content_id = $con->lastInsertId();

                // 2. insert เข้า employee_uploads
                $sql2 = "INSERT INTO employee_uploads 
                    (content_id, file_path,title) 
                    VALUES (:content_id, :file_path,:title)";

                $stmt2 = $con->prepare($sql2);
                $stmt2->execute([
                    ':content_id' => $content_id,
                    ':file_path' => $file_path,
                    ':title' => $file_name
                ]);
                header("location: course.php?id=$course_id");
            } else {
                $startdate = $_POST['start_date'];
                $enddate = $_POST['end_date'];
                $group_member = $_POST['group_member'];
                $assign_title = $_POST['assign_title'];

                $sql1 = "INSERT INTO course_contents 
                (chapter_id, useripass, title, detail, is_visible, created_at, content_type_int) 
                VALUES (:chapter_id, :useripass, :title, :detail, :is_visible, :created_at, :content_type_int)";

                $stmt1 = $con->prepare($sql1);
                $stmt1->execute([
                    ':chapter_id' => $chapter_id,
                    ':useripass' => $useripass,
                    ':title' => $assign_title,
                    ':detail' => $description,
                    ':is_visible' => 1,
                    ':created_at' => $created_at,
                    ':content_type_int' => $content_type
                ]);

                // ดึงค่า content_id ล่าสุด
                $content_id = $con->lastInsertId();

                // 2. insert เข้า employee_uploads
                $sql2 = "INSERT INTO assignments 
                    (content_id, file_path,example_file_name,group_member,assign_title,assign_detail,start_date,end_date,max_score) 
                    VALUES (:content_id, :file_path,:example_file_name,:group_member,:assign_title,:assign_detail,:start_date,:end_date,:max_score)";

                $stmt2 = $con->prepare($sql2);
                $stmt2->execute([
                    ':content_id' => $content_id,
                    ':file_path' => $file_path,
                    ':example_file_name' => $content_id,
                    ':group_member' => $file_path,
                    ':assign_title' => $assign_title,
                    ':assign_detail' => $content_id,
                    ':start_date' => $file_path,
                    ':end_date' => $content_id,
                    ':max_score' => $file_path

                ]);
        
                header("location: course.php?id=$course_id");
            }
        }
    }
}
