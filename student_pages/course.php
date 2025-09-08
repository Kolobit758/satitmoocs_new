<?php
session_start();
include "../includes/db.php";
include "../includes/time_helper.php";

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    $user = $_SESSION['user'];
    $user_data = $_SESSION['user_data'];

    // SQL senior เขียนให้
    $sql = "SELECT 
        chapters.chapter_id, 
        chapters.title AS chapter_title, 
        chapters.description AS chapter_description, 
        course_contents.content_id,
        course_contents.title AS course_contents_title, 
        course_contents.detail AS course_contents_detail, 
        course_contents.created_at, 
        course_contents.is_visible,

        -- uploads
        employee_uploads.upload_id,
        employee_uploads.file_path,

        -- assignments
        assignments.assign_id,
        assignments.assign_title,
        assignments.assign_detail,
        assignments.start_date,
        assignments.end_date,
        assignments.max_score

    FROM courses 
    INNER JOIN student_courses 
        ON student_courses.course_id = courses.course_id 
    INNER JOIN chapters 
        ON courses.course_id = chapters.course_id 
    INNER JOIN course_contents 
        ON course_contents.chapter_id = chapters.chapter_id 

    LEFT JOIN employee_uploads 
        ON employee_uploads.content_id = course_contents.content_id
    LEFT JOIN assignments 
        ON assignments.content_id = course_contents.content_id

    WHERE student_courses.user_id = :user_id 
    AND courses.course_id = :course_id
    ORDER BY chapters.chapter_id, course_contents.content_id;
    ";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(':user_id', $user['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM submissions WHERE user_id = :user_id";
    $stmt = $con->prepare($sql);
    $stmt->execute([
        ':user_id' => $user['user_id'],
    ]);
    $submission = $stmt->fetchAll();

    $submissionSlice = [];
    foreach ($submission as $sub) {
        $submissionSlice[$sub['assign_id']] = $sub;
    }
    // เก็บ chapter ที่เจอแล้ว
    // $current_chapter = null;
    $current_chapter = null;



    if (!$courses) {
        echo "ไม่พบข้อมูลคอร์สนี้";
        exit;
    }
} else {
    echo "ไม่พบรหัสคอร์ส";
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>SatitMoocs_CourseINFO</title>
    <link rel="stylesheet" href="style.css">
    <?php include "../includes/boostrap.php" ?>
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Itim&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <?php include "../includes/nav.php"; ?>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <?php foreach ($courses as $row) : ?>
                    <?php if ($current_chapter !== $row['chapter_title']): ?>
                        <?php if ($current_chapter !== null): ?>
            </div> <!-- ปิด div chapter ก่อนหน้า -->
        <?php endif; ?>

        <!-- เริ่ม chapter ใหม่ -->
        <div class="chapter" style="border:5px dotted #e3e3e3ff; margin:15px 0; padding:20px; border-radius:0px; background-color: #ffffffff;">
            <h3 style="margin:0; color:#2c3e50;" class="chapter-title">
                <?= htmlspecialchars($row['chapter_title']); ?>
            </h3>
        <?php endif; ?>

        <!-- เนื้อหาใน chapter -->
        <div class="content mt-2 p-md-3 p-2" style="margin-left:20px; padding:5px 0;  box-shadow:5px 2px 10px 0px #cdd2b544; background-color: #ffffff52;">
            <p><strong><?= htmlspecialchars($row['course_contents_title']); ?></strong></p>
            <!-- เช็คว่ามีไฟล์แนบมามั้ย -->
            <?php if (!empty($row['file_path'])): ?>
                <a href="../Uploads/PDF_file_path/<?= $row['file_path'] ?>" download style="color:#3498db; text-decoration:none;">
                    📂 ดาวน์โหลดไฟล์
                </a>
            <?php endif; ?>
            <!-- เช็คว่ามี id กล่องส่งงานมั้ย -->
            <?php if (!empty($row['assign_id'])): ?>
                <?php if (isset($submissionSlice[$row['assign_id']]) && !empty($submissionSlice[$row['assign_id']]['submission_status']) && $submissionSlice[$row['assign_id']]['submission_status'] == 1): ?>
                    <a href="assign_view.php?id=<?= $course_id ?>&assign_id=<?= $row['assign_id'] ?>">
                        <button class="btn btn-success">Update submission</button>
                    </a>
                <?php else: ?>
                    <a href="assign_view.php?id=<?= $course_id ?>&assign_id=<?= $row['assign_id'] ?>">
                        <?php if (checkDueTime($row['end_date'])): ?>
                            <button class="btn btn-danger">Add submission</button>
                        <?php else: ?>
                            <button class="btn btn-warning">Add submission</button>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>


        </div>

        <?php $current_chapter = $row['chapter_title']; ?>
    <?php endforeach; ?>

    <?php if ($current_chapter !== null): ?>
        </div> <!-- ปิด div chapter สุดท้าย -->
    <?php endif; ?>
        </div>
    </div>

    </div>
</body>

</html>