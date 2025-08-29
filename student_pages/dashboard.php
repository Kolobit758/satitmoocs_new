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
INNER JOIN courses ON student_courses.course_id = courses.course_id
WHERE users.user_id = :user_id';



$stmt = $con->prepare($sql);
$stmt->bindParam(':user_id', $user['user_id'], PDO::PARAM_INT);
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
            background-color: #f0f4f8;

            /* ใช้ฟอนต์ Poppins */
        }

        .web-header {
            width: 100%;
            height: 50px;
            background-image: url("https://i.pinimg.com/originals/a0/84/65/a08465fcb5cb830adfcbcc3ae9ea1116.gif");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* ทำ parallax */
            display: flex;
            align-items: center;
            padding: 0 20px;
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
            /* box-shadow: 5px 25px 25px 25px rgba(0, 0, 0, 0.5); */
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
            width: 260px;
            /* กินเต็มความกว้าง column */
            height: 250px;
            /* ความสูง fix ไว้ */
            box-shadow: 2px 5px 20px 2px rgba(152, 167, 186, 0.5);
            background-color: #ffffff;



        }

        .course_box img {

            width: 260px;
            height: 60%;
            object-fit: cover;
        }

        nav {
            margin-top: 5px;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            /* เรียงแนวตั้ง */
            align-items: flex-start;
            /* ชิดซ้าย */
            gap: 10px;
            background-color: #ffffff;
            border-radius: 20px 20px 20px 20px;
            height: 800px;
            width: 500px;
            position: relative;
            /* จำเป็นสำหรับ ::after */
            z-index: 2;
            /* nav อยู่ด้านบน */
        }




        /* ซ่อน scrollbar ทั้งหมด */
        ::-webkit-scrollbar {
            display: none;
        }

        body {
            -ms-overflow-style: none;
            /* IE และ Edge เก่า */
            scrollbar-width: none;
            /* Firefox */
        }



        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
            padding: 5px 0;
        }

        .nav-horizontal {
            margin-top: 2px;
            background-color: #ffffffff;

            display: flex;
            height: 50px;
            align-items: center;

            z-index: 2;
        }

        .nav-horizontal a {
            margin: 50px;
            text-decoration: none;
            color: #000000ff;
            padding: 5px 0;
        }

        #hideblock {
            padding: 10px 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: #fff;
            background: linear-gradient(90deg, #132469, #0157c1);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        #hideblock:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            background: linear-gradient(90deg, #0157c1, #132469);
        }

        #hideblock:active {
            transform: translateY(1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

            <h3>Course overview</h3>
            <!-- คอลัมน์เนื้อหา -->
            <div class="col-10">
                <div class="row g-3">
                    <?php foreach ($courses_data as $course_data) : ?>
                        <div class="col-3 course_box">
                            <?php $img_path = "../Uploads/course_profile_img/" . $course_data['course_img']; ?>
                            <?php if (!empty($course_data['course_img']) && file_exists($img_path)): ?>
                                <img src="../Uploads/course_profile_img/<?= $course_data['course_img'] ?>" alt="">
                                <h4><?= $course_data['course_name'] ?></h4>
                            <?php else: ?>
                                <img src="../Uploads/course_profile_img/default.jpg" alt="">
                                <h4><?= $course_data['course_name'] ?></h4>
                            <?php endif; ?>


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