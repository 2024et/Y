<?php
session_start(); // セッションを開始
ini_set('display_errors', 0);
function getToken(){
    $s = openssl_random_pseudo_bytes(24);
    return base64_encode($s);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    // MySQL接続設定
    $servername = "mysql309.phy.lolipop.lan";
    $user_name = "LAA1616860";
    $password = "20051022";
    $dbname = "LAA1616860-yserver";

    // 接続を試みる
    $conn = new mysqli($servername, $user_name, $password, $dbname);
    if ($conn->connect_error) {
        die("接続失敗: " . $conn->connect_error);
    }

    // ユーザー入力のサニタイズ
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $pass = $_POST['pass'];

    // SQLインジェクションを防ぐためにプリペアドステートメントを使用
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // 結果が存在するか確認
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // パスワードの検証
        if (password_verify($pass, $row['password'])) {
            $token = getToken();
            setcookie('token',$token);
            $_SESSION['token'] = $token;
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = htmlspecialchars($row["userid"]); // セッションにユーザーidを保存

            echo "<script type='text/javascript'>
                            window.location.href = 'home.php';
                        </script>";
        } else {
            // パスワードが一致しない場合の処理
            $error = "パスワードが異なります。";
        }
    } else {
        // ユーザー名が存在しない場合の処理
        $error = "ログインIDが異なります。";
    }

}
    ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.ico">
    <title>Y/ログイン</title>
    <style type="text/css">
        #roguinsuru {
            display       : inline-block;
            border-radius : 5%;
            font-size     : 16pt;
            text-align    : center;
            cursor        : pointer;
            padding       : 12px 12px;
            background    : #6666ff;
            color         : #ffffff;
            line-height   : 1em;
            transition    : .3s;
            border        : 2px solid #6666ff;
        }
        #roguinsuru:hover {
            color         : #6666ff;
            background    : #ffffff;
        }

        #sinki {
            display       : inline-block;
            border-radius : 5%;
            font-size     : 16pt;
            text-align    : center;
            cursor        : pointer;
            padding       : 12px 12px;
            background    : #ffffff;
            color         : #6666ff;
            line-height   : 1em;
            transition    : .3s;
            border        : 2px solid #ffffff;
        }
        #sinki:hover {
            color         : #ffffff;
            background    : #6666ff;
        }
        .box{
            text-align: center;
        }
    </style>
</head>
<body>
    
    
    <div class="box">
        <h2>ログイン</h2>
        <form action="" method="post">
            <label for="username">ユーザー名:</label><br>
            <input type="text" name="username" id="username" required maxlength="30"><br><br>
            <label for="pass">パスワード:</label><br>
            <input type="password" name="pass" required maxlength="16"><br><br>
            <input type="submit" name="submit" id="roguinsuru" value="ログインする"><br>
        </form>
        <a href="login_touroku.php" id="sinki">&emsp;新規登録&emsp;</a>
        
    </div>

    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</body>
</html>
