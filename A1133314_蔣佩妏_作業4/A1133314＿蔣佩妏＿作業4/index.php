<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$database = "homework4_mail";

$conn = @mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("資料庫連線失敗，請先匯入 database.sql 並確認 XAMPP 的 MySQL 已啟動。");
}
mysqli_set_charset($conn, "utf8mb4");

$notice = "";
if (isset($_SESSION["notice"])) {
    $notice = $_SESSION["notice"];
    unset($_SESSION["notice"]);
}

if (isset($_GET["delete"])) {
    $deleteNo = intval($_GET["delete"]);
    $stmt = mysqli_prepare($conn, "DELETE FROM mail_list WHERE No = ?");
    mysqli_stmt_bind_param($stmt, "i", $deleteNo);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION["notice"] = "<div class='msg ok'>已刪除該筆 Email。</div>";
    } else {
        $_SESSION["notice"] = "<div class='msg bad'>刪除失敗，請再試一次。</div>";
    }

    header("Location: index.php");
    exit;
}

if (isset($_POST["add_mail"])) {
    $email = trim($_POST["email"]);

    if ($email == "") {
        $_SESSION["notice"] = "<div class='msg bad'>Email 不可以空白。</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["notice"] = "<div class='msg bad'>Email 格式錯誤，請重新輸入。</div>";
    } else {
        $check = mysqli_prepare($conn, "SELECT No FROM mail_list WHERE email = ?");
        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $_SESSION["notice"] = "<div class='msg bad'>這個 Email 已經存在資料庫。</div>";
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO mail_list(email) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $email);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["notice"] = "<div class='msg ok'>新增成功：" . htmlspecialchars($email) . "</div>";
            } else {
                $_SESSION["notice"] = "<div class='msg bad'>新增失敗，請檢查資料表。</div>";
            }
        }
    }

    header("Location: index.php");
    exit;
}

