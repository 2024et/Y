<?php
    /*////////////////////////////////////////////////////////////////////////
   プロフィールページ
    /////////////////////////////////////////////////////////////////////////*/
ini_set('display_errors', 0);
if (isset($_GET['user_id'])) {
    $user_id = htmlspecialchars($_GET['user_id']);
    $_SESSION['user_id'] = $user_id; 
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
$stmt = $conn->prepare("SELECT * FROM login WHERE userid = ?");
$stmt->bind_param("s", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result(); 

    if ($row = $result->fetch_assoc()) {
        $user_name = htmlspecialchars($row["username"]);
        $icon = htmlspecialchars($row["icon"], ENT_QUOTES, 'UTF-8');
    }
}
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
    //ログイン情報の取得
      $stmt = $conn->prepare("SELECT * FROM login WHERE userid = ?");
      $stmt->bind_param("s", $user_id); 
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo htmlspecialchars($row["profile"], ENT_QUOTES, 'UTF-8');
          }
      }
      ?>
    <a href="edit.php?user_id=<?php echo urlencode($user_id); ?>" class="btn">編集する</a>
    <input type="button" class="btn" onclick="history.back()" value="戻る">
      
    </div>
    </div>
    <?php
        //ユーザーの過去に投稿した内容を一覧表示する。
        $stmt = $conn->prepare("SELECT * FROM y_main WHERE user_id = ? ORDER BY day DESC");
        $stmt->bind_param("s", $user_id); 
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo '<div class="twitter__container">';
            while ($row = $result->fetch_assoc()) {
              echo '<div class="twitter__block">';
              
              $imagePath = 'images/' . htmlspecialchars($row["icon"], ENT_QUOTES, 'UTF-8');
              
              echo '<figure>';
              echo '<img src="' . $imagePath . '" alt="User Image">';
              echo '</figure>';
              
              echo '<div class="twitter__block-text">';
              echo '<a href="profile.php?user_id='.urlencode($row["user_id"]).'" class="link"><div class="name">'.htmlspecialchars($row["user_name"]).'<span class="name_reply">@'.htmlspecialchars($row["user_id"]).'</span></div></a>';
              echo '<div class="text">' . htmlspecialchars($row["text"]) . '</div><br>'; 
              echo '<div class="date">'.htmlspecialchars($row["day"]).'</div>'; 

              if (!empty($row["picture"])) {
                echo '<div class="in-pict"><img src="images/' . htmlspecialchars($row["picture"], ENT_QUOTES, 'UTF-8') . '"></div></div>';
              }

              echo '<br>';
              
              echo '<div class="twitter__icon"><span class="twitter-bubble"></span><span class="twitter-loop"></span><span class="twitter-heart"></span></div>';
              
              echo "<table><tr>";
              echo "いいね！".htmlspecialchars($row["count"]); 
              echo "</tr></table>";
              
              echo "</div>"; 
              echo "</div>"; 
            }
            
            echo "</div>"; 
        } else {
            echo "これまでに投稿されたものはありません。";
        }
        ?>
    
</body>
</html>