<?php

session_start();

//エラーメッセージのセッションデータがあるか確認、なくてもエラーにならないようにあることにする
if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
} else {
    $errorMessage = ""; // エラーメッセージがない場合は空文字列にする
}

//関数読み込み
require('function.php');
require_once('config.php');

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
    </style>
    <title>ログイン</title>
</head>

<body class="bg-sky-200">

    <!-- ヘッダー -->
    <header class="h-12 flex">
       
    </header>

    <!-- メインコンテンツ -->
    <main class="container mx-auto py-8 ">
        <p class="text-center mb-16 mt-14 text-xl">ログイン</p>

        <form action="login_backend.php" method="post" class="max-w-sm mx-auto items-center">
            <div class="container space-y-4 px-12">

            <!-- エラーメッセージがあれば表示される、なくても空文字列が表示されている -->
               <div class="text-blue-600 pb-1 text-center pl-4 text-xs"><?=h($errorMessage);?></div>
                <div class="text-center">
                    <p class="text-gray-600 pb-1 text-left pl-4">ログインID</p>
                    <input type="text" name="log_id" placeholder="ログインID" class="w-64 h-10 p-2 rounded-md">
                </div>
                <div class="text-center">
                    <p class="text-gray-600 pb-1 text-left pl-4">パスワード</p>
                    <input type="password" name="password" placeholder="パスワード" class="w-64 h-10 p-2 rounded-md">
                </div>

                <div class="text-center">
                    <input type="submit" value="ログインする"
                        class="bg-cyan-500  hover:bg-cyan-600 text-white font-bold py-3 px-4 rounded-md mt-14  mb-8 transition-colors duration-300">
                </div>
            </div>
        </form>
        <div>
            <p class="text-center mt-3 text-sm">
                新規会員登録は
                <a href="new.php" class="underline text-cyan-600">こちら</a>
            </p>
        </div>
    </main>

    <!-- フッター -->
    <footer class="py-4">
        <div class="container mx-auto mt-5">
            <p class="text-center text-xs">© su. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>