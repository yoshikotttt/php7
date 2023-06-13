<?php

//新規登録用


//関数とパスワードの取得
require('function.php');
require_once('config.php');

//入力チェック
//一つ目はタイトルが送信されていない場合、２つめは送信されたが中身が空の場合
if (!isset($_POST["log_id"]) || $_POST["log_id"] == "") {
    exit("ParamError:log_id");
}

if (!isset($_POST["password"]) || $_POST["password"] == "") {
    exit("ParamError:password");
}

if (!isset($_POST["n_name"]) || $_POST["n_name"] == "") {
    exit("ParamError:n_name");
}


//データ取得 別のやり方

// $log_id   = filter_input(INPUT_POST, "log_id");
// $password  = filter_input(INPUT_POST, "password");
// $n_name      = filter_input(INPUT_POST, "n_name");
// $password  = password_hash($password, PASSWORD_DEFAULT); //ハッシュ化


$log_id      = $_POST["log_id"];
$password    = $_POST["password"];
$n_name      = $_POST["n_name"];
$birthday    = $_POST["birthday"];
$password    = password_hash($password, PASSWORD_DEFAULT); //ハッシュ化

//db接続
$pdo = db_conn($database_name, $host, $user, $database_password);

//SQL作成 -> $pdo使ってprepareメソッドでインスタンス化 -> bindValueで無効化できるように -> execute!
$sql  = "INSERT INTO php7_user_table(log_id,password,n_name,birthday)VALUES(:log_id,:password,:n_name,:birthday)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":log_id", $log_id,   PDO::PARAM_STR);
$stmt->bindValue(":password", $password,  PDO::PARAM_STR);
$stmt->bindValue(":n_name", $n_name,      PDO::PARAM_STR);
$stmt->bindValue(":birthday", $birthday, PDO::PARAM_STR);
$status = $stmt->execute();

//確認
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("login.php");
}
