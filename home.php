<?php
session_start();
echo '<img src="images/icon.png" width="30" height="30" alt="代替文字"><br>';
ini_set('display_errors', 0);
// MySQL接続設定
$servername = "host-name";
$username = "user-name";
$password = "password";
$dbname = "database-name";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 接続を試みる
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$token = $_COOKIE['token'] ?? null; // Cookieからトークンを取得

if (empty($token) || $token !== $_SESSION['token']) {
    echo "ゲストユーザー";
    echo '<br><a href="login.php">ログイン/新規登録する！</a>';
} else {
    
    echo "ようこそ、" . htmlspecialchars($_SESSION['username']) . "さん！";
    $GETuser_id = htmlspecialchars($_SESSION['userid']);

}
$sql = "UPDATE access SET value = value + 1 WHERE name = 1";
if ($conn->query($sql) === TRUE) {
} else {
    echo "エラー: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム / Y</title>
    <link rel="icon" href="images/icon.ico">
    <link rel="stylesheet" type="text/css" href="css/home.css" /> 
    <style>
        .twitter__container{
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <!--投稿ボタン-->
    <p class="pagetop"><a href="javascript:void(0)" class="button">🖊投稿</a></p>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        //投稿ボタンの動作
        $(document).ready(function() {
            var pagetop = $('.pagetop');

            pagetop.click(function () {
                window.location.href = 'post.php'; 
            });
        });
    </script>
    <div class="flexbox">
        <div class="flex-item">
            <div id="menu">
                <ul>
                    <li><a href="home.php">ホーム</a></li>
                    <li><a href="profile.php?user_id=<?php echo urlencode($GETuser_id) ?>">Myプロフィール</a></li>
                    <li><a href="search.php">検索</a></li>
                    <li><a href="post.php">投稿する</a></li>
                </ul> 
            </div>
        </div>
        <div class="flex-item content">
            <?php
            $stmt = $conn->prepare("SELECT * FROM y_main ORDER BY day DESC");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<div class="twitter__container">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="twitter__block">';
                    $imagePath = 'images/' . htmlspecialchars($row["icon"], ENT_QUOTES, 'UTF-8');
                    echo '<figure><img src="' . $imagePath . '" alt="User Image"></figure>';
                    echo '<div class="twitter__block-text">';
                    echo '<a href="profile.php?user_id='.urlencode($row["user_id"]).'" class="link"><div class="name">'.htmlspecialchars($row["user_name"]).'<span class="name_reply">@'.htmlspecialchars($row["user_id"]).'</span></div></a>';
                    echo '<div class="text">' . htmlspecialchars($row["text"]) . '</div>';
                    //添付画像の確認
                    if (!empty($row["picture"])) {
                        echo '<div class="in-pict"><img src="images/' . htmlspecialchars($row["picture"], ENT_QUOTES, 'UTF-8') . '"></div>';
                    }
                    echo '<div class="date">'.htmlspecialchars($row["day"]).'</div>'; 
                    echo '<div class="twitter__icon"><span class="twitter-bubble"></span><span class="twitter-loop"></span><span class="twitter-heart"></span></div>';
                    echo '<div style="display: flex; justify-content: space-around;">';

                    //いいね機能
                    echo '<div>';
                    echo '<form action="good.php" method="post">';
                    echo '<input type="hidden" name="id" value="' . $row['post_id'] . '">';
                    echo '<input type="submit" value="❤" class="likeButton">';
                    echo htmlspecialchars($row["count"]);
                    echo '</form>';
                    echo '</div>';

                    //リプライ機能
                    echo '<div>';
                    echo '<a href="replie.php?user_id=' . urlencode($row["post_id"]) . '" class="link">';
                    echo '<button class="likeButton">💬</button>';
                    echo '</a>';
                    echo htmlspecialchars($row["count_rep"]);
                    echo '</div>';

                    //編集機能
                    echo '<div>';
                    echo '<form action="edit_post.php" method="post">';
                    echo '<input type="hidden" name="id" value="' . $row['post_id'] . '">';
                    echo '<input type="submit" value="🖊" class="likeButton">';
                    echo '</form>';
                    echo '</div>';

                    //削除機能
                    echo '<div>';
                    echo '<form action="delete.php" method="post">';
                    echo '<input type="hidden" name="id" value="' . $row['post_id'] . '">';
                    echo '<input type="submit" value="🗑️" class="likeButton">';
                    echo '</form>';
                    echo '</div>';

                    echo '</div>'; 
                    echo '</div>'; 
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "何も投稿されていないかデータが見つかりません。";
            }
            ?>
            <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
        </div>
        
</body>
</html>