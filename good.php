<?php
    /*////////////////////////////////////////////////////////////////////////
    本投稿に対するいいね機能
    /////////////////////////////////////////////////////////////////////////*/
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
    //いいねボタンが押された投稿のIDを取得し実行する。
    if (isset($_POST['id'])) {
        $post_id = $_POST['id'];

        
        $sql = "UPDATE y_main SET count = count + 1 WHERE post_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);

        if ($stmt->execute()) {
        } else {
        }

        $stmt->close();
    }
    $conn->close();
    header("Location: home.php");
    exit();
    ?>