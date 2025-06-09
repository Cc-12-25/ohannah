<?php
$host = 'localhost';
$dbname = 'ohanna';
$user = 'root';

$dsn = "mysql:host=$host;dbname=$dbname";
$db = new PDO($dsn, $user);

//抓資料
$uid = $_SESSION['user']['uid'];

$sql = "
    SELECT *
    FROM Headphoto
    WHERE uid = ?
";

$stmt = $db->prepare($sql);
$stmt->execute([$uid]);
$data = $stmt->fetch()['photo']; //印出照片
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $finfo->buffer($data);
header("content-type: $mime_type");
print($data);

