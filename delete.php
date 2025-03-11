<?php
    /*////////////////////////////////////////////////////////////////////////
    本投稿に対する削除機能
    /////////////////////////////////////////////////////////////////////////*/
    session_start();
    ini_set('display_errors', 0);
   //ユーザーのログイン状況を判別することで、ゲストユーザーによるリプライの削除を防止する。
   if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    } else {
        header("Location: login.php"); exit;
    }

    
    // MySQL接続設定
    $servername = "host-name";
    $username = "user-name";
    $password = "password";
    $dbname = "database-name";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("接続失敗: " . $conn->connect_error);
    }

    //ユーザーネームからユーザーIDを取得し、投稿者本人が操作しているかを判断する。
    //このようにすることで、別ユーザーが投稿を削除するのを防止する。
    $stmt = $conn->prepare("SELECT userid FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $result = $stmt->get_result(); // 結果の取得

        if ($row = $result->fetch_assoc()) {
            $user_id = htmlspecialchars($row["userid"]); 
        }
        $stmt->close(); 
    } else {
        $conn->close();
        exit();
    }

    //削除ボタンが押されたポストIDを取得し削除する。
    if (isset($_POST['id'])) {
        $post_id = intval($_POST['id']); 
    }

    $sql = "DELETE FROM y_main WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $post_id, $user_id);

    if ($stmt->execute()) {
        header("Location: home.php"); 
        exit();
    } else {
        echo "削除に失敗しました。";
    }

    $stmt->close();
    $conn->close();
    ?>