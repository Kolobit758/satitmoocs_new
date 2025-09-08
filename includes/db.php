<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'satit_moocs';

$dsn = "mysql:host=$servername;dbname=$dbname;";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // แสดงข้อผิดพลาด
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // คืนค่าเป็น array แบบ associative
    PDO::ATTR_EMULATE_PREPARES   => false,                  // ป้องกัน SQL Injection
];

try{
    $con = new PDO($dsn, $username, $password, $options);
}catch(PDOException $e){
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}


?>