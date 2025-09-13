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


$sql = "SELECT users.full_name,
               assignments.assign_id,
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
INNER JOIN users ON users.user_id = submissions.user_id 
WHERE assignments.assign_id = :assign_id";
$stmt = $con->prepare($sql);
$stmt->execute([
    ':assign_id' => $assign_id
]);
$submission = $stmt->fetchALL();

$sql = 'SELECT * FROM assignments WHERE assign_id = :assign_id';
$stmt = $con->prepare($sql);
$stmt->execute([
    ':assign_id' => $assign_id
]);
$assignments = $stmt->fetch();
$file_path_set = [];

$rowcount = 0;
?>
<!DOCTYPE html>
<html lang="th">

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
    <?php include "../includes/nav.php" ?>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="score_manage.php" method="POST">
                        <input type="text" name="course_id" hidden>
                        <input type="text" name="user_id" hidden>
                        <input type="text" name="submission_id" hidden>
                        <input type="text" name="assign_id" hidden>
                        <input type="number" name="score">
                        <button type="submit" class="btn btn-warning">Score Update</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <i class="bi bi-tools"></i>
    <?php if ($submission != null) : ?>
        <div class="container mt-5 mb-5 card table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Order</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Submit Date</th>
                        <th scope="col">File</th>
                        <th scope="col">Dowload</th>
                        <th scope="col">Text</th>
                        <th scope="col">Score</th>
                        <th scope="col">Score Manage</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($submission as $row): ?>
                        <?php $rowcount++; ?>
                        <?php $file_path_set[$rowcount] = $row['file_path']; ?>
                        <tr>
                            <th scope="row"><?= $rowcount ?></th>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['submitted_at'] ?></td>
                            <td><a href="<?= $row['file_path'] ?>"><?= $row['file_name'] ?></a></td>
                            <td><a class="btn btn-secondary" href="<?= $row['file_path'] ?>" download>DOWLOAD</td>
                            <td><?= $row['submission_text'] ?></td>
                            <td><?= $row['score'] ?></td>
                            <td>
                                <button class="btn btn-outline-none d-flex justify-content-center" 
                                data-bs-toggle="modal" 
                                data-bs-target="#exampleModal"
                                data-user_id ="<?=$row['user_id'] ?>"
                                data-submission_id ="<?=$row['submission_id']?>"
                                data-assign_id ="<?=$row['assign_id']?>"
                                data-course_id ="<?=$course_id?>">
                                
                                    <i class="bi bi-tools"></i>
                                </button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <a href="download_all.php?id=<?= $_GET['id'] ?>&assign_id=<?= $_GET['assign_id'] ?>"
                    class="w-25 btn btn-success mt-3 mb-3">
                    Download All
                </a>
            </div>

                        
        </div>
    <?php else: ?>
        <div class="container mt-5 mb-5 card">

        </div>
    <?php endif; ?>
</body>
<script>
    var exampleModal = document.getElementById('exampleModal');
    exampleModal.addEventListener('show.bs.modal',function(event){
        var button = event.relatedTarget;
        var user_id = button.getAttribute('data-user_id');
        var submission_id = button.getAttribute('data-submission_id');
        var assign_id = button.getAttribute('data-assign_id');
        var course_id = button.getAttribute('data-course_id');

        exampleModal.querySelector('input[name="user_id"]').value = user_id;
        exampleModal.querySelector('input[name="submission_id"]').value = submission_id;
        exampleModal.querySelector('input[name="assign_id"]').value = assign_id;
        exampleModal.querySelector('input[name="course_id"]').value = course_id;
    });
</script>
</html>