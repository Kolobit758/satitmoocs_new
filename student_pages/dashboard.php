<?php

include "../includes/db.php";

session_start();

$sql = 'SELECT course_name, full_name, email FROM users INNER JOIN student_courses ON users.user_id = student_courses.user_id INNER JOIN courses ON student_courses.course_id = courses.course_id;';
$stmt = $con->prepare($sql);
$stmt->execute();
$user_data = $stmt->fetch();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SATITMOOCS</title>
</head>
<body>
    <h1>Hello <?=$user_data['full_name']?></h1>
</body>
</html>