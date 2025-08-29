<?php

include "includes/db.php";

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ดึงข้อมูล user
    $stmt = $con->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "ไม่มีผู้ใช้นี้ในระบบ";
        exit;
    }

    if (!password_verify($password, $user['password_hash'])) {
        echo "รหัสผ่านไม่ถูกต้อง";
        exit;
    }

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['full_name'] = $user['full_name'];

    // ตรวจสอบ role
    $stmtRole = $con->prepare("SELECT role FROM empolyee_role WHERE user_id = :user_id");
    $stmtRole->execute([':user_id' => $user['user_id']]);
    $userdata = $stmtRole->fetch(PDO::FETCH_ASSOC);

    if ($userdata) {
        if ($userdata['role'] == 1) {
            // ครู
            $_SESSION['user'] = $user;
            header("Location: teacher_pages/dashboard.php");
            exit;
        } else if ($userdata['role'] == 2) {
            // admin
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit;
        }
    } 

    // ถ้าไม่มี role หรือ role ไม่ใช่ 1 หรือ 2 → ตรวจสอบนักเรียน
    $stmtStudent = $con->prepare("SELECT * FROM student_courses WHERE user_id = :user_id");
    $stmtStudent->execute([':user_id' => $user['user_id']]);
    $student = $stmtStudent->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $_SESSION['user'] = $student;
        header("Location: student_pages/dashboard.php");
        exit;
    } else {
        // ไม่ใช่ admin, teacher, หรือ student
        echo "ไม่พบ role ของผู้ใช้นี้ กรุณากรอกใหม่";
        exit;
    }
} else {
    echo "ไม่สามารถเข้าถึงหน้านี้โดยตรงได้";
}