$rows = [];
$emails = [];
$result = mysqli_query($conn, "SELECT No, email FROM mail_list ORDER BY No ASC");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
        $emails[] = $row["email"];
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>垃圾郵件寄送系統</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #edf1f7;
            color: #243044;
            font-family: "Microsoft JhengHei", Arial, sans-serif;
        }

        .wrap {
            width: min(880px, 92%);
            margin: 34px auto;
            background: #fff;
            border: 1px solid #dbe2ee;
            border-radius: 8px;
            box-shadow: 0 8px 22px rgba(36, 48, 68, .09);
            padding: 28px;
        }

        h1 {
            margin: 0 0 22px;
            text-align: center;
            color: #244b7a;
            letter-spacing: 0;
        }

        h2 {
            margin: 28px 0 14px;
            padding-left: 10px;
            border-left: 5px solid #4f83bd;
            font-size: 20px;
            color: #244b7a;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #bdc8d8;
            border-radius: 5px;
            font-size: 15px;
            font-family: inherit;
        }

        textarea {
            min-height: 118px;
            resize: vertical;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 120px;
            gap: 10px;
            align-items: end;
        }

        .field {
            margin-bottom: 15px;
        }

        button, .delete {
            border: 0;
            border-radius: 5px;
            padding: 10px 14px;
            cursor: pointer;
            font-weight: bold;
            font-family: inherit;
        }

        button {
            background: #34699a;
            color: white;
        }

        button:hover {
            background: #25537d;
        }

        button:disabled {
            background: #8fa0b4;
            cursor: not-allowed;
        }

        .delete {
            display: inline-block;
            background: #d64c4c;
            color: white;
            text-decoration: none;
            font-size: 13px;
            padding: 6px 10px;
        }

        .delete:hover {
            background: #b83939;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #d5deea;
            padding: 9px 10px;
            text-align: left;
        }

        th {
            background: #f3f6fa;
            color: #344767;
        }

        .empty {
            padding: 14px;
            background: #f6f8fb;
            border: 1px solid #dce3ee;
            color: #68778d;
            border-radius: 5px;
        }

        .msg {
            padding: 12px 14px;
            border-radius: 5px;
            margin-bottom: 18px;
            font-weight: bold;
        }

        .ok {
            background: #e0f4e8;
            color: #23613c;
            border: 1px solid #b7dfc4;
        }

        .bad {
            background: #fde7e7;
            color: #8d2b2b;
            border: 1px solid #efb7b7;
        }

        .grid2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .progress {
            display: none;
            height: 30px;
            background: #dfe6ef;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 16px;
        }

        .bar {
            height: 100%;
            width: 0%;
            background: #2f9d69;
            color: white;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            transition: width .25s;
        }

        .log {
            display: none;
            margin-top: 12px;
            background: #1f2937;
            color: #e5edf8;
            border-radius: 5px;
            padding: 12px;
            height: 150px;
            overflow-y: auto;
            font-family: Consolas, monospace;
            font-size: 13px;
            line-height: 1.7;
        }

        @media (max-width: 650px) {
            .wrap {
                padding: 18px;
            }

            .row, .grid2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="wrap">
        <h1>垃圾郵件寄送系統</h1>

        <?php echo $notice; ?>

        <h2>A. 建立 Email 資料庫</h2>
        <form method="post">
            <div class="row">
                <div class="field">
                    <label for="email">輸入 Email 位址</label>
                    <input type="text" id="email" name="email" placeholder="example@gmail.com">
                </div>
                <button type="submit" name="add_mail">加入資料庫</button>
            </div>
        </form>

        <?php if (count($rows) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 90px;">No.</th>
                        <th>Email</th>
                        <th style="width: 90px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["No"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td>
                                <a class="delete" href="index.php?delete=<?php echo $row["No"]; ?>" onclick="return confirm('確定刪除這筆資料嗎？')">刪除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">目前資料庫沒有 Email，請先新增收件人。</div>
        <?php endif; ?>

        <h2>B. 寄信設定</h2>
        <form id="sendForm">
            <div class="grid2">
                <div class="field">
                    <label for="sendMode">寄送方式</label>
                    <select id="sendMode">
                        <option value="all">全部寄送</option>
                        <option value="random">隨機寄送幾筆</option>
                    </select>
                </div>
                <div class="field" id="randomBox" style="display: none;">
                    <label for="randomCount">隨機筆數</label>
                    <input type="number" id="randomCount" min="1" value="2">
                </div>
            </div>

            <div class="grid2">
                <div class="field">
                    <label for="gapSecond">每封間隔秒數</label>
                    <input type="number" id="gapSecond" min="0" value="2">
                </div>
                <div class="field">
                    <label for="subject">郵件主旨</label>
                    <input type="text" id="subject" value="作業4測試郵件">
                </div>
            </div>

            <div class="field">
                <label for="mailBody">郵件內容</label>
                <textarea id="mailBody">您好，這是一封 PHP 課程作業的測試郵件。</textarea>
            </div>

            <button type="button" id="startBtn">開始寄送</button>
        </form>

        <div class="progress" id="progress">
            <div class="bar" id="bar">0%</div>
        </div>
        <div class="log" id="log"></div>
    </main>

    <script>
        const emailList = <?php echo json_encode($emails); ?>;
        const sendMode = document.getElementById("sendMode");
        const randomBox = document.getElementById("randomBox");
        const startBtn = document.getElementById("startBtn");
        const progress = document.getElementById("progress");
        const bar = document.getElementById("bar");
        const log = document.getElementById("log");

        sendMode.addEventListener("change", function () {
            randomBox.style.display = this.value === "random" ? "block" : "none";
        });

        function wait(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        function addLog(text, color) {
            const line = document.createElement("div");
            line.textContent = text;
            if (color) {
                line.style.color = color;
            }
            log.appendChild(line);
            log.scrollTop = log.scrollHeight;
        }

        function randomPick(list, count) {
            const copy = [...list];
            for (let i = copy.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [copy[i], copy[j]] = [copy[j], copy[i]];
            }
            return copy.slice(0, count);
        }

        startBtn.addEventListener("click", async function () {
            if (emailList.length === 0) {
                alert("資料庫目前沒有收件人，請先新增 Email。");
                return;
            }

            const subject = document.getElementById("subject").value.trim();
            const mailBody = document.getElementById("mailBody").value.trim();
            const gapSecond = Number(document.getElementById("gapSecond").value) || 0;

            if (subject === "" || mailBody === "") {
                alert("郵件主旨與內容都要填寫。");
                return;
            }

            let targets = [...emailList];
            if (sendMode.value === "random") {
                const randomCount = Number(document.getElementById("randomCount").value) || 1;
                targets = randomPick(targets, Math.min(randomCount, emailList.length));
            }

            startBtn.disabled = true;
            startBtn.textContent = "寄送中...";
            progress.style.display = "block";
            log.style.display = "block";
            log.innerHTML = "";
            bar.style.width = "0%";
            bar.textContent = "0%";

            addLog("本次準備寄送 " + targets.length + " 筆。");

            for (let i = 0; i < targets.length; i++) {
                addLog("正在寄送第 " + (i + 1) + " 封：" + targets[i]);

                const form = new FormData();
                form.append("to", targets[i]);
                form.append("subject", subject);
                form.append("content", mailBody);

                try {
                    const response = await fetch("send.php", {
                        method: "POST",
                        body: form
                    });
                    const data = await response.json();

                    if (data.success) {
                        addLog("寄送完成：" + targets[i], "#8ef0b2");
                    } else {
                        addLog("寄送失敗：" + data.message, "#ff9a9a");
                    }
                } catch (e) {
                    addLog("系統錯誤，無法連到 send.php。", "#ff9a9a");
                }

                const percent = Math.round(((i + 1) / targets.length) * 100);
                bar.style.width = percent + "%";
                bar.textContent = percent + "%";

                if (i < targets.length - 1 && gapSecond > 0) {
                    addLog("等待 " + gapSecond + " 秒後寄下一封。");
                    await wait(gapSecond * 1000);
                }
            }

            addLog("全部流程結束，進度 100%。");
            startBtn.disabled = false;
            startBtn.textContent = "開始寄送";
        });
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>
