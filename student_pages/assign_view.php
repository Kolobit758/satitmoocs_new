<?php
session_start();
include "../includes/db.php";
include "../includes/time_helper.php";

$user_data = $_SESSION['user_data'] ?? null;
$user = $_SESSION['user'] ?? null;

if (!isset($_GET['id']) || !isset($_GET['assign_id'])) {
    die("กรุณาใส่ id และ assign_id");
}

$course_id = $_GET['id'];
$assign_id = $_GET['assign_id'];


$sql = "SELECT assignments.assign_id,
               assignments.assign_title,
               assignments.assign_detail,
               assignments.start_date,
               assignments.end_date,
               assignments.max_score,
               assignments.is_visible,
               submissions.submission_id,
               submissions.file_path,
               submissions.submission_text,
               submissions.submission_status,
               submissions.submitted_at,
               submissions.file_name,
               submissions.user_id,
               submissions.score

FROM submissions 
INNER JOIN assignments ON assignments.assign_id = submissions.assign_id 
WHERE user_id = :user_id AND assignments.assign_id = :assign_id";
$stmt = $con->prepare($sql);
$stmt->execute([
    ':user_id' => $user['user_id'],
    ':assign_id' => $assign_id
]);
$submission = $stmt->fetch();

$sql = 'SELECT * FROM assignments WHERE assign_id = :assign_id';
$stmt = $con->prepare($sql);
$stmt->execute([
    ':assign_id' => $assign_id
]);
$assignments = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <?php include "../includes/boostrap.php" ?>
    <link href="https://fonts.googleapis.com/css2?family=Itim&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
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
    <?php include "../includes/nav.php" ?>

    <?php if ($submission != null) : ?>
        <div class="container mt-5 mb-5 card">


            <form class="card-body" action="submission.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course_id) ?>">
                <input type="hidden" name="assign_id" value="<?= htmlspecialchars($assign_id) ?>">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id'] ?? 0) ?>">

                <div class="mb-3">
                    <label class="form-label">DUEDATE :</label>
                    <input type="text" class="form-control" value="<?= Formatdate($submission['end_date']) ?>" readonly disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">TIME REMAINING :</label>
                    <input type="text" class="form-control" value="<?= checkSubmissionStatus($submission['end_date'], $submission['submitted_at']) ?>" readonly disabled>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">เลือกไฟล์</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                    <a href="<?= $submission['file_path'] ?>" download><?= $submission['file_name'] ?></a>

                </div>

                <div class="mb-3">
                    <label for="submission_text" class="form-label">ข้อความเพิ่มเติม</label>
                    <input type="text" name="submission_text" id="submission_text" class="form-control">
                    <textarea name="submission_text" id="submission_text" class="form-control"></textarea>
                </div>

                <button type="submit" name="action" value="update" class="btn btn-success">Update</button>
            </form>

        </div>
    <?php else: ?>
        <div class="container mt-5 mb-5 card">
            <form class="card-body" action="submission.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course_id) ?>">
                <input type="hidden" name="assign_id" value="<?= htmlspecialchars($assign_id) ?>">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id'] ?? 0) ?>">

                <div class="mb-3">
                    <label class="form-label">DUEDATE :</label>
                    <input type="text" class="form-control" value="<?= Formatdate($assignments['end_date']) ?>" readonly disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">TIME REMAINING :</label>
                    <input type="text" class="form-control" value="<?= checkSubmissionStatus($assignments['end_date']) ?>" readonly disabled>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">เลือกไฟล์</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>


                <div class="mb-3">
                    <label for="submission_text" class="form-label">ข้อความเพิ่มเติม</label>
                    <input type="text" name="submission_text" id="submission_text" class="form-control">
                </div>
                <?php if (checkDueTime($assignments['end_date'])): ?>
                    <button type="submit" name="action" value="insert" class="btn btn-danger">Submit</button>
                <?php else: ?>
                    <button type="submit" name="action" value="insert" class="btn btn-warning">Submit</button>
                <?php endif; ?>
            </form>
        </div>
    <?php endif; ?>
</body>

</html>