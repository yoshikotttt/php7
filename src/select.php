<?php

session_start();

$u_id       = $_SESSION["u_id"];
$tooth_name = $_SESSION['tooth_name'];
$position   = $_SESSION['position'];

//関数とパスワードの取得
require('function.php');
require_once('config.php');

//SessionCheck関数をログインしないと見れないページ全てに入れる
sschk();
//DB接続後のdb_connをもらう
$pdo = db_conn($database_name, $host, $user, $database_password);


//テーブル同士をくっつけたいとき、表のようなものが必要なら下記を使う

// $sql = "SELECT * FROM php7_records_table
//         LEFT JOIN php7_img_table ON php7_records_table.u_id = php7_img_table.u_id AND php7_records_table.tooth_name = php7_img_table.tooth_name
//         LEFT JOIN php7_clinic_table ON php7_records_table.u_id = php7_clinic_table.u_id AND php7_records_table.tooth_name = php7_clinic_table.tooth_name
//         WHERE php7_records_table.u_id=:u_id AND php7_records_table.tooth_name=:tooth_name ";
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
// $stmt->bindValue(':tooth_name', $tooth_name, PDO::PARAM_STR);
// $status = $stmt->execute();

//今回は別々に取得して、それぞれのjsonDataを作る


//recordsからのデータ取得-------------------------------
$sql = "SELECT * FROM php7_records_table
         WHERE php7_records_table.u_id=:u_id AND php7_records_table.tooth_name=:tooth_name ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$stmt->bindValue(':tooth_name', $tooth_name, PDO::PARAM_STR);
$status = $stmt->execute();
//確認
$values = "";
if ($status == false) {
    sql_error($stmt);
}
//json
$records_v = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json_records = json_encode($records_v, JSON_UNESCAPED_UNICODE);


//imgからのデータ取得-----------------------------------
$sql = "SELECT * FROM php7_img_table
         WHERE php7_img_table.u_id=:u_id AND php7_img_table.tooth_name=:tooth_name ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$stmt->bindValue(':tooth_name', $tooth_name, PDO::PARAM_STR);
$status = $stmt->execute();
//確認
$values = "";
if ($status == false) {
    sql_error($stmt);
}
//json
$img_v = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json_img = json_encode($img_v, JSON_UNESCAPED_UNICODE);


//clinicからのデータ取得-----------------------------------
$sql = "SELECT * FROM php7_clinic_table
         WHERE php7_clinic_table.u_id=:u_id AND php7_clinic_table.tooth_name=:tooth_name ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$stmt->bindValue(':tooth_name', $tooth_name, PDO::PARAM_STR);
