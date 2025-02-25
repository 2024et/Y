<?php
//本投稿に対する編集機能
    session_start();
    ini_set('display_errors', 0);
    if (!empty($_SESSION['username'])) {
        echo "ようこそ、" . htmlspecialchars($_SESSION['username']) . "さん！";
        $username = $_SESSION['username'];
    } else {
        header("Location: login.php"); exit;
    }

    // MySQL接続設定
    $servername = "host-name";
    $user_name = "user-name";
    $password = "password";
    $dbname = "database-name";

    $conn = new mysqli($servername, $user_name, $password, $dbname);
    if ($conn->connect_error) {
        die("接続失敗: " . $conn->connect_error);
    }

    //ユーザーネームからユーザーIDを取得し、投稿者本人が操作しているかを判断する。
    //このようにすることで、別ユーザーが投稿を編集するのを防止する。
    $stmt = $conn->prepare("SELECT userid FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $result = $stmt->get_result(); 

        if ($row = $result->fetch_assoc()) {
            $user_id = htmlspecialchars($row["userid"]);
        }
        $stmt->close(); 
    } else {
        $conn->close();
        exit();
    }

    

    //編集ボタンが押されたポストIDを取得し編集する。
    if (isset($_POST['id'])) {
        $post_id = $_POST['id'];

        //更新前の投稿内容を取得し表示
        $stmt = $conn->prepare("SELECT * FROM y_main WHERE post_id = ?");
        $stmt->bind_param("s", $post_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result(); 

            if ($row = $result->fetch_assoc()) {
                echo "<br>編集前：".htmlspecialchars($row["text"]);
            }else {
                echo "この投稿はすでに削除されているかデータが壊れています。";
            }
        } 

        //更新ボタンが押され内容を更新する。
        //編集されたかどうかを確認するため投稿内容の最後に(編集済)を入れ、後から編集が加えられた投稿であることを明確にする。
        //投稿内容については、ヌルバイト攻撃等による制御文字の混入防止のため正規表現による検証を実施する。
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            
            $text = htmlspecialchars($_POST['text']) . "(編集済)";
            if(preg_match('/\A[\r\n\t[:^cntrl:]]{1,500}\z/u',$text) !==1){
                die('不正な文字が使用されています。');
            }else{
                $stmt = $conn->prepare("UPDATE y_main SET text = ? WHERE post_id = ? AND user_id = ?");
                $stmt->bind_param("sss", $text, $post_id, $user_id);

                if ($stmt->execute()) {

                    header("Location: home.php"); 
                    exit;
                } else {
                    error_log("SQL エラー: " . $stmt->error);
                    echo "エラーが発生しました。もう一度やり直してください。";
                }
            
                $stmt->close();
            }
        
            
        }
        
        
    }
    $conn->close();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿内容の編集</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <textarea name="text" placeholder="いまどうしてる？" required rows="20" cols="40" maxlength="500" ></textarea><br>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($post_id); ?>">
        <input type="submit" name="update" value="更新する">
    </form>
    <button onclick="location.href='home.php'" >キャンセル</button>
    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</body>
</html>