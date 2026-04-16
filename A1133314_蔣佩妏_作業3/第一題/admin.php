<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin'){
    echo "<h2>存取被拒，請先登入</h2>";
    header("Refresh:2; url=login.php");
    exit();
}

$userId = isset($_COOKIE['uName']) ? $_COOKIE['uName'] : "未設定";

?>

<h1>Administrator Page</h1>
<p>Welcome, admin!</p>
<p>Your ID: <?php echo $userId; ?></p>

<a href="logout.php">登出</a><br>
<a href="cookiedel.php">刪除Cookie</a>