<?php

include "../includes/db.php";
include "../includes/time_helper.php";

session_start();
$user = $_SESSION['user'];
//user session
$sql = 'SELECT users.full_name, users.user_img, users.email, empolyee_role.role, employee_course.course_id,
               courses.course_name,courses.course_level,courses.course_img FROM users 
INNER JOIN empolyee_role ON empolyee_role.user_id = users.user_id 
INNER JOIN employee_course ON employee_course.useripass = empolyee_role.useripass
INNER JOIN courses ON courses.course_id = employee_course.course_id
WHERE users.user_id = :user_id;';

$stmt = $con->prepare($sql);
$stmt->execute([':user_id' => $user['user_id']]);
$user_datas = $stmt->fetchAll();
$_SESSION['user_data'] = $user_data;

$sql = 'SELECT * FROM users WHERE users.user_id = :user_id';

$stmt = $con->prepare($sql);
$stmt->execute([':user_id' => $user['user_id']]);
$user_data = $stmt->fetch();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Sidebar 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>
    <?php include "../includes/nav.php" ?>
    <div class="container-fluid p-0 d-flex h-100 mt-2 ">
        <div id="bdSidebar" class="sidebar-custom d-flex flex-column flex-shrink-0 p-3 text-white offcanvas-md offcanvas-start rounded-start-4" style="width: 280px;">
            <a href="#" class="navbar-brand">
                <h5><i class="fa-solid fa-bomb me-2" style="font-size: 28px;"></i> Remote Dev</h5>
            </a>
            <hr>
            <ul class="mynav nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="#" class="active">
                        <i class="fa-solid fa-wave-square"></i>
                        YOUR ASSIGMENTS

                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="">
                        <i class="fa-solid fa-bell"></i>
                        Notifications
                        <span class="notification-badge">5</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="">
                        <i class="fa-solid fa-chart-simple"></i>
                        Analytics
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="">
                        <i class="fa-solid fa-star"></i>
                        Saved Reports
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Orders
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="">
                        <i class="fa-solid fa-user"></i>
                        User Reports
                    </a>
                </li>
            </ul>
            <hr>

        </div>

        <div class="bg-light flex-fill rounded-end-4">
            <div class="p-2 d-md-none d-flex text-white bg-success">
                <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                    <i class="fa-solid fa-bars"></i>
                </a>
                <span class="ms-3">kobchok studio</span>
            </div>
            <div class="p-4 main-box">
                <nav style="--bs-breadcrumb-divider:'>';font-size:14px">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="fa-solid fa-house"></i></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Orders</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between">
                    <h5>Orders</h5>
                    <button class="btn btn-sm btn-light"><i class="fa-solid fa-download"></i> Download</button>
                </div>
                <hr>


                <div class="col-md-11 mt-4 ms-md-5">
                    <div class="course-head text-center mb-4">
                        <h3>Course Overview</h3>
                    </div>

                    <div class="row g-3">
                        <?php foreach ($user_datas as $course_data) : ?>
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 course_box">
                                <a href="course.php?id=<?= $course_data['course_id'] ?>" class="course_box" style="text-decoration: none; color: inherit;">
                                    <?php $img_path = "../Uploads/course_profile_img/" . $course_data['course_img']; ?>
                                    <div class="card shadow-sm">
                                        <?php if (!empty($course_data['course_img']) && file_exists($img_path)): ?>
                                            <img src="../Uploads/course_profile_img/<?= $course_data['course_img'] ?>" alt="" class="card-img-top">
                                        <?php else: ?>
                                            <img src="../Uploads/course_profile_img/default.jpg" alt="" class="card-img-top">
                                        <?php endif; ?>
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><?= $course_data['course_name'] ?></h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <?php include "../includes/footer.php" ?>



        </div>
</body>

</html>