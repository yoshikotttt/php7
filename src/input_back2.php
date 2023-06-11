<?php

//更新

session_start();

$position=$_SESSION['position'];

//関数とパスワードの取得
require('function.php');
require_once('config.php');

//入力チェック

if (!isset($_POST["h_date"]) || $_POST["h_date"] == "") {
    exit("ParamError:date");
}



//POST データ取得
$tooth_name =$_POST["tooth_name"];
$h_date = $_POST["h_date"];
$memo2 = $_POST["memo2"];


//DB接続後のdb_connをもらう
//$pdoは設計図を見せて、作ってもらったデータベース接続の枠組み（インスタンス）
$pdo = db_conn($database_name, $host, $user, $database_password);

//$stmtは出来上がったインスタンスを使って、準備されたSQL文を実行するためのステートメント
//テーブルの〇〇というところに、仮の：〇〇を作ってね、そこに＄〇〇を入れるよ

$sql = "UPDATE php7_records_table SET h_date=:h_date,memo2=:memo2 WHERE tooth_name=:tooth_name";
$stmt = $pdo->prepare($sql);
//bindValueで無効化
$stmt->bindValue(':tooth_name', $tooth_name,     PDO::PARAM_STR);
$stmt->bindValue(':h_date', $h_date, PDO::PARAM_STR);
$stmt->bindValue(':memo2', $memo2,     PDO::PARAM_STR);
//pdoを使って準備したステートメントを、execute(=実行)メソッドを呼び出すことで、クエリを実行。trueかfalseが返る。
$status = $stmt->execute();


//登録処理後のステータス確認
if($status==false){
    sql_error($stmt);
}else{
    redirect("input.php?position={$position}");
}

