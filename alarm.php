<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通知 / Y</title>
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
    background-color: #EEEEEE;
    padding: 10px;
    text-decoration: none;
    color: #333;
    width: 100%; 
    text-align: left;
    font-size: 14px;
}
#menu li a:hover{
    border: 1px solid #8593A9;
    background-color: #9EB7DD;
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
                    <li><a href="">Myプロフィール(未実装)</a></li>
                    <li><a href="search.php">検索(試験運用)</a></li>
                    <li><a href="alarm.php">通知</a></li>
                    <li><a href="setting.php">設定・ポリシー・利用方法・窓口</a></li>
                </ul> 
            </div>
        </div>
        <div class="flex-item content">
            <p>現在このページは開発中です。</p>
        </div>
    </div>
    <hr>
    <p><center>©2024 EBATA TAKUMI</center></p>
</body>
</html>