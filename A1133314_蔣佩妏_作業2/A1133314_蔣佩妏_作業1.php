<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>攝影美學夏令營報名</title>
</head>

<body bgcolor="#FDF6F0">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['uName'] ?? "";
    $email = $_POST['uEmail'] ?? "";
    $style = $_POST['uStyle'] ?? "";

    echo "<center>";
    echo "<table border='1' width='700' style='margin-top:20px;'>";
    echo "<tr><th style='font-size:22px;'>報名成功</th></tr>";
    echo "<tr><td align='center'>";
    echo "姓名：" . $name . "<br>";
    echo "Email：" . $email . "<br>";
    echo "拍攝風格：" . $style;
    echo "</td></tr>";
    echo "</table>";
    echo "</center><br><br>";
}
?>

<center>

<br><br>

<h1 style="color:#5C3A21;">攝影美學夏令營</h1>
<p>這個夏天，一起用照片記錄生活。</p>

<table border="1" width="700">

    <tr>
        <th style="font-size:24px; padding:10px;">
            PHOTO CAMP PASS
        </th>
    </tr>

    <tr>
        <td align="center">
            Welcome to capture your own story
        </td>
    </tr>

    <tr>
        <td align="center">
            <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32" width="300">
        </td>
    </tr>

    <tr>
        <td align="center">
            No. 2026-PHOTO<br>
            地點：高雄<br>
            狀態：報名中
        </td>
    </tr>


</table>

<br><br>

<form method="POST" action="">

<table border="1" width="700">

<tr>
    <td>姓名</td>
    <td><input type="text" name="uName" required></td>
</tr>

<tr>
    <td>年齡</td>
    <td><input type="number" name="age" min="10" max="30"></td>
</tr>

<tr>
    <td>性別</td>
    <td>
        <input type="radio" name="gender" value="男">男
        <input type="radio" name="gender" value="女">女
    </td>
</tr>

<tr>
    <td>Email</td>
    <td><input type="email" name="uEmail" required></td>
</tr>

<tr>
    <td>居住地</td>
    <td>
        <select name="city">
            <option>台北</option>
            <option>台中</option>
            <option>高雄</option>
        </select>
    </td>
</tr>

<tr>
    <td>拍攝風格</td>
    <td>
        <select name="uStyle">
            <option>人像</option>
            <option>風景</option>
            <option>街拍</option>
        </select>
    </td>
</tr>

<tr>
    <td>期待程度</td>
    <td>
        <input type="range" name="fun" min="1" max="10">
    </td>
</tr>

<tr>
    <td>喜歡的色調</td>
    <td>
        <input type="color" name="color">
    </td>
</tr>

<tr>
    <td>備註</td>
    <td>
        <textarea name="uComment" rows="3" style="width:95%;"></textarea>
    </td>
</tr>

<tr>
    <td colspan="2" align="center">
        <input type="submit" value="送出報名" style="padding:8px 20px;">
        <input type="reset" value="清除">
    </td>
</tr>

</table>

</form>

<br>

<p style="font-size:12px;"></p>

</center>

</body>
</html>