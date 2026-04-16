<?php
session_start();

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: login.php");
    exit();
}

$id = trim($_POST["uID"] ?? "");
$pw = trim($_POST["uPWD"] ?? "");

$accounts = [
    "student" => "123456789",
    "teacher" => "123456",
    "admin"   => "123456"
];

if(array_key_exists($id, $accounts) && $accounts[$id] === $pw){

    $_SESSION["login"] = $id;

    setcookie("uName", $id, time() + 5*24*60*60,"/");

    $redirectPage = [
        "student" => "student.php",
        "teacher" => "teacher.php",
        "admin"   => "admin.php"
    ];

    header("Location: " . $redirectPage[$id]);
    exit();
}

echo "帳號或密碼錯誤，將返回登入頁...";
header("Refresh:2; url=login.php");
exit();
?>