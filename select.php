<?php

//SESSIONスタート
session_start();


//1.  DB接続します
require_once('funcs.php');

//ログインチェック ログインされていれば、次に進める関数
loginCheck();

//以下ログインユーザーのみ
$user_name = $_SESSION['name'];
$kanri_flg = $_SESSION['kanri_flg'];//0が一般で1が管理者


$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="";
// ↑javascriptでやってこなかった部分
if($status==false) {
  sql_error($status);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .= "<p>";

    $view .= '<a href="detail.php?id='.$result['id'].'">'; //ここが難しい！！id=シングルクオーテーション

    $view .= $result["indate"] . "：" . $result["name"];
    $view .= '</a>';

    $view .= '<a href="delete.php?id='.$result['id'].'">'; //追記
    $view .= '　[削除]';
    $view .= '</a>';
    
    $view .= "</p>";
  }
  // for文じゃなくてwhile文の方が主流

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク一覧</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">ブックマーク登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
