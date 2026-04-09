<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>攝影美學夏令營報名</title>
</head>

<body bgcolor="#FDF6F0">

<center>

<h1>攝影美學夏令營</h1>
<p>這個夏天，一起用照片記錄生活。</p>

<hr>

<form method="POST" action="result.php">

<h3>基本資料</h3>
姓名：<input type="text" name="uName" required><br><br>
Email：<input type="email" name="uEmail" required><br><br>

性別：
<input type="radio" name="gender" value="男">男
<input type="radio" name="gender" value="女">女
<br><br>

<hr>

<h3>攝影相關</h3>

你喜歡拍：
<select name="uStyle">
    <option value="人像">人像</option>
    <option value="風景">風景</option>
    <option value="街拍">街拍</option>
</select>
<br><br>

你期待這個營隊的程度：
<input type="range" name="fun" min="1" max="10">
<br><br>

為什麼想參加：<br>
<textarea name="why" rows="4" cols="50"></textarea>

<br><br>

<input type="submit" value="送出報名">
<input type="reset" value="清除">

</form>

<br>
<a href="hw2.php">登出</a>

</center>

</body>
</html>