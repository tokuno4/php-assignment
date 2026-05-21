<?php
header("Content-Type: application/json; charset=utf-8");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/PHPMailer/src/Exception.php";
require_once __DIR__ . "/PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "/PHPMailer/src/SMTP.php";

function finish($status, $detail)
{
    echo json_encode([
        "status" => $status,
        "detail" => $detail
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    finish("error", "請從表單送出資料。");
}

$recipient = trim($_POST["recipient"] ?? "");
$title = trim($_POST["title"] ?? "");
$message = trim($_POST["message"] ?? "");

// 上傳 GitHub 前不要放真實密碼。展示時再改成自己的 Gmail 應用程式密碼。
$gmailAddress = "your_account@gmail.com";
$gmailAppPassword = "your app password";
$senderLabel = "A1133314 Homework Mail";

if ($recipient === "" || $title === "" || $message === "") {
    finish("error", "收件人、主旨、內容不可空白。");
}

if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
    finish("error", "收件人 Email 格式錯誤。");
}

$notConfigured = $gmailAddress === "your_account@gmail.com" || $gmailAppPassword === "your app password";
if ($notConfigured) {
    usleep(250000);
    finish("sent", "未設定 Gmail，已使用展示模式完成。");
}

$mailer = new PHPMailer(true);

try {
    $mailer->isSMTP();
    $mailer->Host = "smtp.gmail.com";
    $mailer->SMTPAuth = true;
    $mailer->Username = $gmailAddress;
    $mailer->Password = $gmailAppPassword;
    $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Port = 587;
    $mailer->CharSet = "UTF-8";

    $mailer->setFrom($gmailAddress, $senderLabel);
    $mailer->addAddress($recipient);
    $mailer->isHTML(true);
    $mailer->Subject = $title;
    $mailer->Body = nl2br(htmlspecialchars($message));
    $mailer->AltBody = $message;
    $mailer->send();

    finish("sent", "寄送成功。");
} catch (Exception $e) {
    finish("error", "SMTP 錯誤：" . $mailer->ErrorInfo);
}
?>
