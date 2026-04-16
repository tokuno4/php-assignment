<?php
setcookie("uName", "", time() - 3600,"/");
echo "<h3>Cookie 已成功清除</h3>";
header("Refresh:2; url=login.php");
exit();
?>