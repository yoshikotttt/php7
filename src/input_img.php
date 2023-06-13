<?php

session_start();


$u_id = $_SESSION["u_id"];   
$position=$_SESSION['position'];

//関数とパスワードの取得
require('function.php');
require_once('config.php');




//POST データ取得
$tooth_name =$_POST["tooth_name"];
$img = $_FILES["img"]["name"];



//DB接続後のdb_connをもらう
//$pdoは設計図を見せて、作ってもらったデータベース接続の枠組み（インスタンス）
$pdo = db_conn($database_name, $host, $user, $database_password);


$status = fileUpload("img","../images/");
  //どこでのエラーかわかるように分けたバージョン
if($status==1){
  exit("UploadError1");
} else if($status==2){
  //Error
  exit("UploadError2");
}else{
  //Good
  $img = $status;  //ファイル名 YmdHis+md5のセッションid+拡張子
}


//$stmtは出来上がったインスタンスを使って、準備されたSQL文を実行するためのステートメント
//テーブルの〇〇というところに、仮の：〇〇を作ってね、そこに＄〇〇を入れるよ

$sql="INSERT INTO php7_img_table(u_id,tooth_name,img)VALUES(:u_id,:tooth_name,:img)";
$stmt = $pdo->prepare($sql);
//bindValueで無効化
$stmt->bindValue(':u_id', $u_id,   PDO::PARAM_INT);
$stmt->bindValue(':tooth_name', $tooth_name,     PDO::PARAM_STR);
$stmt->bindValue(':img', $img, PDO::PARAM_STR);
//pdoを使って準備したステートメントを、execute(=実行)メソッドを呼び出すことで、クエリを実行。trueかfalseが返る。
$status = $stmt->execute();


//登録処理後のステータス確認
if($status==false){
    sql_error($stmt);
}else{
    redirect("input.php?position={$position}");
}

