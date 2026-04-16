<?php
session_start();

$_SESSION = [];
session_destroy();
if(isset($_COOKIE["uName"])){
    setcookie("uName", "", time() - 3600,"/");
}

echo "您已成功登出，正在返回登入頁...";

header("Refresh:2; url=login.php");
exit();
?>