<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>設定</title>
    <style>
        .tab-2 {
    display: flex;
    flex-wrap: wrap;
    gap: 0 10px;
    max-width: auto;
}
.tab-2 > label {
    flex: 1 1;
    order: -1;
    opacity: .5;
    min-width: 70px;
    padding: .6em 1em;
    border-radius: 5px 5px 0 0;
    background-color: #2589d0;
    color: #fff;
    font-size: .9em;
    text-align: center;
    cursor: pointer;
}

.tab-2 > label:hover {
    opacity: .8;
}

.tab-2 input {
    display: none;
}

.tab-2 > div {
    display: none;
    width: 100%;
    padding: 1.5em 1em;
    background-color: #fff;
}

.tab-2 label:has(:checked) {
    opacity: 1;
}

.tab-2 label:has(:checked) + div {
    display: block;
}
body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        h2 {
            color: #555;
        }
        h3 {
            color: #777;
        }
        ul {
            list-style-type: disc;
            margin-left: 20px;
        }
        .release-info {
            background-color: #fff;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
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
                    <li><a href="setting.php">設定・ポリシー・利用方法・窓口</a></li>
                    <li><a href="post.php">投稿する</a></li>
                </ul> 
            </div>
        </div>
        <div class="flex-item content">
            <div class="tab-2">
            <label>
                <input type="radio" name="tab-2" checked>
                利用方法
            </label>
            <div>
            <iframe src="https://v2-embednotion.com/11b22066a28980ed86acd062f53b8615" style="width: 100%; height: 500px; border: 2px solid #ccc; border-radius: 10px; padding: none;"></iframe>
            </div>

            <label>
                <input type="radio" name="tab-2">
                利用規約
            </label>
            <div>
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
                本アプリでは、ログイン認証のためにCookieを使用しています。 <br>

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

            <label>
                <input type="radio" name="tab-2">
                総合窓口
            </label>
            <div>
            <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSc89WPI6Ux27uxZL_jtr7XmxDZyyC57lW0nr5ECyB3YpSeQiA/viewform?embedded=true" width="640" height="1783" frameborder="0" marginheight="0" marginwidth="0">読み込んでいます…</iframe>
            </div>

            <label>
                <input type="radio" name="tab-2">
                Release Note
            </label>
            <div>
                <div class="release-info">
                    <h1>正式リリース(10月11日)から10月31日までの追加機能及び修正情報</h1>
                    <p><strong>2024/10/31</strong></p>
                    <h2>Ver. 2.1.1</h2>

                    <h3>概要：</h3>
                    <ul>
                        <li>メニュー画面の追加</li>
                        <li>デザインの変更</li>
                        <li>リプライリンクの生成</li>
                        <li>認証システムの追加</li>
                        <li>検索機能の追加</li>
                        <li>総合窓口の開設</li>
                        <li>リプライ数の表示</li>
                    </ul>

                    <h3>リリース内容：</h3>
                    <h4>メニュー画面の追加</h4>
                    <p>ホーム画面の左側にメニュー機能を追加しました。以前は、プロフィール画面で過去の投稿を表示するためにユーザーネームまたはユーザーIDをクリックする必要がありましたが、これからはメニュー欄から簡単にアクセスできるようになりました。また、利用規約へのアクセスも容易になりました。</p>

                    <h4>デザインの変更</h4>
                    <p>背景色を変更し、いいね、リプライ、編集、削除ボタンのデザインを刷新しました。</p>

                    <h4>リプライリンクの生成</h4>
                    <p>リプライボタンを押すと投稿内容が表示されるようになりました。さらに、それぞれの投稿にリンクを生成し、共有しやすくなりました。</p>

                    <h4>認証システムの追加</h4>
                    <p>ログインシステムにクッキーを用いた認証システムを新たに導入しました。なお、クッキーが無効になっている場合、一部機能が利用できないことがあります。</p>

                    <h4>検索機能の追加</h4>
                    <p>過去の投稿を検索する機能が追加されました。</p>

                    <h4>総合窓口の開設</h4>
                    <p>バグの報告など、総合的な窓口が新たに開設されました。</p>

                    <h4>リプライ数の表示</h4>
                    <p>リプライ数を表示する機能が導入されました。</p>

                    <h3>不具合修正：</h3>
                    <ul>
                        <li>メニューからプロフィール画面へのリダイレクトを修正しました。</li>
                    </ul>
                </div>
            </div>

            <label>
                <input type="radio" name="tab-2">
                基本設定
            </label>
            <div>
                
            </div>
        </div>
    </div>
    


</div>
</body>
</html>