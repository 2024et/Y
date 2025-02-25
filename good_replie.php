<?php
//リプライに対するいいね機能
    ini_set('display_errors', 0);

    // MySQL接続設定
    $servername = "host-name";
    $username = "user-name";
    $password = "password";
    $dbname = "database-name";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("接続失敗: " . $conn->connect_error);
    }
    //いいねボタンが押されたリプライのIDを取得し実行する。
    if (isset($_POST['id'])) {
        $replie_id = $_POST['id'];

        
        $sql = "UPDATE y_replie SET count = count + 1 WHERE replie_id = ?";
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