<?php
session_start();

if (isset($_POST["Item"])) {
    $prod_id = $_POST["Item"]; 
    $amount = $_POST["Quantity"]; 
    
    $_SESSION["ID"] = $prod_id;
    $_SESSION["Quantity"] = $amount;

    switch (strtoupper($prod_id)) {
        case "S001":
            $_SESSION["Name"] = "10吋平板電腦";
            $_SESSION["Price"] = 12000;
            break;
        case "S002":
            $_SESSION["Name"] = "15.6吋筆記型電腦";
            $_SESSION["Price"] = 27000;
            break;
        case "S003":
            $_SESSION["Name"] = "iPhone智慧型手機";
            $_SESSION["Price"] = 21000;
            break;
        default:
            break;
    }
    
    header("Location: savecart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的商品清單</title>
</head>
<body>

<h2>商品選購目錄</h2>

<form action="" method="post">
    <label for="Item">選擇產品：</label>
    <select name="Item" id="Item">
        <option value="S001">10吋平板電腦 - $12000</option>
        <option value="S002">15.6吋筆記型電腦 - $27000</option>
        <option value="S003">iPhone智慧型手機 - $21000</option>
    </select>
    <br><br>
    購買數量: 
    <input type="number" name="Quantity" value="1" min="1" style="width: 50px;" required>
    <input type="submit" value="加入購物車">
</form>

<hr>
<p>
    <a href="shoppingcart.php">前往查看購物車內容</a>
</p>

</body>
</html>