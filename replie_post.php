<?php
    /*////////////////////////////////////////////////////////////////////////
    リプライポストページ
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


    //リプライ投稿//////////////////////////////////////////////////////////////////////////////////////////////////////

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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if (isset($_POST['ripuru'])) {
            $text = $_POST['text'];
            $day = date('Y-m-d H:i:s');
            $count = "0"; 
            $replie_id = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // セッションから post_id を取得
            $post_id = $_SESSION['post_id'];
            if(preg_match('/\A[\r\n\t[:^cntrl:]]{1,500}\z/u',$text) !==1){
                die('不正な文字が使用されています。');
            }else{
                // SQLインサート文の準備
                $stmt = $conn->prepare("INSERT INTO y_replie (user_name, day, text, icon, user_id, count, post_id, replie_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssiis", $username, $day, $text, $icon, $userid, $count, $post_id, $replie_id);
                
                // クエリ実行とエラーチェック
                if ($stmt->execute()) {
                    // 更新SQLの準備
                    $sql = "UPDATE y_main SET count_rep = count_rep + 1 WHERE post_id = ?";
                    $update_stmt = $conn->prepare($sql);
                    $update_stmt->bind_param("s", $post_id);

                    if ($update_stmt->execute()) {
                        echo "<script type='text/javascript'>
                                window.location.href = 'home.php';
                            </script>";
                    } else {
                        echo "エラー: " . htmlspecialchars($update_stmt->error);
                    }
                    $update_stmt->close();

                    
                } else {
                    echo "エラー: " . htmlspecialchars($stmt->error);
                }
                $stmt->close();
            }

            
        } else {
            //echo "'ripuru' が送信されていません。";
        }
        
    } else {
        echo "POSTリクエストではありません。";
    }
    

    $conn->close();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>リプライ / Y</title>
    <link rel="icon" href="images/icon.ico">
    <style>
        body {
    background-color: #c0dce7;
}
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        
        <textarea name="text" placeholder="リプライ" required rows="20" cols="40" maxlength="500"></textarea><br>
        <input type="submit" name="ripuru" value="リプる">
    </form>
    <button onclick="location.href='home.php'" >キャンセル</button>
    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</body>
</html>