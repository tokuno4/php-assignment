<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

$name = $_POST['uName'] ?? "";
$email = $_POST['uEmail'] ?? "";
$style = $_POST['uStyle'] ?? "";
$why = $_POST['why'] ?? "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>報名結果</title>
</head>

<body bgcolor="#FFF3E0">

<center>

<h1>🎉 報名完成</h1>

<table border="1" width="600">
<tr><td>姓名</td><td><?php echo $name; ?></td></tr>
<tr><td>Email</td><td><?php echo $email; ?></td></tr>
<tr><td>攝影風格</td><td><?php echo $style; ?></td></tr>
<tr><td>參加原因</td><td><?php echo $why; ?></td></tr>
</table>

<br>

</center>

</body>
</html>