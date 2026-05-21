<?php
header("Content-Type: application/json; charset=utf-8");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "請使用 POST 方式寄送資料"
    ]);
    exit;
}

$to = isset($_POST["to"]) ? trim($_POST["to"]) : "";
$subject = isset($_POST["subject"]) ? trim($_POST["subject"]) : "";
$content = isset($_POST["content"]) ? trim($_POST["content"]) : "";

$smtpAccount = "m7329377@gmail.com";
$smtpPassword = "tdpo foim gjto zvbw";
$senderName = "A1133314 Mailer";

if ($to == "" || $subject == "" || $content == "") {
    echo json_encode([
        "success" => false,
        "message" => "收件人、主旨、內容不可空白"
    ]);
    exit;
}

if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "message" => "收件人 Email 格式錯誤"
    ]);
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = $smtpAccount;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->CharSet = "UTF-8";

    $mail->setFrom($smtpAccount, $senderName);
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = nl2br(htmlspecialchars($content));
    $mail->AltBody = $content;

    $mail->send();

    echo json_encode([
        "success" => true,
        "message" => "寄送成功"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "寄送失敗：" . $mail->ErrorInfo
    ]);
}
?>
