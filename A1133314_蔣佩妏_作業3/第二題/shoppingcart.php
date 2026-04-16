<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的購物車清單</title>
</head>
<body>

<h2>購物車內容</h2>

<table border="1" width="90%" cellspacing="0" cellpadding="8">
    <tr bgcolor="#CCCCCC">
        <th>操作</th>
        <th>商品編號</th>
        <th>商品名稱</th>
        <th>單價</th>
        <th>購買數量</th>
    </tr>
    <?php
    $grand_total = 0;
    $row_count = 0;

    foreach ($_COOKIE as $id => $data_array) {
        // 判斷是否為商品資料的陣列
        if (is_array($data_array)) {
            // 簡單的交替顏色邏輯
            $bg_color = ($row_count % 2 == 0) ? "#F2F2F2" : "#FFFFFF";
            $row_count++;
            
            echo "<tr bgcolor='$bg_color' align='center'>";
            // 刪除按鈕
            echo "<td><a href='delete.php?Id=$id'>移除</a></td>";
            
            $item_price = 0;
            $item_qty = 0;
            
            // 輸出商品詳細資訊
            foreach ($data_array as $field => $content) {
                echo "<td>$content</td>";
                if ($field == "Price")    $item_price = $content;
                if ($field == "Quantity") $item_qty = $content;
            }
            
            $grand_total += ($item_price * $item_qty);
            echo "</tr>";
        }
    }
    ?>
    <tr>
        <td colspan="4" align="right"><strong>結帳總金額：</strong></td>
        <td align="center"><strong>$<?php echo $grand_total; ?></strong></td>
    </tr>
</table>

<br>
<nav>
    <a href="catalog.php">繼續購物</a> | 
    <a href="shoppingcart.php">重新整理</a>
</nav>

</body>
</html>