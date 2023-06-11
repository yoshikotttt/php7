<?php




//関数とパスワードの取得
require('function.php');
require_once('config.php');

//入力チェック
//一つ目はタイトルが送信されていない場合、２つめは送信されたが中身が空の場合
if (!isset($_POST["log_id"]) || $_POST["log_id"] == "") {
    exit("ParamError:log_id");
}


$log_id      = $_POST["log_id"];

//db接続
$pdo = db_conn($database_name, $host, $user, $database_password);

//重複確認
$sql = "SELECT COUNT(*) AS count FROM php7_user_table WHERE log_id = :log_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":log_id", $log_id, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


$response = array();

if ($row["count"] > 0) {
    $response["duplicate"] = true; // ログインIDが重複している場合はtrueを返す
} else {
    $response["duplicate"] = false; // ログインIDが重複していない場合はfalseを返す
}

echo json_encode($response);
