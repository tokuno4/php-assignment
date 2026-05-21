<?php
session_start();

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "a1133314_postbox";

$db = @mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$db) {
    die("無法連線資料庫，請先在 phpMyAdmin 匯入 mail.sql，並確認 MySQL 已啟動。");
}
mysqli_set_charset($db, "utf8mb4");

$flash = "";
if (!empty($_SESSION["flash"])) {
    $flash = $_SESSION["flash"];
    unset($_SESSION["flash"]);
}

function backHome()
{
    header("Location: index.php");
    exit;
}

if (isset($_GET["remove"])) {
    $no = intval($_GET["remove"]);
    $deleteSql = mysqli_prepare($db, "DELETE FROM recipient_book WHERE No = ?");
    mysqli_stmt_bind_param($deleteSql, "i", $no);

    $_SESSION["flash"] = mysqli_stmt_execute($deleteSql)
        ? "<div class='notice success'>名單已移除。</div>"
        : "<div class='notice error'>刪除失敗，請重新操作。</div>";
    backHome();
}

if (isset($_POST["create_recipient"])) {
    $newMail = trim($_POST["new_mail"] ?? "");

    if ($newMail === "") {
        $_SESSION["flash"] = "<div class='notice error'>請輸入 Email 位址。</div>";
        backHome();
    }

    if (!filter_var($newMail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["flash"] = "<div class='notice error'>Email 格式不正確。</div>";
        backHome();
    }

    $existSql = mysqli_prepare($db, "SELECT No FROM recipient_book WHERE email = ?");
    mysqli_stmt_bind_param($existSql, "s", $newMail);
    mysqli_stmt_execute($existSql);
    mysqli_stmt_store_result($existSql);

    if (mysqli_stmt_num_rows($existSql) > 0) {
        $_SESSION["flash"] = "<div class='notice error'>此 Email 已經在名單中。</div>";
        backHome();
    }

    $insertSql = mysqli_prepare($db, "INSERT INTO recipient_book (email) VALUES (?)");
    mysqli_stmt_bind_param($insertSql, "s", $newMail);
    $_SESSION["flash"] = mysqli_stmt_execute($insertSql)
        ? "<div class='notice success'>已加入：" . htmlspecialchars($newMail) . "</div>"
        : "<div class='notice error'>新增失敗，請檢查資料表設定。</div>";
    backHome();
}

$recipients = [];
$recipientEmails = [];
$listResult = mysqli_query($db, "SELECT No, email FROM recipient_book ORDER BY No DESC");
if ($listResult) {
    while ($item = mysqli_fetch_assoc($listResult)) {
        $recipients[] = $item;
        $recipientEmails[] = $item["email"];
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A1133314 郵件群發作業</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f6f3ec;
            color: #263238;
            font-family: "Microsoft JhengHei", Arial, sans-serif;
        }

        .page {
            width: min(1060px, 94vw);
            margin: 28px auto;
        }

        .titlebar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            padding: 22px 4px;
            border-bottom: 3px solid #2b5967;
        }

        h1 {
            margin: 0;
            color: #224852;
            font-size: 30px;
        }

        .sub {
            margin: 8px 0 0;
            color: #68736f;
            font-size: 14px;
        }

        .countBox {
            min-width: 135px;
            padding: 12px 16px;
            background: #2b5967;
            color: white;
            text-align: center;
            border-radius: 6px;
        }

        .countBox strong {
            display: block;
            font-size: 28px;
        }

        .layout {
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 18px;
            margin-top: 20px;
            align-items: start;
        }

        .panel {
            background: white;
            border: 1px solid #ded6c9;
            border-radius: 6px;
            padding: 20px;
        }

        h2 {
            margin: 0 0 16px;
            color: #2b5967;
            font-size: 20px;
        }

        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: bold;
            color: #344144;
        }

        input, select, textarea {
            width: 100%;
            border: 1px solid #b9c1bc;
            border-radius: 4px;
            padding: 10px;
            font-size: 15px;
            font-family: inherit;
            background: #fff;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .inlineForm {
            display: grid;
            grid-template-columns: 1fr 112px;
            gap: 10px;
        }

        .twoCol {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        button, .removeBtn {
            border: 0;
            border-radius: 4px;
            padding: 10px 13px;
            font-weight: bold;
            cursor: pointer;
            font-family: inherit;
        }

        button {
            background: #c66b3d;
            color: #fff;
        }

        button:hover {
            background: #a9552e;
        }

        button:disabled {
            background: #a9a49a;
            cursor: wait;
        }

        .removeBtn {
            background: #efeee9;
            color: #8a312b;
            text-decoration: none;
            display: inline-block;
            padding: 6px 9px;
            font-size: 13px;
        }

        .notice {
            margin: 16px 0 0;
            padding: 11px 13px;
            border-radius: 4px;
            font-weight: bold;
        }

        .success {
            background: #e2f2e4;
            color: #25633a;
            border: 1px solid #b9dcbf;
        }

        .error {
            background: #f9e3de;
            color: #8f3528;
            border: 1px solid #e8b9af;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
            font-size: 14px;
        }

        th {
            background: #f0eee7;
            color: #334044;
        }

        th, td {
            border-bottom: 1px solid #e2ddd3;
            padding: 10px 8px;
            text-align: left;
        }

        .emptyText {
            margin-top: 14px;
            padding: 14px;
            background: #f8f7f2;
            border: 1px dashed #c7bfae;
            color: #71685c;
        }

        .meter {
            display: none;
            margin-top: 16px;
            height: 34px;
            background: #e0ded5;
            border-radius: 4px;
            overflow: hidden;
        }

        .meterFill {
            width: 0;
            height: 100%;
            background: #2b5967;
            color: white;
            line-height: 34px;
            text-align: center;
            font-weight: bold;
            transition: width .2s;
        }

        .console {
            display: none;
            height: 168px;
            overflow-y: auto;
            margin-top: 12px;
            padding: 12px;
            background: #263238;
            color: #f6f3ec;
            border-radius: 4px;
            font-size: 13px;
            line-height: 1.65;
            font-family: Consolas, monospace;
        }

        @media (max-width: 780px) {
            .titlebar, .layout, .twoCol, .inlineForm {
                display: block;
            }

            .countBox {
                margin-top: 14px;
            }

            button {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <header class="titlebar">
            <div>
                <h1>郵件名單與排程中心</h1>
                <p class="sub">A1133314 蔣佩妏 - 作業4</p>
            </div>
            <div class="countBox">
                <span>目前名單</span>
                <strong><?php echo count($recipients); ?></strong>
            </div>
        </header>

        <?php echo $flash; ?>

        <div class="layout">
            <section class="panel">
                <h2>收件人資料庫</h2>
                <form method="post" class="inlineForm">
                    <div>
                        <label for="new_mail">新增 Email</label>
                        <input type="text" id="new_mail" name="new_mail" placeholder="name@example.com">
                    </div>
                    <button type="submit" name="create_recipient">加入</button>
                </form>

                <?php if (count($recipients) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 70px;">No.</th>
                                <th>Email</th>
                                <th style="width: 76px;">管理</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recipients as $person): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($person["No"]); ?></td>
                                    <td><?php echo htmlspecialchars($person["email"]); ?></td>
                                    <td>
                                        <a class="removeBtn" href="index.php?remove=<?php echo $person["No"]; ?>" onclick="return confirm('要移除這筆 Email 嗎？')">移除</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="emptyText">尚未建立收件人資料，請先新增 Email。</div>
                <?php endif; ?>
            </section>

            <section class="panel">
                <h2>寄送排程設定</h2>
                <form id="deliveryForm">
                    <div class="twoCol">
                        <div>
                            <label for="dispatchScope">寄送範圍</label>
                            <select id="dispatchScope">
                                <option value="all">寄送給全部名單</option>
                                <option value="sample">從名單隨機抽幾筆</option>
                            </select>
                        </div>
                        <div id="sampleBox" style="display:none;">
                            <label for="sampleSize">隨機抽取筆數</label>
                            <input type="number" id="sampleSize" min="1" value="2">
                        </div>
                    </div>

                    <div class="twoCol">
                        <div>
                            <label for="pauseSec">每封間隔秒數</label>
                            <input type="number" id="pauseSec" min="0" value="2">
                        </div>
                        <div>
                            <label for="mailTitle">信件主旨</label>
                            <input type="text" id="mailTitle" value="A1133314 作業4測試信">
                        </div>
                    </div>

                    <label for="mailText">信件內容</label>
                    <textarea id="mailText">您好，這是郵件寄送系統的課堂作業測試內容。</textarea>

                    <button type="button" id="runBtn">執行寄送</button>
                </form>

                <div class="meter" id="meter">
                    <div class="meterFill" id="meterFill">0%</div>
                </div>
                <div class="console" id="consoleBox"></div>
            </section>
        </div>
    </div>

    <script>
        const savedEmails = <?php echo json_encode($recipientEmails); ?>;
        const dispatchScope = document.getElementById("dispatchScope");
        const sampleBox = document.getElementById("sampleBox");
        const runBtn = document.getElementById("runBtn");
        const meter = document.getElementById("meter");
        const meterFill = document.getElementById("meterFill");
        const consoleBox = document.getElementById("consoleBox");

        dispatchScope.addEventListener("change", () => {
            sampleBox.style.display = dispatchScope.value === "sample" ? "block" : "none";
        });

        const delay = seconds => new Promise(resolve => setTimeout(resolve, seconds * 1000));

        function writeLine(text, color = "") {
            const row = document.createElement("div");
            row.textContent = text;
            if (color !== "") {
                row.style.color = color;
            }
            consoleBox.appendChild(row);
            consoleBox.scrollTop = consoleBox.scrollHeight;
        }

        function drawLots(list, amount) {
            const pool = [...list];
            const chosen = [];
            while (pool.length > 0 && chosen.length < amount) {
                const index = Math.floor(Math.random() * pool.length);
                chosen.push(pool.splice(index, 1)[0]);
            }
            return chosen;
        }

        runBtn.addEventListener("click", async () => {
            if (savedEmails.length === 0) {
                alert("資料庫尚未建立收件人。");
                return;
            }

            const title = document.getElementById("mailTitle").value.trim();
            const message = document.getElementById("mailText").value.trim();
            const pauseSec = Math.max(0, Number(document.getElementById("pauseSec").value) || 0);

            if (title === "" || message === "") {
                alert("主旨和內容都必須填寫。");
                return;
            }

            let queue = [...savedEmails];
            if (dispatchScope.value === "sample") {
                const amount = Math.max(1, Number(document.getElementById("sampleSize").value) || 1);
                queue = drawLots(savedEmails, Math.min(amount, savedEmails.length));
            }

            runBtn.disabled = true;
            runBtn.textContent = "處理中";
            meter.style.display = "block";
            consoleBox.style.display = "block";
            consoleBox.innerHTML = "";
            meterFill.style.width = "0%";
            meterFill.textContent = "0%";

            writeLine("建立寄送佇列，共 " + queue.length + " 筆。");

            for (let i = 0; i < queue.length; i++) {
                const recipient = queue[i];
                writeLine("第 " + (i + 1) + " 筆送出：" + recipient);

                const packet = new FormData();
                packet.append("recipient", recipient);
                packet.append("title", title);
                packet.append("message", message);

                try {
                    const res = await fetch("send.php", {
                        method: "POST",
                        body: packet
                    });
                    const data = await res.json();

                    if (data.status === "sent") {
                        writeLine("完成：" + recipient, "#9df0b2");
                    } else {
                        writeLine("失敗：" + data.detail, "#ffaaa0");
                    }
                } catch (error) {
                    writeLine("無法連線至 send.php。", "#ffaaa0");
                }

                const percent = Math.round(((i + 1) / queue.length) * 100);
                meterFill.style.width = percent + "%";
                meterFill.textContent = percent + "%";

                if (i < queue.length - 1 && pauseSec > 0) {
                    writeLine("暫停 " + pauseSec + " 秒。");
                    await delay(pauseSec);
                }
            }

            writeLine("寄送流程完成。");
            runBtn.disabled = false;
            runBtn.textContent = "執行寄送";
        });
    </script>
</body>
</html>
<?php mysqli_close($db); ?>
