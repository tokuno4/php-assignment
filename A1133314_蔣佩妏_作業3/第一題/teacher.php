<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<h2>未登入！2秒後返回登入頁</h2>";
    header("Refresh:2; url=login.php");
    exit();
}

if ($_SESSION['login'] != 'teacher') {
    echo "<h2>沒有權限進入此頁面</h2>";
    header("Refresh:2; url=login.php");
    exit();
}

$userID = "未設定";
if (isset($_COOKIE['uName'])) {
    $userID = $_COOKIE['uName'];
}

echo "<h1>Welcome, Teacher!</h1>";
echo "<p>你的ID是：".$userID."</p>";

echo "<a href='logout.php'>登出</a><br><br>";

echo "<a href='cookiedel.php'>刪除Cookie</a>";
?>