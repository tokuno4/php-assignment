<?php
session_start();

$user = "";
if(isset($_COOKIE['uName'])){
    $user = $_COOKIE['uName'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>
<body>

<?php if($user != ""): ?>
    <p>歡迎回來：<?php echo $user; ?></p>
    <a href="cookiedel.php">清除記錄</a><br><br>
<?php endif; ?>

<form action="logincheck.php" method="post">
    帳號：<input type="text" name="uID"><br><br>
    密碼：<input type="password" name="uPWD"><br><br>
    <input type="submit" value="登入">
</form>

<hr>
<p>系統時間：<?php echo date("Y-m-d H:i:s"); ?></p>

</body>
</html>