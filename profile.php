<?php
ini_set('display_errors', 0);
if (isset($_GET['user_id'])) {
    $user_id = htmlspecialchars($_GET['user_id']);
    $_SESSION['user_id'] = $user_id; 
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
$stmt = $conn->prepare("SELECT * FROM login WHERE userid = ?");
$stmt->bind_param("s", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result(); // 結果の取得

    if ($row = $result->fetch_assoc()) {
        $user_name = htmlspecialchars($row["username"]);
        $icon = htmlspecialchars($row["icon"], ENT_QUOTES, 'UTF-8');
    }
}

//echo "ユーザーネーム：".$user_name."<br>";
//echo "ユーザーID："."@".$user_id."<br>";
//echo '<img src="' . $icon. '" alt="User Image">'."<br>";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ぷろふぃ～る / Y</title>
    <link rel="icon" href="images/icon.ico">
    <link rel="stylesheet" type="text/css" href="css/profile.css" /> 
</head>
<body>
    <div class="window">
    <div class="overlay"></div>
    <div class="box header">
      <img src="images/<?php echo $icon; ?>" alt="User Image">
      
        <h2><?php echo $user_name;?></h2>
        <h4><?php echo "@".$user_id;?></h4>
        
    </div>
    <div class="box footer">
    <?php
    
      // ステートメントの準備
      $stmt = $conn->prepare("SELECT * FROM login WHERE userid = ?");
      $stmt->bind_param("s", $user_id); 
      $stmt->execute();

      // 結果を取得
      $result = $stmt->get_result();

      // 結果があるかどうかを確認
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              // プロフィールの出力（エスケープ処理済み）
              echo htmlspecialchars($row["profile"], ENT_QUOTES, 'UTF-8');
          }
      }
      ?>
      <!-- 編集ボタンの生成 -->
    <a href="edit.php?user_id=<?php echo urlencode($user_id); ?>" class="btn">編集する</a>
    <input type="button" class="btn" onclick="history.back()" value="戻る">
      
    </div>
    </div>
    <?php
        
        $stmt = $conn->prepare("SELECT * FROM y_main WHERE user_id = ? ORDER BY day DESC");
        $stmt->bind_param("s", $user_id); 
        $stmt->execute();

        // 結果を取得
        $result = $stmt->get_result();

        // 結果があるかどうかを確認
        if ($result->num_rows > 0) {
            echo '<div class="twitter__container">';
            // echo '<div class="twitter__contents scroll">';
            
            // 結果のデータを一行ずつ取得
            while ($row = $result->fetch_assoc()) {
              echo '<div class="twitter__block">';
              
              // アイコンを表示
              // デバッグ: 画像パスの確認
              $imagePath = 'images/' . htmlspecialchars($row["icon"], ENT_QUOTES, 'UTF-8');
              //echo $imagePath; // デバッグ用に画像パスを出力

              // 画像出力処理
              echo '<figure>';
              echo '<img src="' . $imagePath . '" alt="User Image">';
              echo '</figure>';
              
              // テキスト部分の表示
              echo '<div class="twitter__block-text">';
              echo '<a href="profile.php?user_id='.urlencode($row["user_id"]).'" class="link"><div class="name">'.htmlspecialchars($row["user_name"]).'<span class="name_reply">@'.htmlspecialchars($row["user_id"]).'</span></div></a>';
              echo '<div class="text">' . htmlspecialchars($row["text"]) . '</div><br>'; 
              echo '<div class="date">'.htmlspecialchars($row["day"]).'</div>'; 

              if (!empty($row["picture"])) {
                echo '<div class="in-pict"><img src="images/' . htmlspecialchars($row["picture"], ENT_QUOTES, 'UTF-8') . '"></div></div>';
              }

              echo '<br>';
              
              // アイコン（返信、ループ、いいねボタンなど）
              echo '<div class="twitter__icon"><span class="twitter-bubble"></span><span class="twitter-loop"></span><span class="twitter-heart"></span></div>';
              
              // テーブルで「いいね！」の表示
              echo "<table><tr>";
              echo "いいね！".htmlspecialchars($row["count"]); 
              echo "</tr></table>";
              
              echo "</div>"; // twitter__block-text
              echo "</div>"; // twitter__block
            }
            
            // コンテナを閉じる
            echo "</div>"; // twitter__container
        } else {
            // 結果がない場合のメッセージ
            echo "これまでに投稿されたものはありません。";
        }
        ?>
    
</body>
</html>