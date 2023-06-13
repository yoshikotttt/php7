<?php

session_start();

$id = $_SESSION["u_id"];


//関数とパスワードの取得
require('function.php');
require_once('config.php');

//SessionCheck関数をログインしないと見れないページ全てに入れる
sschk();


//DB接続後のdb_connをもらう
$pdo = db_conn($database_name, $host, $user, $database_password);

//データ取得
$sql = "SELECT * FROM php7_user_table
         WHERE php7_user_table.id=:id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//確認
$values = "";
if ($status == false) {
    sql_error($stmt);
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$json_records = json_encode($row, JSON_UNESCAPED_UNICODE);



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Zen Maru Gothic', sans-serif;
        }
        header {
            display: flex;
            justify-content: space-around;
            width: 400px;
            margin: auto;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .icons img{
            margin-left: 10px;
        }
    </style>
    <title>マイページ</title>
</head>

<body class="bg-sky-200">

    <!-- オーバーレイ -->
    <div id="overlay" class="hidden fixed top-0 left-0 bg-black bg-opacity-50 w-full h-full z-10"></div>

    <!-- モーダルウィンドウ1 -->
    <div class="modal-window1 hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-140 bg-rose-100 rounded-md z-20 p-8">

        <div class="flex flex-col items-center">
            <form action="mypage_backend.php" method="post">
                <input type="hidden" name="id" value="<?= ($id); ?>">
                <div class="flex flex-col items-center mt-4">
                    <label for="n_name" class="text-gray-600 pb-1 pl-4 text-center  mb-5">ニックネーム</label>
                    <input type="text" name="n_name"  class="m-auto w-64 h-10 p-2 rounded-md">
                </div>
                <!-- <div class="flex flex-col items-center mt-4">
                    <label for="birthday" class="text-gray-600 pb-1 pl-4 text-center  mb-5">生年月日</label>
                    <input type="date" name="birthday"  class="m-auto w-64 h-10 p-2 rounded-md">
                </div> -->
                <div class="flex justify-center mt-10">
                    <input type="submit" value="登録" class="bg-rose-300 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
                </div>
            </form>
            <div class="flex justify-center">
                <input type="submit" value="キャンセル" class="close1 bg-gray-400 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
            </div>
        </div>
    </div>


    <!-- ヘッダー -->
 
    <header class="h-13 ">
        <div class="logo items-center">
            <a href=top.php><img src="../myimg/logo.png" class="" width="60px" alt=""></a>
        </div>
        <div class="icons flex items-center">
            <a href="top.php"><img src="../myimg/homeIcon.png" width="30px" alt=""></a>
            <a href="mypage.php"><img src="../myimg/manIcon.png" width="30px" alt=""></a>
            <a href="logout.php"><img src="../myimg/logoutIcon.png" width="30px" alt=""></a>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="container mx-auto py-8 ">
        <p class="text-center mb-16 mt-14 text-xl">マイページ</p>

        <div class="container space-y-4 px-12">
            <div class="flex flex-col">
                <div class=" text-center">
                    <p class="text-gray-600 pb-1 mb-3  text-sm">ニックネーム</p>
                    <p class="mb-8  pb-2"><?= h($row["n_name"]); ?></p>
                 
                </div>
                <div class="text-center">
                    <p class="text-gray-600 pb-1 mb-3  text-sm">生年月日</p>
                    <div class="mb-20">
                        <?php $birthday = $row["birthday"];
                        $datetime = new Datetime($birthday);
                        $b_formattedDate = $datetime->format('Y年m月d日'); ?>
                        <?= h($b_formattedDate); ?>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="button-open1 nuketa bg-cyan-500  hover:bg-cyan-600 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">修正する</div>
                <a href="top.php"><div class="button-open2 haeta bg-gray-400   hover:bg-gray-600  text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">戻る</div></a>
            </div>
        </div>

    </main>
  

    <!-- フッター -->
    <footer class="py-4">
        <div class="container mx-auto mt-5">
            <p class="text-center text-xs">© su. All rights reserved.</p>
        </div>
    </footer>
    <script src="jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
    <script>
        //モーダルの表示と非表示
        $(function() {
            openModal(".button-open1", '.modal-window1');
            closeModal(".close1", ".modal-window1");
        });
    </script>
</body>

</html>