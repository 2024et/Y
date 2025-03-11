<?php
    /*////////////////////////////////////////////////////////////////////////
    本投稿に対する検索機能
    /////////////////////////////////////////////////////////////////////////*/
session_start();
ini_set('display_errors', 0);
echo '<img src="images/icon.png" width="30" height="30" alt="代替文字"><br>';
if (isset($_SESSION['username'])) {
    //echo '<input type="button" class="back" onclick="history.back()" value="戻る">';
    echo "ようこそ、" . htmlspecialchars($_SESSION['username']) . "さん！";
    $GETuser_id = htmlspecialchars($_SESSION['userid']);
} else {
   // echo '<input type="button" class="back" onclick="history.back()" value="戻る">';
    echo '<br><a href="login.php">ログイン/新規登録する！</a>';
    echo "ゲストユーザー";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索 / Y</title>
    <style>
        .flexbox {
        display: flex;
        flex-direction: row;
        width: 100%;
        }
        .flex-item {
            padding: 10px;
        }
        #menu {
            width: 200px;
            border-right: 1px solid #ccc;
        }
        #menu ul{ 
            margin: 0; 
            padding: 0; 
            list-style: none; 
        }
        #menu li{ 
            margin: 5px 0; 
        }
        #menu li a{
            display: block; 
            border: 1px solid #9F99A3;
            background-color: #c0dce7;
            padding: 10px;
            text-decoration: none;
            color: #44485a;
            width: 100%; 
            text-align: left;
            font-size: 14px;
        }
        #menu li a:hover{
            border: 1px solid #EAEEDC;
            background-color: #c0dce7;
        }
        .content {
            flex-grow: 1;
            padding-left: 20px;
        }
        body {
            background-color: #c0dce7;
        }
        * {
            box-sizing: border-box;
        }

        .twitter__container {
            padding: 0;
            background: #c0dce7;
            overflow: hidden;
            margin: 20px auto;
            font-size: 80%;
            border: solid 1px #EAEEDC;
            max-width: 800px;
            width: 100%; 
        }

        .twitter__block {
            width: 100%;
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            border-bottom: solid 1px #EAEEDC;
        }

        .twitter__block figure {
            width: 50px;
            float: left;
            margin: 0;
        }

        .twitter__block figure img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .twitter__block-text {
            margin: 0;
            position: relative;
            margin-left: 60px; 
            padding-right: 10px;
            overflow: hidden; 
        }

        .twitter__block-text .text {
            margin: 5px 0;
            word-wrap: break-word; 
        }
        .back {
        display       : inline-block;
        font-size     : 14pt;       
        text-align    : center;     
        cursor        : pointer;     
        padding       : 12px 12px;   
        background    : #ffffff;    
        color         : #000000;    
        line-height   : 1em;       
        opacity       : 1;          
        transition    : .3s;         
        box-shadow    : 1px 1px 3px #666666; 
        }
        .back:hover {
        box-shadow    : none;        
        opacity       : 0.8;       
        }
    </style>
</head>
<body>
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
        <form action="" method="post">
            <input type="text" name="text" id="text" required>
            <input type="submit" name="search" id="search" value="🔍"><br>
        </form>

        <p>現状：url生成を行っていないため、検索結果画面に復帰ウすることは不可能。</p>
        <?php
        ini_set('display_errors', 0);
        // MySQLへの接続設定
        $servername = "host-name";
        $username = "user-name";
        $password = "password";
        $dbname = "database-name";
        
        $conn = new mysqli($servername, $user_name, $password, $dbname);
        if ($conn->connect_error) {
            die("接続失敗: " . $conn->connect_error);
        }
        
        //入力された文字列をデータベースからLIKE句で検索し一覧表示する。
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])){
            $text = "%" . $conn->real_escape_string($_POST['text']) . "%";

            $stmt = $conn->prepare("SELECT * FROM y_main WHERE text LIKE ? ORDER BY day DESC");
            $stmt->bind_param("s", $text);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<div class="twitter__container">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="twitter__block">';
                    //投稿内容の表示
                    $imagePath = 'images/' . htmlspecialchars($row["icon"], ENT_QUOTES, 'UTF-8');
                    echo '<figure><img src="' . $imagePath . '" alt="User Image"></figure>';
                    echo '<div class="twitter__block-text">';
                    echo '<a href="profile.php?user_id='.urlencode($row["user_id"]).'" class="link"><div class="name">'.htmlspecialchars($row["user_name"]).'<span class="name_reply">@'.htmlspecialchars($row["user_id"]).'</span></div></a>';
                    echo '<div class="text">' . htmlspecialchars($row["text"]) . '</div>';
                    if (!empty($row["picture"])) {
                        echo '<div class="in-pict"><img src="images/' . htmlspecialchars($row["picture"], ENT_QUOTES, 'UTF-8') . '"></div>';
                    }
                    echo '<div class="date">'.htmlspecialchars($row["day"]).'</div>'; 
                    echo '<div class="twitter__icon"><span class="twitter-bubble"></span><span class="twitter-loop"></span><span class="twitter-heart"></span></div>';
                    
                    // リプライ機能
                    echo '<div>';
                    echo '<a href="replie.php?user_id=' . urlencode($row["post_id"]) . '" class="link">';
                    echo '<button class="likeButton">💬</button>';
                    echo '</a>';
                    echo htmlspecialchars($row["count_rep"]);
                    echo '</div>';

                    echo '</div>'; 
                    echo '</div>'; 
                }
                echo '</div>';
            } else {
                echo "何も投稿されていないかデータが見つかりません。";
            }
        }

    
    ?>
    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</div>
</body>
</html>