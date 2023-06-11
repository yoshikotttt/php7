<?php

session_start();

$position=$_SESSION['position'];
$u_id = $_SESSION["u_id"];   
//関数とパスワードの取得
require('function.php');
require_once('config.php');

//入力チェック

if (!isset($_POST["j_date"]) || $_POST["j_date"] == "") {
    exit("ParamError:date");
}
if (!isset($_POST["clinic_name"]) || $_POST["clinic_name"] == "") {
    exit("ParamError:clinic_name");
}
if (!isset($_POST["payment"]) || $_POST["payment"] == "") {
    exit("ParamError:payment");
}




//POST データ取得
$tooth_name =$_POST["tooth_name"];
$j_date = $_POST["j_date"];
$clinic_name = $_POST["clinic_name"];
$payment = $_POST["payment"];
$c_memo = $_POST["c_memo"];


//DB接続後のdb_connをもらう
//$pdoは設計図を見せて、作ってもらったデータベース接続の枠組み（インスタンス）
$pdo = db_conn($database_name, $host, $user, $database_password);

//$stmtは出来上がったインスタンスを使って、準備されたSQL文を実行するためのステートメント
//テーブルの〇〇というところに、仮の：〇〇を作ってね、そこに＄〇〇を入れるよ

$sql="INSERT INTO php7_clinic_table(u_id,tooth_name,j_date,clinic_name,payment,c_memo)VALUES(:u_id,:tooth_name,:j_date,:clinic_name,:payment,:c_memo)";
$stmt = $pdo->prepare($sql);
//bindValueで無効化
$stmt->bindValue(':u_id', $u_id,   PDO::PARAM_INT);
$stmt->bindValue(':tooth_name', $tooth_name,     PDO::PARAM_STR);
$stmt->bindValue(':j_date', $j_date, PDO::PARAM_STR);
$stmt->bindValue(':clinic_name', $clinic_name,     PDO::PARAM_STR);
$stmt->bindValue(':payment', $payment,   PDO::PARAM_INT);
$stmt->bindValue(':c_memo', $c_memo,     PDO::PARAM_STR);
//pdoを使って準備したステートメントを、execute(=実行)メソッドを呼び出すことで、クエリを実行。trueかfalseが返る。
$status = $stmt->execute();


//登録処理後のステータス確認
if($status==false){
    sql_error($stmt);
}else{
    redirect("input.php?position={$position}");
}

