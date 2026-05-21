# A1133314＿蔣佩妏＿作業4

## 作業名稱
垃圾郵件寄送系統

## 使用方式
1. 開啟 XAMPP，啟動 Apache 與 MySQL。
2. 進入 phpMyAdmin，匯入 `mail.sql`。如果老師只要求簡易 SQL，也可以匯入 `database.sql`。
3. 將整個資料夾放到 XAMPP 的 `htdocs`。
4. 本作業已內附 PHPMailer，路徑為 `PHPMailer/src/PHPMailer.php`。
5. 到 `send.php` 修改自己的 Gmail 與 Gmail 應用程式密碼。
6. 瀏覽器開啟：

```text
http://localhost/A1133314＿蔣佩妏＿作業4/index.php
```

## 功能
- 可以輸入 Email 位址並存入 MySQL 資料庫。
- 資料庫欄位包含 `No` 與 `email`。
- 可以刪除單筆 Email。
- 可以選擇全部寄送或隨機寄送幾筆。
- 可以設定每封郵件寄送間隔秒數。
- 寄送時會顯示目前進度百分比與寄送紀錄。
- 包含基本郵件主旨與內容輸入介面。

## 檔案
- `index.php`：主畫面、資料庫新增/刪除、寄送設定與進度顯示。
- `send.php`：接收 AJAX 請求並執行寄送或模擬寄送。
- `mail.sql`：phpMyAdmin 匯出版 SQL。
- `database.sql`：簡易版 SQL。
- `PHPMailer`：Gmail SMTP 寄信用套件。

## 備註
`send.php` 使用 PHPMailer 和 Gmail SMTP 寄信。Gmail 不能直接填登入密碼，要到 Google 帳號產生「應用程式密碼」。請不要把真正密碼公開上傳到 GitHub。

## 上傳 GitHub 指令
先到 GitHub 建立一個新的 repository，名稱可以取：

```text
A1133314_homework4
```

接著在此資料夾開啟終端機，依序執行：

```bash
git init
git add .
git commit -m "add homework 4 mail system"
git branch -M main
git remote add origin https://github.com/你的帳號/A1133314_homework4.git
git push -u origin main
```
