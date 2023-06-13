<?php

session_start();

$n_name = $_SESSION["n_name"];
$u_id = $_SESSION["u_id"];

//関数とパスワードの取得
require('function.php');
require_once('config.php');

$tooth_name_array = array(
    "0-2" => "上　右　乳側切歯（B)",
    "0-3" => "上　右　乳中切歯（A)",
    "0-4" => "上　左　乳中切歯（A)",
    "0-5" => "上　左　乳側切歯（B)",
    "1-1" => "上　右　乳犬歯（C)",
    "1-6" => "上　左　乳犬歯（C)",
    "2-0" => "上　右　第一乳臼歯（D)",
    "2-1" => "上　右　第一乳臼歯（D)",
    "2-6" => "上　左　第一乳臼歯（D)",
    "2-7" => "上　左　第一乳臼歯（D)",
    "3-0" => "上　右　第二乳臼歯（E)",
    "3-1" => "上　右　第二乳臼歯（E)",
    "3-6" => "上　左　第二乳臼歯（E)",
    "3-7" => "上　左　第二乳臼歯（E)",
    "5-0" => "下　右　第二乳臼歯（E)",
    "5-1" => "下　右　第二乳臼歯（E)",
    "5-6" => "下　左　第二乳臼歯（E)",
    "5-7" => "下　左　第二乳臼歯（E)",
    "6-0" => "下　右　第二乳臼歯（E)",
    "6-1" => "下　右　第二乳臼歯（E)",
    "6-6" => "下　左　第二乳臼歯（E)",
    "6-7" => "下　左　第二乳臼歯（E)",
    "7-0" => "下　右　第一乳臼歯（D)",
    "7-1" => "下　右　第一乳臼歯（D)",
    "7-6" => "下　左　第一乳臼歯（D)",
    "7-7" => "下　左　第一乳臼歯（D)",
    "8-1" => "下　右　乳犬歯（C)",
    "8-6" => "下　左　乳犬歯（C)",
    "9-2" => "下　右　乳側切歯（B)",
    "9-3" => "下　右　乳中切歯（B)",
    "9-4" => "下　左　乳中切歯（B)",
    "9-5" => "下　左　乳側切歯（B)"
);


//position=0-3がパラメータ positionがパラメータのキーであり、0-3がその値
$position = $_GET['position'];

$tooth_name = $tooth_name_array[$position] ?? "";
$_SESSION['tooth_name'] = $tooth_name;
$_SESSION['position'] = $position;



?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            justify-content: space-between;
            width: 400px;
            margin: auto;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .icons img{
            margin-left: 10px;
        }
    </style>
    <title>記録</title>
</head>

