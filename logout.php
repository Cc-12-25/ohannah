<?php
unset($_SESSION['user']); //個別刪除
// session_destroy(); //全部刪除
header('location:index.html');
