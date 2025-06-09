<?php
$src = $_FILES['file']['tmp_name']; //['tmp_name'] 這串是PHP隨機給的暫時檔名
$orm = $_FILES['file']['name'];
$hash = hash('md5', $orm);  //md5建議不要用容易破,建議sha512 or sha256加密
$dst = 'img/' . $hash;
move_uploaded_file($src, $dst);
print("$hash");