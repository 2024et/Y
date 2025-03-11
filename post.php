<?php
    /*////////////////////////////////////////////////////////////////////////
    ポストページ
    /////////////////////////////////////////////////////////////////////////*/
session_start();
ini_set('display_errors', 0);
// セッション変数にアクセス
if (isset($_SESSION['username'])) {
    echo "ようこそ、" . htmlspecialchars($_SESSION['username']) . "さん！";
} else {
    echo "<script type='text/javascript'>
            window.location.href = 'login.php';
        </script>";
}



// MySQL接続設定
$servername = "host-name";
$username = "user-name";
$password = "password";
$dbname = "database-name";

// 接続を試みる
$conn = new mysqli($servername, $user_name, $password, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

    //ユーザーネームを変数に代入
    $username = htmlspecialchars($_SESSION['username']);
    // ユーザーIDとアイコンの取得
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $result = $stmt->get_result(); // 結果の取得

        if ($row = $result->fetch_assoc()) {
            $userid = htmlspecialchars($row["userid"]);
            $icon = htmlspecialchars($row["icon"]);
        }
    }
    echo "<br>ユーザーネーム：".$username;
    echo "　　ユーザーID：@".$userid;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
        //ユーザーネームはセッションから
        //ユーザーidはdbから
        $text = $_POST['text'];
        //アイコンはdbから
        $day = date('Y-m-d H:i:s');
        $count = "0";
        $post_id = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        if(preg_match('/\A[\r\n\t[:^cntrl:]]{1,500}\z/u',$text) !==1){
            die('不正な文字が使用されています。');
        }else{
            if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                $targetDir = "images/";
                $fileName = uniqid() . "_" . basename($_FILES["file"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
                
                if (in_array($fileType, $allowedFileTypes)) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                        // データベースに画像付きの投稿を登録
                        $stmt = $conn->prepare("INSERT INTO y_main (user_name, day, text, icon, user_id, count, post_id, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("ssssssss", $username,  $day,  $text, $icon, $userid, $count, $post_id, $fileName);
                        
                        if ($stmt->execute()) {
                            echo "<script type='text/javascript'>window.location.href = 'home.php';</script>";
                        } else {
                            echo "エラーが発生しました。";
                        }
                    }
                }
            } else {
                // 画像がアップロードされなかった場合、pictureにNULLを挿入
                $stmt = $conn->prepare("INSERT INTO y_main (user_name, day, text, icon, user_id, count, post_id, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $nullValue = null;
                $stmt->bind_param("ssssssss", $username,  $day,  $text, $icon, $userid, $count, $post_id, $nullValue);
                
                if ($stmt->execute()) {
                    echo "<script type='text/javascript'>window.location.href = 'home.php';</script>";
                } else {
                    echo "エラーが発生しました。";
                }
            }
            $stmt->close();
        }

    
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST / Y</title>
    <link rel="icon" href="images/icon.ico">
    <style>
        body {
    background-color: #c0dce7;
}
    </style>
</head>
<body>
    
    <form action="" method="post" enctype="multipart/form-data">
        <textarea name="text" placeholder="いまどうしてる？" required rows="20" cols="40" maxlength="500"></textarea><br>
        <label for="file">写真送信(jpg,jpeg,png,gifに対応)は1投稿につき1つまで(任意):</label><br>
        <input type="file" id="file" name="file"><br><br>
        <input type="submit" name="register" value="投稿する">
    </form>
    <button onclick="location.href='home.php'" >キャンセル</button>
    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</body>
</html>