<?php
session_start();
include "../includes/db.php";

$action = $_POST['action'] ?? '';
$course_id = $_POST['course_id'];
$user_id = $_POST['user_id'] ?? 0;
$assign_id = $_POST['assign_id'] ?? 0;
$submission_text = $_POST['submission_text'] ?? "";
$submission_status = "1"; // ค่า default
$submitted_at = date("Y-m-d H:i:s");

if (!empty($_FILES['file']['name'])) {
    $uploadDir = "../Uploads/submissions/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $file_name = basename($_FILES['file']['name']);
    $file_path = time() . "_" . basename($_FILES['file']['name']);
    $targetFile = $uploadDir . $file_path;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        if ($action === "insert") {
            $sql = "INSERT INTO submissions 
                (file_name,assign_id, user_id, file_path, submission_text, submission_status, submitted_at)
                VALUES (:file_name,:assign_id, :user_id, :file_path, :submission_text, :submission_status, :submitted_at)";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':file_name' => $file_name,
                ':assign_id' => $assign_id,
                ':user_id' => $user_id,
                ':file_path' => $targetFile,
                ':submission_text' => $submission_text,
                ':submission_status' => $submission_status,
                ':submitted_at' => $submitted_at
            ]);

            $submission_id = $con->lastInsertId(); // ดึง id ล่าสุด
            echo "<script>alert('อัพโหลดสำเร็จ');";
            header("Location: assign_view.php?id=$course_id&assign_id=$assign_id&submission_id=$submission_id");
            exit;
        } else if ($action === "update") {
            $sql = "UPDATE submissions 
            SET file_name = :file_name,
                file_path = :file_path,
                submission_text = :submission_text,
                submission_status = :submission_status,
                submitted_at = :submitted_at
            WHERE user_id = :user_id 
              AND assign_id = :assign_id";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':file_name' => $file_name,
                ':file_path' => $targetFile,
                ':submission_text' => $submission_text,
                ':submission_status' => $submission_status,
                ':submitted_at' => $submitted_at,
                ':user_id' => $user_id,
                ':assign_id' => $assign_id
            ]);


            $submission_id = $con->lastInsertId(); // ดึง id ล่าสุด
            echo "<script>alert('อัพโหลดสำเร็จ');";
            header("Location: assign_view.php?id=$course_id&assign_id=$assign_id&submission_id=$submission_id");
            exit;
        }
    } else {
        echo "อัพโหลดไฟล์ไม่สำเร็จ";
    }
} else {
    echo "กรุณาเลือกไฟล์ก่อน";
}
