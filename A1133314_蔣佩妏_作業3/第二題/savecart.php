<?php
session_start();

if (isset($_SESSION["ID"])) {
    $p_id = $_SESSION["ID"];
    $p_name = $_SESSION["Name"];
    $p_price = $_SESSION["Price"];
    $p_qty = $_SESSION["Quantity"];
    
    $expire_time = time() + 3600;

    setcookie($p_id . "[ID]", $p_id, $expire_time);
    setcookie($p_id . "[Name]", $p_name, $expire_time);
    setcookie($p_id . "[Price]", $p_price, $expire_time);
    setcookie($p_id . "[Quantity]", $p_qty, $expire_time);
}

header("Location: shoppingcart.php");
exit();
?>