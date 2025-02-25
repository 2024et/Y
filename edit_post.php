<?php
ini_set('display_errors', 0);

    session_start();
    if (isset($_SESSION['username'])) {
        echo "ようこそ、" . htmlspecialchars($_SESSION['username']) . "さん！";
    } else {
        echo "ゲストユーザー";
        echo "<script type='text/javascript'>
            window.location.href = 'login.php';
        </script>";
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
    $user_name = htmlspecialchars($_SESSION['username']);


    // ユーザーIDを取得
    $stmt = $conn->prepare("SELECT userid FROM login WHERE username = ?");
    $stmt->bind_param("s", $user_name);

    if ($stmt->execute()) {
        $result = $stmt->get_result(); // 結果の取得

        if ($row = $result->fetch_assoc()) {
            $user_id = htmlspecialchars($row["userid"]); // ユーザーIDを変数に代入
        }
        $stmt->close(); // ステートメントを閉じる
    } else {
        echo "ユーザーIDの取得に失敗しました。";
        $conn->close();
        exit();
    }

    

    //選択した行のpost_idを取得
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

        //echo $post_id."/".$user_id;//デバック用

         
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

                    echo "<script type='text/javascript'>window.location.href = 'home.php';</script>";
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