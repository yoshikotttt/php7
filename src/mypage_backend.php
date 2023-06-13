<?php

//ニックネームの更新

session_start();

//関数とパスワードの取得
require('function.php');
require_once('config.php');



//POST データ取得
$id        = $_POST["id"];
$n_name    = $_POST["n_name"];


//DB接続後のdb_connをもらう
//$pdoは設計図を見せて、作ってもらったデータベース接続の枠組み（インスタンス）
$pdo = db_conn($database_name, $host, $user, $database_password);

//$stmtは出来上がったインスタンスを使って、準備されたSQL文を実行するためのステートメント
//テーブルの〇〇というところに、仮の：〇〇を作ってね、そこに＄〇〇を入れるよ

$sql = "UPDATE php7_user_table SET n_name=:n_name WHERE id=:id";
$stmt = $pdo->prepare($sql);
//bindValueで無効化
$stmt->bindValue(':id', $id,     PDO::PARAM_INT);
$stmt->bindValue(':n_name', $n_name, PDO::PARAM_STR);

//pdoを使って準備したステートメントを、execute(=実行)メソッドを呼び出すことで、クエリを実行。trueかfalseが返る。
$status = $stmt->execute();


//登録処理後のステータス確認
if($status==false){
    sql_error($stmt);
}else{
    // //リダイレクト時にニックネームの表示を変えるためにセッションデータを持つ→再読み込みするので不要
    // $_SESSION['n_name'] = $n_name; 
    redirect("mypage.php");
}
