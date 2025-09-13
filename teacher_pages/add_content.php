<?php

session_start();
include "../includes/db.php";

$course_id = $_GET['id'];
$user_id = $_GET['user_id'];
$action = $_GET['action'];



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <?php include "../includes/boostrap.php" ?>
    <link href="https://fonts.googleapis.com/css2?family=Itim&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        body,
        html {
            background: linear-gradient(160deg, #000000ff, #3f4457ff);
        }

        .my-top-nav::before {
            content: "";
            height: 200px;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include "../includes/nav.php"; ?>
    <?php if ($action == "add_chapter"): ?>
        <div class="container mt-5 mb-5">
            <div class="card p-5">
                <form class="card-body" action="">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" name="action" value="add_chapter" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <?php if ($action == "add_assignment"): ?>
        <?php else: ?>

        <?php endif; ?>
    <?php endif; ?>
</body>

</html>