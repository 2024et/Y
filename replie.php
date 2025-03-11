<?php
    /*////////////////////////////////////////////////////////////////////////
    リプライページ
    /////////////////////////////////////////////////////////////////////////*/
    session_start();
    ini_set('display_errors', 0);
   
    if (isset($_SESSION['username'])) {
        echo '<input type="button" class="back" onclick="history.back()" value="戻る">';
        echo "　　ようこそ、" . htmlspecialchars($_SESSION['username']) . "さん！";
    } else {
        echo '<input type="button" class="back" onclick="history.back()" value="戻る">';
        echo "　　ゲストユーザー";
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

    // 選択されたポストIDの取得。
    if (isset($_GET['user_id'])) {
        $post_id = htmlspecialchars($_GET['user_id'], ENT_QUOTES, 'UTF-8');

        //投稿元の表示//////////////////////////////////////////////////////////////////////////////////////////////////////
        $stmt = $conn->prepare("SELECT * FROM y_main where post_id = $post_id");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="twitter__container">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="twitter__block">';
                echo "<figure>";
                echo '<img src="images/' . htmlspecialchars($row["icon"], ENT_QUOTES, 'UTF-8') . '" alt="User Image">';
                echo "</figure>";

                echo '<div class="twitter__block-text">';
                echo '<a href="profile.php?user_id='.urlencode($row["user_id"]).'" class="link"><div class="name">'.htmlspecialchars($row["user_name"]).'<span class="name_reply">@'.htmlspecialchars($row["user_id"]).'</span></div></a>';
                echo '<div class="text">' . htmlspecialchars($row["text"]) . '</div><br>'; 
                echo '<div class="date">'.htmlspecialchars($row["day"]).'</div>'; 

                if (!empty($row["picture"])) {
                    echo '<div class="in-pict"><img src="images/' . htmlspecialchars($row["picture"], ENT_QUOTES, 'UTF-8') . '"></div></div>';
                }
    
                echo '<br>';
                
                
                echo '<div class="twitter__icon"><span class="twitter-bubble"></span><span class="twitter-loop"></span><span class="twitter-heart"></span></div>';
                
                echo "<td><form action='replie_post.php' method='post'>";
                echo "<input type='hidden' name='rep' value='" . $row['post_id'] . "'>";
                $_SESSION['post_id'] = $post_id; 
                echo "<input type='submit' value='💬' class='likeButton'>"."←リプライ！！";
                echo "</form></td>"; 
                
                echo "いいね！：".htmlspecialchars($row["count"]);
                
                
                
                echo "</div>";
                echo "</div>";
            }
            echo "</div>"; 
            echo "</div>"; 
        } else {
            echo "この投稿にはまだリプライがついていません。あなたもリプライしてみましょう！！";
        }
        
        //リプライの表示//////////////////////////////////////////////////////////////////////////////////////////////////////
        $stmt = $conn->prepare("SELECT * FROM y_replie WHERE post_id = ?");
        $stmt->bind_param("i", $post_id); // post_idが整数型である場合
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="twitter__container">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="twitter__block">';
                
                echo "<figure>";
                echo '<img src="images/' . htmlspecialchars($row["icon"], ENT_QUOTES, 'UTF-8') . '" alt="User Image">';
                echo "</figure>";
                
                echo '<div class="twitter__block-text">';
                echo '<font color="0067c0"><b>返信</b></font>';
                echo '<a href="profile.php?user_id='.urlencode($row["user_id"]).'" class="link"><div class="name">'.htmlspecialchars($row["user_name"]).'<span class="name_reply">@'.htmlspecialchars($row["user_id"]).'</span></div></a>';
                echo '<div class="text">' . htmlspecialchars($row["text"]) . '</div><br>'; 
                echo '<div class="date">'.htmlspecialchars($row["day"]).'</div>'; 


                if (!empty($row["picture"])) {
                    echo '<div class="in-pict"><img src="images/' . htmlspecialchars($row["picture"], ENT_QUOTES, 'UTF-8') . '"></div></div>';
                }
    
                echo '<br>';

                echo '<td><form action="delete_replie.php" method="post"><input type="hidden" name="id" value="' . $row['replie_id'] . '"><input type="submit" value="🗑️" class="likeButton"></form></td>';

                echo '<td><form action="good_replie.php" method="post"><input type="hidden" name="id" value="' . $row['replie_id'] . '"><input type="submit" value="❤" class="likeButton">'. htmlspecialchars($row["count"]) .'</form></td>';
                echo '<div class="twitter__icon"><span class="twitter-bubble"></span><span class="twitter-loop"></span><span class="twitter-heart"></span></div>';               
                echo "</div>"; 
                echo "</div>"; 
            }
            echo "</div>"; 
            echo "</div>"; 
        } else {
            echo "この投稿にはまだリプライがついていません。あなたもリプライしてみましょう！！";
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>リプライ / Y</title>
    <link rel="icon" href="images/icon.ico">
    <link rel="stylesheet" type="text/css" href="css/replie.css"/> 
    <style>
        body {
    background-color: #c0dce7;
}
.twitter__container {
    padding: 0;
    background: #c0dce7;
    overflow: hidden;
    margin: 20px auto;
    font-size: 80%;
    border: solid 1px #eeeeee;
    }
    </style>
</head>
<body>
    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</body>
</html>