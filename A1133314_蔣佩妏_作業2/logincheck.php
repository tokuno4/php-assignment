<?php
session_start();

$user = $_POST["username"];
$pass = $_POST["password"];

if ($user == "student" && $pass == "1234") {
    $_SESSION["login"] = true;
    header("Location: form.php");
} else {
    header("Location: login.php?error=1");
}
?>