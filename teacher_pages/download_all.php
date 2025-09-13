<?php
session_start();
include "../includes/db.php";

if (!isset($_GET['id']) || !isset($_GET['assign_id'])) {
    die("กรุณาใส่ id และ assign_id");
}

$assign_id = $_GET['assign_id'];

// ดึงไฟล์ทั้งหมดจาก DB
$sql = "SELECT file_path FROM submissions WHERE assign_id = :assign_id";
$stmt = $con->prepare($sql);
$stmt->execute([':assign_id' => $assign_id]);
$files = $stmt->fetchAll(PDO::FETCH_COLUMN);

$zip = new ZipArchive;
$zipFile = "all_submissions.zip";

if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach ($files as $file) {
        if (file_exists($file)) {
            $zip->addFile($file, basename($file));
        }
    }
    $zip->close();

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($zipFile) . '"');
    header('Content-Length: ' . filesize($zipFile));
    readfile($zipFile);
    unlink($zipFile);
    exit;
} else {
    echo "ไม่สามารถสร้าง zip ได้";
}
