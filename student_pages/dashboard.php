<?php

include "../includes/db.php";

session_start();
//user session
$sql = 'SELECT course_name,user_img, full_name, email FROM users 
INNER JOIN student_courses ON users.user_id = student_courses.user_id 
INNER JOIN courses ON student_courses.course_id = courses.course_id;';

$stmt = $con->prepare($sql);
$stmt->execute();
$user_data = $stmt->fetch();
$user = $_SESSION['user'];
//course_session
$sql = 'SELECT course_name, course_level, course_img FROM users
INNER JOIN student_courses ON users.user_id = student_courses.user_id 
INNER JOIN courses ON student_courses.course_id = courses.course_id;';


$stmt = $con->prepare($sql);
$stmt->execute();
$courses_data = $stmt->fetchALL();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SATITMOOCS</title>
    <?php include "../includes/boostrap.php" ?>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            /* ใช้ฟอนต์ Poppins */
        }

        .web-header {
            width: 100%;
            height: 50px;
            background: linear-gradient(90deg, #0157c1ff, #132469ff);
            display: flex;
            align-items: center;
            padding: 0 20px;
            /* เพิ่ม padding ซ้ายขวา */
            box-sizing: border-box;
            color: #ffffff;

        }


        #user_img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            padding: 3px;
            /* ระยะห่างระหว่างรูปกับ gradient border */
            background: linear-gradient(90deg, #00ff00ff, #94ccb8ff);
            display: inline-block;
        }

        #user_img img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: block;
            object-fit: cover;
        }


        .top {
            background-color: #ffffffff;
            box-shadow: 5px 25px 25px 25px rgba(0, 0, 0, 0.5);
            height: 80px;
            display: flex;
        }

        .top img {
            transform: translateY(-10px);
        }

        .course_box {
            margin-top: 50px;
            padding-left: 0;
            margin-left: 50px;
            width: 300px;
            /* กินเต็มความกว้าง column */
            height: 250px;
            /* ความสูง fix ไว้ */
            box-shadow: 2px 5px 5px 2px rgba(110, 197, 210, 0.5);
            border: 1px solid #544949ff;


        }

        .course_box img {

            width: 300px;
            height: 60%;
            object-fit: cover;
        }

        nav {
            display: flex;
            flex-direction: column;
            /* เรียงแนวตั้ง */
            align-items: flex-start;
            /* ชิดซ้าย */
            gap: 10px;
            background-color: #ffffffff;
            border: 2px solid #2e2323ff;
            height: 800px;
            /* ระยะห่างระหว่างลิงก์ */
        }

        nav a {
            text-decoration: none;
            color: #333;
            padding: 5px 0;
        }

        .nav-horizontal {
            background-color: #ffffffff;
            box-shadow: 5px 2px 2px 5px rgba(0, 0, 0, 0.3);
            display: flex;
            height: 50px;
            align-items: center;
        }

        .nav-horizontal a {
            margin: 50px;
            text-decoration: none;
            color: #000000ff;
            padding: 5px 0;
        }
    </style>
</head>

<body>

    <div class="web-header" style="display: flex; align-items:center;">
        <img src="../Uploads/profile_img/<?= $user_data['user_img'] ?>" id="user_img" alt="">
        <h5 style="padding-left: 20px;">Welcome <?= $user_data['full_name'] ?></h5>

        <div>
            <a href=""></a>
        </div>
    </div>
    <div class="row top">
        <div class="col-3 ps-5">
            <img src="../assets/TSU_logo.png" alt="" style="width: 200px; height:100px;">
        </div>
        <div class="col-6">

        </div>
        <div class="col-3 mt-3">
            <form action="">
                <input type="text" placeholder="search">
            </form>
        </div>
    </div>

    <div class="row nav-horizontal">
        <div class="col-10">
            <a href="#">Home</a>
            <a href="#">Dashboard</a>
            <a href="#">Events</a>
            <a href="#">Mycourse</a>
            <a href="#">Tutorials</a>
        </div>
        <div class="col-2">
            <button id="hideblock">Hide block</button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- คอลัมน์เนื้อหา -->
            <div class="col-10">
                <div class="row g-3">
                    <?php foreach ($courses_data as $course_data) : ?>
                        <div class="col-4 course_box">
                            <img src="../Uploads/course_profile_img/<?= $course_data['course_img'] ?>" alt="">
                            <h4><?= $course_data['course_name'] ?></h4>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- คอลัมน์เมนู -->
            <div class="col-2">
                <nav>
                    <a href="#">Home</a>
                    <a href="#">Dashboard</a>
                    <a href="#">Events</a>
                    <a href="#">Mycourse</a>
                    <a href="#">Tutorials</a>
                </nav>
            </div>
        </div>
    </div>




</body>

</html>