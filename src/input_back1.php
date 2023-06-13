<?php
//抜けた日登録用php


session_start();

//リダイレクトのURL用
$position=$_SESSION['position'];

//関数とパスワードの取得
require('function.php');
require_once('config.php');


//入力チェック
if (!isset($_POST["n_date"]) || $_POST["n_date"] == "") {
    exit("ParamError:date");
}



//POST データ取得
$u_id = $_POST["u_id"];
$tooth_name =$_POST["tooth_name"];
$n_date = $_POST["n_date"];
$memo1 = $_POST["memo1"];
$n_date = date("Y-m-d", strtotime($n_date)); //Hisがいらなかったのでこれをしたけど不要かも


//DB接続後のdb_connをもらう
//$pdoは設計図を見せて、作ってもらったデータベース接続の枠組み（インスタンス）
$pdo = db_conn($database_name, $host, $user, $database_password);

//$stmtは出来上がったインスタンスを使って、準備されたSQL文を実行するためのステートメント
//テーブルの〇〇というところに、仮の：〇〇を作ってね、そこに＄〇〇を入れるよ

$sql="INSERT INTO php7_records_table(u_id,tooth_name,position,n_date,memo1)VALUES(:u_id,:tooth_name,:position,:n_date,:memo1)";
$stmt = $pdo->prepare($sql);
//bindValueで無効化
$stmt->bindValue(':u_id', $u_id,   PDO::PARAM_INT);
$stmt->bindValue(':tooth_name', $tooth_name,     PDO::PARAM_STR);
$stmt->bindValue(':position', $position,     PDO::PARAM_STR);
$stmt->bindValue(':n_date', $n_date, PDO::PARAM_STR);
$stmt->bindValue(':memo1', $memo1,     PDO::PARAM_STR);
//pdoを使って準備したステートメントを、execute(=実行)メソッドを呼び出すことで、クエリを実行。trueかfalseが返る。
$status = $stmt->execute();


//登録処理後のステータス確認
if($status==false){
    sql_error($stmt);
}else{
    redirect("input.php?position={$position}"); //入力画面（positionの値を持ったURL)に戻る

}

