<?php


session_start();


//関数読み込み
require('function.php');
require_once('config.php');

//idとpasswordを取得
$log_id=$_POST["log_id"];
$password=$_POST["password"];


//$pdoは設計図を見せて、作ってもらったデータベース接続の枠組み（インスタンス）
$pdo=db_conn($database_name, $host, $user, $database_password);
//sql文を作る
$sql="SELECT * FROM php7_user_table WHERE log_id=:log_id";
//prepareメソッドでPDOStatementクラスのインスタンスを取得する
$stmt = $pdo->prepare($sql);
//bindValueで無効化できるようにする
$stmt ->bindValue(":log_id",$log_id, PDO::PARAM_STR);
//実行
$status = $stmt->execute();


//確認
if($status ==false){
    sql_error($stmt);
}

//データ取得
$val = $stmt->fetch();

//第一引数は入力されたパスワード、第二引数はテーブル（レコード）から持ってきたhash化された文字列
$pw = password_verify($password,$val["password"]);
if($pw){    //if($pw==true)と同じ＝＝＝ログイン成功
    
    //idとセッションキーを照らし合わせながら各ページに入っていく
    $_SESSION["chk_ssid"]  = session_id();
    $_SESSION["u_id"]      = $val["id"];
    $_SESSION["n_name"]      = $val["n_name"];

    //リダイレクト
    redirect("top.php");
}
else{

    //ログイン失敗（logoutを経由して、リダイレクト?） idとpasswordのどちらが間違っているかは言わない
    //後で表示するためにセッションデータを持たせる
    $_SESSION["errorMessage"] = "ユーザー名またはパスワードが正しくありません";
    
    redirect("login.php");

}

exit();
