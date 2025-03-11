<!---------------------------------------------------------
アカウント登録ページ
---------------------------------------------------------->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="icon" href="images/icon.ico">
    <style>
        #sinki {
        display       : inline-block;
        border-radius : 5%;          /* 角丸       */
        font-size     : 16pt;        /* 文字サイズ */
        text-align    : center;      /* 文字位置   */
        cursor        : pointer;     /* カーソル   */
        padding       : 12px 12px;   /* 余白       */
        background    : #ffffff;     /* 背景色     */
        color         : #6666ff;     /* 文字色     */
        line-height   : 1em;         /* 1行の高さ  */
        transition    : .3s;         /* なめらか変化 */
        border        : 2px solid #ffffff;    /* 枠の指定 */
        }
        #sinki:hover {
        color         : #ffffff;     /* 背景色     */
        background    : #6666ff;     /* 文字色     */
        }
        .box{
            text-align: center;
        }
        .box15 {
            padding: 0.2em 0.5em;
            margin: 2em 0;
            color: #565656;
            background: #ffeaea;
            box-shadow: 0px 0px 0px 10px #ffeaea;
            border: dashed 2px #ffc3c3;
            border-radius: 8px;
        }
        .box15 p {
            margin: 0; 
            padding: 0;
        }
    </style>
</head>
<body>
    <p>分からない！という方は以下のボタンより。</p>
    <button onclick="location.href='https://hot-rooster-cff.notion.site/Y-11b22066a28980ed86acd062f53b8615'">利用方法</button>
    <div class="box">
        <h2>新規登録</h2>
        
        <form action="" method="post" enctype="multipart/form-data">
            <label for="username">ユーザーネーム(表示される名前):</label><br>
            <input type="text" id="username" name="username" required maxlength="30"><br><br>

            <label for="file">アイコン画像を設定してください:</label><br>
            <input type="file" id="file" name="file" required ><br><br>

            <label for="pass1">パスワードを作成してください(6文字以上16文字以下):</label><br>
            <input type="password" id="pass1" name="pass1" required maxlength="16"><br><br>

            <label for="pass2">パスワードを再度入力してください。:</label><br>
            <input type="password" id="pass2" name="pass2" required maxlength="16"><br><br>
            <div class="box15">

                <h2>利用規約</h2>
                「Y」(以下「本アプリ」とする。)の利用規約を次のように定め、利用者はアカウント登録完了後、本規約に同意したものとみなします。 <br>

                <b>1.個人情報</b> <br>

                本アプリ内で個人情報を取得することはありません。<br>
 
                本アプリでは、利用者を識別するためにユーザー名、ユーザーID、パスワードを利用しますが、これらの情報はその情報単体から特定の個人を識別できるものではありません。 <br>

                <b>2.免責事項</b> <br>

                本アプリは、利用者が本アプリを利用したことによって生じた損害について一切の責任を負いません。<br>

                本アプリは、機密性、安全性、可用性を可能な限り提供しておりますが、これらを完全に保証するものではありません。 <br>

                <b>3.著作権</b> <br>
 
                本アプリは製作者 EBATA TAKUMIによる作品です。 <br>

                <b>4.投稿、リプライに関して</b> <br>

                本アプリの利用において、以下の内容を含むユーザー名、投稿内容、リプライ内容、プロフィールは製作者の裁量によって警告、削除されることがあります。<br>

                ・本人又は他者の個人情報を含むもの<br>

                ・特定の自然人または法人を誹謗し、中傷するもの<br>

                ・極度にわいせつな内容をを含むもの<br>

                ・禁製品の取引に関するものや、他者を害する行為の依頼など、法律によって禁止されている物品、行為の依頼や斡旋などに関するもの<br>

                ・その他、公序良俗に反し、または製作者によって、承認すべきでないと認められるもの <br>

                <b>5.クッキーの利用について</b> <br>
                本アプリでは、ログイン認証のためにCookieを使用しています。　<br>

                Cookieの使用を望まない場合、ブラウザからCookieを無効に設定できます。 <br>


                <b>6.利用規約の変更</b> <br>
 
                本アプリは、日本の法令を遵守するとともに、適宜利用規約の内容を見直し、改善に努めます。修正された利用規約は、本アプリ内にて通知致します。<br>

                制定日：2024年10月9日 <br>
                改定日：2024年11月3日 <br>

                <h2>注意事項</h2>
                ・ 本アプリは試験運用中であるため予期せぬ不具合等が発生する場合がございます。発生した場合はその状況を製作者(総合窓口等)に報告していただけると幸いです。<br>
                ・ 本アプリは製作者の友人を対象に複数名に利用をお願いしています。そのため、一般的なSNSと同じようにご利用いただけるようお願いいたします。(投稿内容に注意してください) <br>
                ・ ユーザー名やプロフィール、ポスト、リプライに個人情報等を書くのはやめてください。(利用規約にて禁止しています) <br>
                ・ パスワードの使い回しも特にこのアプリに限ってはやめてください　<br>
                ・ 本アプリは議論の場ではございません。政治的、宗教的発言等は控えるようお願いいたします。(開発者の裁量によって削除する場合がございます。)
                
            </div>

            <input type="submit" name="submit" id="sinki" value="登録する"><br><br>
        </form>
        <a href="login.php" id="sinki">すでに登録済みの方</a>
    </div>

    <?php
    ini_set('display_errors', 0);
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $user_name = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $profile = "未設定";
        
        $userid = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        if(preg_match('/\A[a-zA-Z0-9]{6,16}\z/u',$pass1) !==1){
            die('6文字以上16文字以下の英数字を入力してください。');
        }else{
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
                        if ($pass1 === $pass2) {
                            // MySQL接続設定
                            $servername = "host-name";
                            $username = "user-name";
                            $password = "password";
                            $dbname = "database-name";
        
                            // 接続を試みる
                            $conn = new mysqli($servername, $username, $password, $dbname);
        
                            // 接続チェック
                            if ($conn->connect_error) {
                                die("接続に失敗しました。後ほど再度お試しください。"); // エラーメッセージの詳細を隠す
                            }
        
                            // パスワードのハッシュ化
                            $hashedPassword = password_hash($pass1, PASSWORD_DEFAULT);
        
                            // SQL準備と実行
                            $stmt = $conn->prepare("INSERT INTO login (username, userid, icon, password,profile) VALUES (?, ?, ?, ?,?)");
                            $stmt->bind_param("sssss", $user_name, $userid, $fileName, $hashedPassword, $profile);
        
                            if ($stmt->execute()) {
                                echo "登録が完了しました。";
                                echo "<script type='text/javascript'>
                                        window.location.href = 'login.php';
                                      </script>";
                            } else {
                                echo "登録に失敗しました: " . $stmt->error;
                            }
                        } else {
                            // パスワード不一致時のメッセージ修正
                            echo "パスワードが一致しません！";
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
    
        
    
    ?>
    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</body>
</html>