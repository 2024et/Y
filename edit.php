<?php
session_start();

if (isset($_SESSION['username'])) {
    // ユーザー名のサニタイズと表示
    echo '<input type="button" class="back" onclick="history.back()" value="戻る">';
    echo "ようこそ、" . htmlspecialchars($_SESSION['username']) . "さん！";
} else {
    echo "<script type='text/javascript'>
            window.location.href = 'login.php';
        </script>";
}

ini_set('display_errors', 0);


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

// セッションからユーザー名を取得
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if ($username) {
    // SQLインジェクションを防ぐためにプリペアドステートメントを使用
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // 結果が存在するか確認
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = htmlspecialchars($row["userid"], ENT_QUOTES, 'UTF-8');

        // パスワードの検証
        

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['re'])) {
                $newusername = isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : '';
                $profile = isset($_POST['profile']) ? htmlspecialchars($_POST['profile'], ENT_QUOTES, 'UTF-8') : '';
                //$file = isset($_POST['file']) ? htmlspecialchars($_POST['file'], ENT_QUOTES, 'UTF-8') : '';
                $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
                if (password_verify($pass, $row['password'])) {

                    // ユーザーネームの変更
                    if (!empty($newusername)) {
                        $stmt = $conn->prepare("UPDATE login SET username = ? WHERE userid = ?");
                        $stmt->bind_param("ss", $newusername, $user_id);
                        if ($stmt->execute()) {
                            echo "ユーザーネームが変更されました。<br>";
                            echo "<script type='text/javascript'>
                            window.location.href = 'home.php';
                        </script>";
                        } else {
                            echo "エラー: " . $stmt->error;
                        }
                    }

                    // プロフィールの変更
                    if (!empty($profile)) {
                        $stmt = $conn->prepare("UPDATE login SET profile = ? WHERE userid = ?");
                        $stmt->bind_param("ss", $profile, $user_id);
                        if ($stmt->execute()) {
                            echo "プロフィールが変更されました。<br>";
                            echo "<script type='text/javascript'>
                            window.location.href = 'home.php';
                        </script>";
                        } else {
                            echo "エラー: " . $stmt->error;
                        }
                    }

                    // アイコン画像の変更

                    if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                        $targetDir = "images/";
                        $fileName = uniqid() . "_" . basename($_FILES["file"]["name"]); // ユニークなファイル名
                        $targetFilePath = $targetDir . $fileName;
                        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
                        
                        // ファイルタイプのチェック
                        if (in_array($fileType, $allowedFileTypes)) {
                            // ファイル移動処理
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    
                                // SQL準備と実行
                                $stmt = $conn->prepare("UPDATE login SET icon = ? WHERE userid = ?");
                                $stmt->bind_param("ss", $fileName, $user_id);
                    
                                if ($stmt->execute()) {
                                    echo "アイコン画像が更新されました。";
                                    echo "<script type='text/javascript'>
                            window.location.href = 'home.php';
                        </script>";
                                } else {
                                    echo "登録に失敗しました: " . $stmt->error;
                                }
                            } else {
                                echo "ファイルのアップロードに失敗しました。";
                            }
                        } else {
                            echo "許可されていないファイル形式です。";
                        }
                    } else {
                        echo "ファイルが選択されていないか、アップロードに問題があります。";
                        echo "ファイルアップロードエラー: " . $_FILES["file"]["error"];
                    }
                    
                }
            }
        
    } else {
        echo "ユーザーが見つかりません。";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ユーザー名が設定されていません。";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィールの編集</title>
    <link rel="icon" href="images/icon.ico">
    <style>
        .back {
        display       : inline-block;
        font-size     : 14pt;        /* 文字サイズ */
        text-align    : center;      /* 文字位置   */
        cursor        : pointer;     /* カーソル   */
        padding       : 12px 12px;   /* 余白       */
        background    : #ffffff;     /* 背景色     */
        color         : #000000;     /* 文字色     */
        line-height   : 1em;         /* 1行の高さ  */
        opacity       : 1;           /* 透明度     */
        transition    : .3s;         /* なめらか変化 */
        box-shadow    : 1px 1px 3px #666666;  /* 影の設定 */
        }
        .back:hover {
        box-shadow    : none;        /* カーソル時の影消去 */
        opacity       : 0.8;         /* カーソル時透明度 */
        }
    </style>
</head>
<body>
    <p>注意！過去に投稿したものは更新されません。</p>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="username">ユーザーネーム(過去に投稿した名前は変わりません。):</label><br>
        <input type="text" id="username" name="username" maxlength="30"><br><br>

        <label for="profile">プロフィール:</label><br>
        <input type="text" id="profile" name="profile" maxlength="200" ><br><br>

        <label for="file">アイコン画像:</label><br>
        <input type="file" id="file" name="file"><br><br>

        <label for="pass">パスワード*:</label><br>
        <input type="password" id="pass" name="pass" required password="16"><br><br>

        <input type="submit" name="re" value="保存">

    </form>
    <button onclick="location.href='home.php'" >キャンセル</button>

    <p>注意！過去に投稿したものは更新されません。</p>
    
    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</body>
</html>