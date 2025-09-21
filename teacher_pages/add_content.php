<?php
session_start();
include "../includes/db.php";

$course_id = $_GET['id'] ?? null;
$user_id   = $_GET['user_id'] ?? null;
$action    = $_GET['action'] ?? null;
$chapter_id = $_GET['chapter_id'] ?? null;

if (isset($_GET['content_name']) && isset($_GET['description'])) {
    $title       = $_GET['content_name'];
    $description = $_GET['description'];
    $course_id_real = $_GET['id'];
    // insert chapter
    $sql = 'INSERT INTO chapters (course_id, title, description) 
            VALUES (:course_id, :title, :description)';
    $stmt = $con->prepare($sql);
    $stmt->execute([
        ':course_id'   => $course_id_real,
        ':title'       => $title,
        ':description' => $description
    ]);

    header("Location: course.php?id=$course_id");
    exit();
}
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
                <form class="card-body" action="add_content.php">
                    <div class="mb-3">
                        <input type="text" hidden name="id" value="<?= $course_id ?>">
                        <label for="exampleInputEmail1" class="form-label">Content name</label>
                        <input name="content_name" class="form-control">
                        <div id="emailHelp" class="form-text">enter the new content name.</div>
                        <label for="exampleInputEmail1" class="form-label">Description</label>
                        <input name="description" class="form-control">
                        <div id="emailHelp" class="form-text">enter description.</div>
                    </div>
                    <button type="submit" name="action" value="add_chapter" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <?php if ($action == "add_assignment"): ?>
            <div class="container mt-5 mb-5">
                <div class="card p-5">
                    <form class="card-body" action="upload_and_assign.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" hidden name="id" value="<?= $course_id ?>">
                            <input type="text" hidden name="chapter_id" value="<?= $chapter_id ?>">
                            <input hidden name="content_type" value="1">
                            <label class="form-label">Upload file</label>
                            <input type="file" name="file" class="form-control">
                            <label class="form-label">Description</label>
                            <input name="description" class="form-control">
                        </div>
                        <button type="submit" name="action" value="add_chapter" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="container mt-5 mb-5">
                <div class="card p-5">
                    <form class="card-body" action="upload_and_assign.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" hidden name="id" value="<?= $course_id ?>">
                            <input type="text" hidden name="chapter_id" value="<?= $chapter_id ?>">
                            <input hidden name="content_type" value="2">
                            <label class="form-label">Upload file</label>
                            <input type="file" name="file" class="form-control">
                            <label class="form-label">Description</label>
                            <input name="description" class="form-control">
                            <label class="form-label">start_date</label>
                            <input type="date" name="start_date" class="form-control">
                            <label class="form-label">Due_date</label>
                            <input type="date" name="end_date" class="form-control">
                            <label class="form-label">Assign_title</label>
                            <input name="assign_title" class="form-control">
                            <label class="form-label">Group member</label>
                            <input name="group_member" class="form-control" placeholder="Enter number of group member or if it is solo work you can skip this box">
                        </div>
                        <button type="submit" name="action" value="add_assignment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>