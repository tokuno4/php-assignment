<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>2026 - 攝影美學夏令營報名表</title>
</head>
<body bgcolor="#FAF0E6"> <?php
    // 檢查是否有按下提交按鈕 (PHP 資料處理功能)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<center>";
        echo "<table width='800' border='0' style='background-color: #FDF5E6; border: 2px dashed #D2B48C; padding: 25px; margin-top: 20px;'>";
        echo "<tr><td>";
        echo "<h2 style='color: #8B4513;'>📸 攝影美學夏令營 - 報名資料確認</h2>";
        echo "<b>學員姓名：</b>" . $_POST['uName'] . " (" . $_POST['uGender'] . ")<br>";
        echo "<b>電子郵件：</b>" . $_POST['uEmail'] . "<br>";
        echo "<b>相機型號：</b>" . $_POST['uCamera'] . "<br>";
        echo "<b>拍攝風格：</b>" . $_POST['uStyle'] . "<br>";
        echo "<b>備註事項：</b>" . $_POST['uComment'];
        echo "</td></tr></table>";
        echo "</center>";
    }
    ?>

    <center>
        <br>
        <table border="0" width="800">
            <tr>
                <td align="center">
                    <h1 style="color: #6F4E37; border-bottom: 5px solid #D2B48C; display: inline-block; padding-bottom: 5px;">
                         2026 攝影美學·光影捕捉夏令營
                    </h1>
                    <p style="color: #8B4513;"><b>用鏡頭記錄美好，從基礎到進階，開啟你的視覺之旅！</b></p>
                </td>
            </tr>
        </table>
    </center>

    <form action="" method="POST">
        <table width="820" border="1" align="center" cellpadding="12" cellspacing="0" bordercolor="#D2B48C" style="background-color: #FFFFFF; border-collapse: collapse;">
            
            <tr bgcolor="#E6CCB2">
                <td colspan="4" align="center">
                    <font color="#4B2408" size="4"><b>【 創作者基本資料 】</b></font>
                </td>
            </tr>

            <tr>
                <td width="15%" align="right" bgcolor="#FFF8DC">姓名：</td>
                <td width="35%">
                    <input type="text" name="uName" placeholder="請輸入全名" required size="25">
                </td>
                <td width="15%" align="right" bgcolor="#FFF8DC">性別：</td>
                <td width="35%">
                    <input type="radio" name="uGender" value="男" required> 男 
                    <input type="radio" name="uGender" value="女"> 女
                </td>
            </tr>

            <tr>
                <td align="right" bgcolor="#FFF8DC">出生日期：</td>
                <td>
                    <input type="date" name="uBirth" required>
                </td>
                <td align="right" bgcolor="#FFF8DC">電子郵件：</td>
                <td>
                    <input type="email" name="uEmail" placeholder="example@mail.com" required size="25">
                </td>
            </tr>

            <tr bgcolor="#E6CCB2">
                <td colspan="4" align="center">
                    <font color="#4B2408" size="4"><b>【 攝影經驗與器材 】</b></font>
                </td>
            </tr>

            <tr>
                <td align="right" bgcolor="#FFF8DC">自備器材：</td>
                <td>
                    <select name="uCamera" required>
                        <option value="">-- 請選擇器材 --</option>
                        <option value="單眼相機 (DSLR)">單眼相機 (DSLR)</option>
                        <option value="微單眼 (Mirrorless)">微單眼 (Mirrorless)</option>
                        <option value="數碼相機 (DC)">數碼相機 (DC)</option>
                        <option value="手機攝影">手機攝影</option>
                        <option value="底片相機">底片相機</option>
                    </select>
                </td>
                <td align="right" bgcolor="#FFF8DC">相機品牌：</td>
                <td>
                    <input type="text" name="uBrand" placeholder="例如：Canon, Sony" size="20">
                </td>
            </tr>

            <tr>
                <td align="right" bgcolor="#FFF8DC">拍攝風格：</td>
                <td colspan="3">
                    <select name="uStyle" required>
                        <option value="">-- 我偏好的風格 --</option>
                        <option value="人像攝影">人像攝影</option>
                        <option value="風景攝影">風景攝影</option>
                        <option value="街頭攝影">街頭攝影</option>
                        <option value="動態攝影">動態攝影</option>
                        <option value="黑白攝影">黑白攝影</option>
                    </select>
                </td>
            </tr>

            <tr bgcolor="#E6CCB2">
                <td colspan="4" align="center">
                    <font color="#4B2408" size="4"><b>【 營隊與餐點設定 】</b></font>
                </td>
            </tr>

            <tr>
                <td align="right" bgcolor="#FFF8DC">報名梯次：</td>
                <td>
                    <input type="radio" name="uSession" value="T1" required> 第一梯 (7/01-7/05) &nbsp;&nbsp;
                    <input type="radio" name="uSession" value="T2"> 第二梯 (8/15-8/19)
                </td>
                <td align="right" bgcolor="#FFF8DC">衣服尺寸：</td>
                <td>
                    <input type="radio" name="uSize" value="S"> S 
                    <input type="radio" name="uSize" value="M" checked> M 
                    <input type="radio" name="uSize" value="L"> L 
                    <input type="radio" name="uSize" value="XL"> XL
                </td>
            </tr>

            <tr>
                <td align="right" bgcolor="#FFF8DC" valign="top">備註與需求：</td>
                <td colspan="3">
                    <textarea name="uComment" rows="4" style="width: 95%;" placeholder="若有特殊過敏或器材租借需求請註明..."></textarea>
                </td>
            </tr>

            <tr>
                <td colspan="4" align="center" style="padding: 25px;">
                    <input type="checkbox" required> 我已閱讀並同意本營隊之退費辦法與相關權益
                    <br><br>
                    <input type="submit" value="   提交報名資料   " style="background-color: #6F4E37; color: white; border: none; padding: 12px 40px; border-radius: 5px; cursor: pointer; font-size: 16px;">
                    &nbsp;&nbsp;
                    <input type="reset" value="   清除重填   " style="padding: 10px 20px; border-radius: 5px;">
                </td>
            </tr>
        </table>
    </form>

    <br>
    <center>
        <hr width="600" color="#D2B48C">
        <font size="2" color="#666666">© 2026  | </font>
        <a href="http://www.nuk.edu.tw" target="_blank" style="text-decoration:none;"><font size="2" color="#6F4E37">回高雄大學首頁</font></a>
    </center>
    <br><br>

</body>
</html>