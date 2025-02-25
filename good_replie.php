<?php
    ini_set('display_errors', 0);

    // MySQL接続設定
    $servername = "mysql309.phy.lolipop.lan";
    $username = "LAA1616860";
    $password = "20051022";
    $dbname = "LAA1616860-yserver";

    // 接続を試みる
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("接続失敗: " . $conn->connect_error);
    }
    // POSTリクエストで送信されたIDを取得
    if (isset($_POST['id'])) {
        $replie_id = $_POST['id'];

        
        $sql = "UPDATE y_replie SET count = count + 1 WHERE replie_id = ?";

        // プリペアドステートメントを使ったセキュリティ対策
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $replie_id);

        if ($stmt->execute()) {
        } else {
        }

        $stmt->close();
    }
    $conn->close();
    header("Location: home.php");
    exit();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>いいね!</title>
</head>
<body>
    
</body>
</html>