$status = $stmt->execute();
//確認
$values = "";
if ($status == false) {
    sql_error($stmt);
}
//json
$clinic_v = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json_clinic = json_encode($clinic_v, JSON_UNESCAPED_UNICODE);


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
    </style>
    <title>選択ページ</title>
    <style>
        .selected {
            background-color: #aad6ec;
            color: #000;
        }

        .img1 {
            width: 150px;
        }

        header {
            display: flex;
            justify-content: space-between;
            width: 400px;
            margin: auto;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .icons img {
            margin-left: 10px;
        }
    </style>
</head>

<body class="bg-sky-100">
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

    <!-- <div id="data_none " class="flex items-center justify-center h-screen ">
        <div class="text-center h-1/3">
            データが未登録です
        </div>
    </div> -->
    <div id="main">
        <div class="mt-10 mb-10">
            <div class="title text-center mb-14"></div>
            <div class="flex flex-col items-center">

                <div class="image img1"></div>


                <br>
                <div class="n_date"></div>
                <br>
                <div class="h_date"></div>
            </div>
        </div>
    </div>


    <div>
        <!-- タブのリスト -->
        <ul class="flex justify-center items-center gap-2 text-sm font-medium ">
            <!-- class1 タブ -->
            <li>
                <a href="#" class="class1 selected inline-flex cursor-pointer items-center gap-2 rounded-lg px-3 py-2 hover:bg-sky-200 text-gray-400 hover:text-gray-700">メモ</a>
            </li>
            <!-- class2 タブ -->
            <li>
                <a href="#" class="class2 inline-flex cursor-pointer items-center gap-2 rounded-lg px-3 py-2 hover:bg-sky-200 text-gray-400 hover:text-gray-700">受診履歴</a>
            </li>
        </ul>
        <!-- タブのコンテンツ -->
        <div class="py-3">
            <!-- class1 コンテンツ -->
            <div id="class1">
                <div id="memo1" class="hidden bg-amber-100 w-72 p-4 mx-auto my-4 rounded-md ">
                    <p class="text-sm text-gray-500 mb-2">抜けた日のメモ</p>
                    <div class="memo1"></div>
                </div>
                <div id="memo2" class="hidden bg-amber-100 w-72 p-4 mx-auto my-4 rounded-md">
                    <p class="text-sm text-gray-500 mb-2">生えた日のメモ</p>
                    <div class="memo2"></div>
                </div>
            </div>
            <div id="memo1-2" class=" text-center mt-10">
                <p class="">未登録</p>

            </div>
            <!-- class2 コンテンツ -->
            <div id="class2" class="hidden">
                <?php foreach ($clinic_v as $v) { ?>

                    <div class=" bg-amber-100 w-72 p-4 mx-auto my-4 rounded-md  ">
                        <div class="">
                            <?php $j_date = $v["j_date"];
                            $datetime = new Datetime($j_date);
                            $j_formattedDate = $datetime->format('Y年m月d日'); ?>
                            <?= h($j_formattedDate); ?>
                        </div>
                        <div class=""> <?= h($v["clinic_name"]); ?></div>
                    </div>
                <?php } ?>

                <div id="default_clinic" class=" text-center mt-10">
                    <p class="">データがありません</p>

                </div>


            </div>

        </div>

    </div>


    </div>
    <div class="flex mt-20">
        <a class="inline mx-auto " href="input.php?position=<?= h($position); ?>"><img src="../myimg/backIcon.png" width="60px" alt=""></a>
    </div>
    <footer class="py-4">
        <div class="container mx-auto mt-6">
            <p class="text-center text-xs">© su. All rights reserved.</p>
        </div>
    </footer>



    <script src="jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
    <script>
        // $(document).ready(function() {
        //     if (jsonDataImg.length === 0 && jsonDataClinic.length === 0 && jsonDataRecords.length === 0) {
        //         $('#main').hide();
        //         alert("データがありません");

        //     }
        // });

        //データをjsで使えるように呼び出す
        const jsonDataRecords = <?= ($json_records); ?>;
        console.log(jsonDataRecords);
        const jsonDataClinic = <?= ($json_clinic); ?>;
        console.log(jsonDataClinic);
        const jsonDataImg = <?= ($json_img); ?>;
        console.log(jsonDataImg);



        // for (let i = 0; i < jsonData.length; i++) {
        //     const value = jsonData[i].clinic_name;
        //     console.log(value);

        // }
        //欲しいデータを宣言
        const t_name = jsonDataRecords[0].tooth_name;
        const n_date = jsonDataRecords[0].n_date;
        const h_date = jsonDataRecords[0].h_date;
        const memo1 = jsonDataRecords[0].memo1;
        const memo2 = jsonDataRecords[0].memo2;

        //入力がなかった場合の設定をしないといけない（通常はしない動き）----------------

        // let img;
        // if (jsonDataImg.length > 0) {
        //     img = jsonDataImg[0].img;
        // } else {
        //     img = ""; // データが存在しない場合は空文字列として扱うなど、適切なデフォルト値をセットする
        // }

        // let t_name;
        // if (jsonDataRecords.length > 0) {
        //     img = jsonDataImg[0].tooth_name;
        // } else {
        //     t_name = ""; // データが存在しない場合は空文字列として扱うなど、適切なデフォルト値をセットする
        // }

        // let n_date;
        // if (jsonDataRecords.length > 0) {
        //     img = jsonDataImg[0].n_date;
        // } else {
        //     n_date = ""; // データが存在しない場合は空文字列として扱うなど、適切なデフォルト値をセットする
        // }

        // let h_date;
        // if (jsonDataRecords.length > 0) {
        //     img = jsonDataImg[0]. h_date;
        // } else {
        //     h_date = ""; // データが存在しない場合は空文字列として扱うなど、適切なデフォルト値をセットする
        // }

        // let memo1;
        // if (jsonDataRecords.length > 0) {
        //     img = jsonDataImg[0].memo1;
        // } else {
        //     memo1 = ""; // データが存在しない場合は空文字列として扱うなど、適切なデフォルト値をセットする
        // }
        // let memo2;
        // if (jsonDataRecords.length > 0) {
        //     img = jsonDataImg[0].memo2;
        // } else {
        //     memo2 = ""; // データが存在しない場合は空文字列として扱うなど、適切なデフォルト値をセットする
        // }



        //日付をY年ｍ月ｄ日にフォーマットしたデータ
        const n_formatDate = formatDate(n_date);
        const h_formatDate = formatDate(h_date);


        //抜けてから何日目かの計算
        const currentDate = new Date();
        const targetDate = new Date(n_date);
        const timeDiff = targetDate.getTime() - currentDate.getTime(); //日時の差分計算：ミリ秒
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)); //ミリ秒を日数に変換
        const daysRemaining = Math.abs(daysDiff); //日数を計算


        //読み込みと同時に実行される
        $(document).ready(function() {
            $(".title").text(t_name + "の記録");
            $(".memo1").text(memo1);
            $(".memo2").text(memo2);
            $(".n_date").text("抜けた日　" + n_formatDate);
            if (h_date !== null) {
                $(".h_date").text("生えた日　" + h_formatDate); //生えた日が入ってた場合
            } else {
                $(".h_date").text(`抜けてから　${daysRemaining}日`); //nullだった場合
            }

            //タブの設定
            $('#class2').hide();
            // クリックイベントの設定
            $('.class2').on('click', function() {
                $('#class1').hide(); // class1を非表示にする 
                $('.class1').removeClass("selected");
                $('#class2').show(); // class2を表示する
                $('.class2').addClass("selected");
            });
            $('.class1').on('click', function() {
                $('#class2').hide(); // class1を非表示にする  
                $('.class2').removeClass("selected");
                $('#class1').show(); // class2を表示する
                $('.class1').addClass("selected");
            });

            if (jsonDataClinic.length > 0) {
                $('#default_clinic').addClass("hidden");
            }

            if (jsonDataRecords[0].memo1 !== null && jsonDataRecords[0].memo1 !== "") {
                $('#memo1').removeClass("hidden");
                $('#memo1-2').addClass("hidden");
            }
            if (jsonDataRecords[0].memo2 !== null && jsonDataRecords[0].memo2 !== "") {
                $('#memo2').removeClass("hidden");
                $('#memo1-2').addClass("hidden");
            }
        });

        //画像表示
        const imageDir = "../images/"; // 画像のディレクトリパス
        const imageElement = $(".image"); // 画像を表示するimgタグの要素を取得

        // 非同期関数内でコードを実行 複数画像があっても、同じ場所にループで表示されるようにしている
        async function displayImages() {
            let currentIndex = 0; // 現在のインデックスを保持
            // ループ処理
            while (true) {
                if (jsonDataImg.length > 0) {
                    const imageName = jsonDataImg[currentIndex].img;
                    const imagePath = imageDir + imageName; // 画像のフルパス
                    const imgTag = $("<img>"); // <img>タグを動的に作成
                    imgTag.attr("src", imagePath);
                    imageElement.empty().append(imgTag);
                } else {
                    const defaultImagePath = "../myimg/default.png";
                    const defaultImgTag = $("<img>");
                    defaultImgTag.attr("src", defaultImagePath);
                    imageElement.empty().append(defaultImgTag);
                }

                // 画像の表示を一定時間待機する（例: 3秒）
                await new Promise((resolve) => setTimeout(resolve, 3000));
                // インデックスを次に進める（最後の要素なら最初に戻る）
                currentIndex = (currentIndex + 1) % jsonDataImg.length;
            }
        }
        // 非同期関数を呼び出し
        displayImages();
    </script>

</body>

</html>