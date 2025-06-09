<?php
$host = 'localhost';
$dbname = 'ohanna';
$user = 'root';

$dsn = "mysql:host=$host;dbname=$dbname";
$db = new PDO($dsn, $user);

$uid = $_REQUEST['us'];
$_SERVER['us'] = $uid;
$name = $_REQUEST['usname'];
$phone = $_REQUEST['phone'];
$password = $_REQUEST['pa'];
$birthday = $_REQUEST['bsday'];
$src = $_FILES['file']['tmp_name'];
$data = file_get_contents($src);

$sql = "
    insert into User (uid, name, password, birthday, phone)
    values(?,?,?,?,?)
";
$stmt = $db->prepare($sql);
$stmt->execute([$uid, $name, $password, $birthday, $phone]); //綁定

$sql ="
    insert into headphoto (uid, photo)
    values(?,?)
";
$stmt = $db->prepare($sql);
$stmt->execute([$uid, $data]);

header('Location: main.php');
?>






