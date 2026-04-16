<?php
$target_id = $_GET["Id"] ?? "";

if ($target_id && isset($_COOKIE[$target_id]) && is_array($_COOKIE[$target_id])) {
    foreach ($_COOKIE[$target_id] as $item_key => $item_value) {
        setcookie($target_id . "[$item_key]", "", time() - 3600);
    }
}

header("Location: shoppingcart.php");
exit();
?>