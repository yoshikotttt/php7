<?php


//接続用 新しいインスタンスを作成
function db_conn($database_name, $host, $user, $database_password)
{
    try {
        return  new PDO("mysql:dbname={$database_name};charset=utf8mb4;host={$host}", $user, $database_password); //$pdoにデータが入ってくる
    } catch (PDOException $e) {
        exit('DBConnectError:' . $e->getMessage());
    }
}

// function db_conn(){
//     try {
//         $db_name = "gs_db3";    //データベース名
//         $db_id   = "root";      //アカウント名
//         $db_pw   = "root";          //パスワード
//         $db_host = "localhost"; //DBホスト
//         return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
//     } catch (PDOException $e) {
//         exit('DB Connection Error:'.$e->getMessage());
//     }
//     }

//SQLエラー関数 :sql_error($stmt) //$stmtもらってこないと空っぽ
function sql_error($stmt)
{
    $error = $stmt->errorInfo();
    exit("SQLError:" . $error[2]);
}

//リダイレクト関数:redirect($file_name)
function redirect($page)
{
    header("Location: " . $page);
    exit();
}

//XSS
function h($val)
{
    return htmlspecialchars($val, ENT_QUOTES);
}


//SessionCheck
//SessionID持っていて、合っていなかったらエラー、合っていれば新しいSession IDがもらえる
function sschk()
{
    if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
        exit("Login Error");
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}


//fileUpload("送信名","アップロード先フォルダ");
//$pathは置きたい先のファイル名
function fileUpload($fname,$path){
    //errorが１、2の時何かしらのエラーで送信できていない
if (isset($_FILES[$fname] ) && $_FILES[$fname]["error"] ==0 ) {
//ファイル名取得
$file_name = $_FILES[$fname]["name"];
//一時保存場所取得 /home/tmp/1.jpg
$tmp_path  = $_FILES[$fname]["tmp_name"];

//--------------------同じ名前のファイルが被らないようにするための２行
//拡張子取得 "jpg","png"
$extension = pathinfo($file_name, PATHINFO_EXTENSION);
//ユニークファイル名作成  現在の時間＋セッションID で同じになることがあり得ない状態を作る
//md5でセッションIDをハッシュ化し、直で見えないようにしている
$file_name = date("YmdHis").md5(session_id()) . "." . $extension;
//---------------------------------------------------


// FileUpload [--Start--]
$file_dir_path = $path.$file_name; // upload/....jpgみたいなの
if ( is_uploaded_file( $tmp_path ) ) {
  //$tmp_pathから、$file_dir_pathに動かす
    if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {
      //0644はブラウザに表示できる権限
        chmod( $file_dir_path, 0644 );
        return $file_name; //成功時：新しくなったファイル名を返す
    } else {
        return 1; //失敗時：ファイル移動に失敗
    }
}
}else{
 return 2; //失敗時：ファイル取得エラー
 // if (isset($_FILES[$fname] ) && $_FILES[$fname]["error"] ==0 )が間違っているということ
}
}

