<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登入頁面</title>
</head>

<body bgcolor="#FDF6F0">

<center>
    <h1>攝影夏令營登入</h1>

    <form method="POST" action="logincheck.php">
        帳號：<input type="text" name="username"><br><br>
        密碼：<input type="password" name="password"><br><br>

        <input type="submit" value="登入">
    </form>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>登入失敗，請重新輸入</p>";
    }
    ?>
</center>

</body>
</html>