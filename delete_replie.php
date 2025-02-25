<?php
    session_start();
    ini_set('display_errors', 0);
    if (isset($_SESSION['username'])) {
        //echo "ようこそ、" . htmlspecialchars($_SESSION['username']) . "さん！";
    } else {
        //echo "ゲストユーザー";
    }
    
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
    // ユーザーネームをセッションから変数に代入
    $username = htmlspecialchars($_SESSION['username']);

    // ユーザーIDを取得
    $stmt = $conn->prepare("SELECT userid FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $result = $stmt->get_result(); // 結果の取得

        if ($row = $result->fetch_assoc()) {
            $user_id = htmlspecialchars($row["userid"]); // ユーザーIDを変数に代入
        }
        $stmt->close(); // ステートメントを閉じる
    } else {
        //echo "ユーザーIDの取得に失敗しました。";
        $conn->close();
        exit();
    }

    // POSTリクエストで送信されたIDを取得
    if (isset($_POST['id'])) {
        $replie_id = intval($_POST['id']); // 整数に変換
    }

    // DELETEクエリを実行
    $sql = "DELETE FROM y_replie WHERE replie_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $replie_id, $user_id);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>
                            window.location.href = 'home.php';
                        </script>";
    } else {
        echo "削除に失敗しました。";
    }

    $stmt->close();
    $conn->close();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>さーくじょ!</title>
</head>
<body>
</body>
</html>