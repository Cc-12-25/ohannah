<?php
$host = 'localhost';
$dbname = 'ohanna';
$user = 'root';

$dsn = "mysql:host=$host;dbname=$dbname";
$db = new PDO($dsn, $user);

$uid = $_REQUEST['us'];
$sql = "
    select *
    from user
    where uid = ?
";
$stmt = $db->prepare($sql);
$stmt->execute([$uid]);
$rows = $stmt->fetchAll();
if(count($rows) === 0){
    print('0');
}else{
    print('1');
}