<body class="bg-sky-200">

    <!-- オーバーレイ -->
    <div id="overlay" class="hidden fixed top-0 left-0 bg-black bg-opacity-50 w-full h-full z-10"></div>

    <!-- モーダルウィンドウ1 抜けた日-->
    <div class="modal-window1 hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-140 bg-rose-100 rounded-md z-20 p-8">

        <div class="flex flex-col items-center">
            <form action="input_back1.php" method="post">
                <input type="hidden" name="u_id" value="<?= ($u_id); ?>">
                <input type="hidden" name="tooth_name" value="<?= ($tooth_name); ?>">
                <div class="flex flex-col items-center mt-4">
                    <label for="n_date" class="text-gray-600 pb-1 pl-4 text-center  mb-5">抜けた日</label>
                    <input type="date" name="n_date" class="m-auto w-64 h-10 p-2 rounded-md">
                </div>
                <div class="flex flex-col items-center mt-10">
                    <textarea id="text" rows="4" cols="31" name="memo1" placeholder="メモ欄" class="placeholder-slate-400 rounded-md p-2"></textarea>
                </div>

                <div class="flex justify-center mt-10">
                    <input type="submit" value="登録" class="bg-rose-300 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
                </div>
            </form>
            <div class="flex justify-center">
                <input type="submit" value="キャンセル" class="close1 bg-gray-400 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
            </div>
        </div>
    </div>

    <!-- モーダルウィンドウ2 生えた日-->
    <div class="modal-window2 hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-140 bg-rose-100 rounded-md z-20 p-8">

        <div class="flex flex-col items-center">
            <form action="input_back2.php" method="post">
            <input type="hidden" name="u_id" value="<?= ($u_id); ?>">
                <input type="hidden" name="tooth_name" value="<?= ($tooth_name); ?>">
                <div class="flex flex-col items-center mt-4">
                    <label for="h_date" class="text-gray-600 pb-1 pl-4 text-center  mb-5">生えた日</label>
                    <input type="date" name="h_date" class="m-auto w-64 h-10 p-2 rounded-md">
                </div>
                <div class="flex flex-col items-center mt-10">
                    <textarea id="text" rows="4" cols="31" name="memo2" placeholder="メモ欄" class="placeholder-slate-400 rounded-md p-2"></textarea>
                </div>

                <div class="flex justify-center mt-10">
                    <input type="submit" value="登録" class="bg-rose-300 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
                </div>
            </form>
            <div class="flex justify-center">
                <input type="submit" value="キャンセル" class="close2 bg-gray-400 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
            </div>
        </div>
    </div>

    <!-- モーダルウィンドウ3 受診記録-->
    <div class="modal-window3 hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-140 bg-rose-100 rounded-md z-20 p-8">

        <div class="flex flex-col items-center">
            <form action="input_clinic.php" method="post">
                <input type="hidden" name="tooth_name" value="<?= ($tooth_name); ?>">
                <p class="text-gray-600 pb-1 pl-4 text-center  mb-5">受診記録</p>
                <div class="flex flex-col items-center mt-4">
                    <label for="j_date" class="text-gray-600 pb-1 pl-4 text-left mr-auto mb-1 text-sm">受診日</label>
                    <input type="date" name="j_date" class="m-auto w-64 h-10 p-2 rounded-md">
                </div>
                <div class="flex flex-col items-center mt-4">
                    <label for="clinic_name" class="text-gray-600 pb-1 pl-4 text-left mr-auto mb-1 text-sm">医院名</label>
                    <input type="text" name="clinic_name" class="m-auto w-64 h-10 p-2 rounded-md">
                </div>
                <div class="flex flex-col items-center mt-4">
                    <label for="payment" class="text-gray-600 pb-1 pl-4 text-left mr-auto mb-1 text-sm">費用</label>
                    <input type="number" name="payment" class="m-auto w-64 h-10 p-2 rounded-md">
                </div>
                <div class="flex flex-col items-center mt-10">
                    <textarea id="text" rows="4" cols="31" name="c_memo" placeholder="メモ欄" class="placeholder-slate-400 rounded-md p-2"></textarea>
                </div>

                <div class="flex justify-center mt-10">
                    <input type="submit" value="登録" class="bg-rose-300 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
                </div>
            </form>
            <div class="flex justify-center">
                <input type="submit" value="キャンセル" class="close3 bg-gray-400 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
            </div>
        </div>
    </div>

    <!-- モーダルウィンドウ4 画像-->
    <div class="modal-window4 hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-140 bg-rose-100 rounded-md z-20 p-8">

        <div class="flex flex-col items-center">
            <form action="input_img.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="tooth_name" value="<?= ($tooth_name); ?>">
                <input type="file" name="img" accept=".png,.jpg,.jpeg,.pdf,.doc">
            <p class="img_style flex justify-center mx-auto"><img src="" alt="" width="150px"></p>

                <div class="flex justify-center mt-10">
                    <input type="submit" value="登録" class="bg-rose-300 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
                </div>
            </form>
            <div class="flex justify-center">
                <input type="submit" value="キャンセル" class="close4 bg-gray-400 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">
            </div>
        </div>
    </div>


    <!-- 最初から見えている部分 -->

  
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

    <p class="text-center mt-20 mb-16"><?= ($tooth_name); ?></p>
    <div class="flex flex-wrap justify-center">
        <div class="button-open1 nuketa bg-cyan-600 hover:bg-cyan-700 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">歯が抜けた</div>
        <div class="button-open2 haeta bg-cyan-600 hover:bg-cyan-700  text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">歯が生えた</div>
        <div class="button-open3 clinic-data bg-cyan-600 hover:bg-cyan-700 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">受診記録</div>
        <div class="button-open4 img-data bg-cyan-600  hover:bg-cyan-700 text-white text-sm text-center px-0 w-36 py-3 rounded-md m-2 mb-4">画像を追加</div>
    </div>
    <div class="mx-auto bg-blue-600 hover:bg-blue-800 text-white text-sm text-center px-0 w-40 py-3 rounded-md m-2 mt-8"><a href="select.php?id=<?= h($u_id) ?>">この歯の記録を見る</a></div>



    <!-- フッター -->
    <footer class="py-4">
        <div class="container mx-auto mt-24">
            <p class="text-center text-xs">© su. All rights reserved.</p>
        </div>
    </footer>








    <script src="jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
    <script>
        $('input[type=file]').change(function() {
            const file = $(this).prop('files')[0];
            if (!file.type.match('image.*')) {
                $(this).val('');
                $('.img_style > img').html('');
                return;
            }

            const reader = new FileReader();
            reader.onload = function() {
                $('.img_style > img').attr('src', reader.result);
            };
            reader.readAsDataURL(file);
        });
    </script>
    <script>
        //モーダルの表示と非表示
        $(function() {
            openModal(".button-open1", '.modal-window1');
            closeModal(".close1", ".modal-window1");
        });

        $(function() {
            openModal(".button-open2", '.modal-window2');
            closeModal(".close2", ".modal-window2");
        });

        $(function() {
            openModal(".button-open3", '.modal-window3');
            closeModal(".close3", ".modal-window3");
        });

        $(function() {
            openModal(".button-open4", '.modal-window4');
            closeModal(".close4", ".modal-window4");
        });
    </script>
</body>

</html>