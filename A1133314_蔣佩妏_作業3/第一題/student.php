<?php
session_start();

if(!isset($_SESSION["login"]) || $_SESSION["login"] !== "student"){
    echo "此頁面需要學生身分才能進入...";
    header("Refresh:2; url=login.php");
    exit();
}

$user = $_SESSION["login"];

$status = "尚未簽到";

if(isset($_POST["checkin"])){
    $_SESSION["isSigned"] = true;
}

if(isset($_SESSION["isSigned"]) && $_SESSION["isSigned"] === true){
    $status = "今日已完成簽到";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>學生頁面</title>
</head>

<body>

<h1>學生專區</h1>
<p>歡迎你，<?php echo $user; ?>！</p>

<hr>

<h3>簽到功能</h3>
<p>目前狀態：<?php echo $status; ?></p>

<form method="post">
    <input type="submit" name="checkin" value="簽到">
</form>

<hr>

<a href="logout.php">登出</a>

</body>
</html>