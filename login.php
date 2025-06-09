<?php
$host = 'localhost';
$dbname = 'ohanna';
$user = 'root';

$dsn = "mysql:host=$host;dbname=$dbname";
$db = new PDO($dsn, $user);

$uid = $_REQUEST['us'];
$password = $_REQUEST['pa'];
$sql = "
    SELECT *
    FROM user
    WHERE email = ? AND password = ?
";
$stmt = $db->prepare($sql);  //PDO預處理SQL:防止被攻擊
$stmt->execute([$uid, $password]);
$rows = $stmt->fetchAll();

//判斷登入
if(count($rows)===0){
    print('Login failed');
}else{
    $user = $rows[0];
    $_SESSION['user'] = $user;
    header('Location: main.php');
}