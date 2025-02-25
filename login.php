<?php
//ログインページ
session_start(); 
//トークンを生成しログイン後のhomeページアクセス時にセッション変数と比較させることで、セッションID固定化攻撃を防止する。
function getToken(){
    $s = openssl_random_pseudo_bytes(24);
    return base64_encode($s);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    // MySQL接続設定
    $servername = "host-name";
    $user_name = "user-name";
    $password = "password";
    $dbname = "database-name";

    $conn = new mysqli($servername, $user_name, $password, $dbname);
    if ($conn->connect_error) {
        die("接続失敗: " . $conn->connect_error);
    }

    //ユーザーが入力した文字列に対して入力検証を実施し不正入力によるSQLインジェクション等の防止を図る。

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($pass, $row['password'])) {
            $token = getToken();
            setcookie('token',$token);
            $_SESSION['token'] = $token;
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = htmlspecialchars($row["userid"]); 

            header("Location: home.php");
            exit;

        } else {
            $error = "パスワードが異なります。";
        }
    } else {
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
