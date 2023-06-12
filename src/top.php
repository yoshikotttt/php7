<?php

session_start();

$n_name = $_SESSION["n_name"];
$u_id = $_SESSION["u_id"];


//関数とパスワードの取得
require('function.php');
require_once('config.php');

//SessionCheck関数をログインしないと見れないページ全てに入れる
sschk();




//選択されたidを取得
// $select_id = $_GET["id"];


//DB接続後のdb_connをもらう
$pdo = db_conn($database_name, $host, $user, $database_password);

//データ取得SQL作成
$sql = "SELECT * FROM php7_records_table WHERE u_id=:u_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$status = $stmt->execute();

//確認
$values = "";
if ($status == false) {
    sql_error($stmt);
}

$low = $stmt->fetchAll();
$json = json_encode($low, JSON_UNESCAPED_UNICODE);



$sql = "SELECT * FROM php7_user_table WHERE id=:u_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$status = $stmt->execute();

//確認
$values = "";
if ($status == false) {
    sql_error($stmt);
}

$b_data = $stmt->fetch();


// 誕生日からの計算
$currentDate = date('Y-m-d');

// 誕生日のデータを取得
$birthday = $b_data["birthday"]; // 誕生日のデータをここに代入してください

// 年齢と月数を計算
$diff = date_diff(date_create($birthday), date_create($currentDate));
$ageYears = $diff->y; // 年齢（年）
$ageMonths = $diff->m; // 年齢（月）

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


        #container>div {
            /* ボーダーはここで消す */
            /* border: 0.5px solid #a19c9c;  */
            font-size: 1px;

            /* width: 100px;
        height: 100px; */
        }


        #container {
            margin: auto;
            display: grid;
            grid-template-columns: repeat(8, 30px);
            grid-template-rows: repeat(10, 30px);
            background-image: url(../myimg/tooth5.png);
            background-size: 240px 300px;
            background-repeat: no-repeat;
            background-position: center;
            justify-content: center;
            align-items: center;
        }

        .cell {
            position: relative;
            cursor: pointer;
            height: 30px;
            color: #dff1fe;
            opacity: 0.8;


        }



        .image-container {
            position: absolute;
            top: 0;
            left: 0;
        }

        .image {
            height: 30px;
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
    <title>TOP</title>
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
    <div class="">
        <div class="text-x1 font-bold text-center mt-5"><?= h($n_name); ?>さんの歯　　<?= h($ageYears); ?>歳<?= h($ageMonths); ?>ヶ月</div>
        <div class="text-center  text-gray-500 mt-4 font-bold text-sm" id="today-date"><?php echo date('Y年m月d日'); ?></div>

        <div class="mt-10 mb-5 text-center text-gray-500">歯をタップして記録</div>
    </div>

    <div id="container"></div>
    <!-- <div id="container" class=" mx-auto grid grid-cols-8 grid-rows-10 bg-[url(../myimg/tooth1.png] bg-no-repeat bg-cover w-[280px] h-[350px] sm:w-auto sm:h-auto"></div> -->

    <div class="flex items-center justify-center mt-8 ">
        <img src="../myimg/already.png" alt="" width="30px">
        <div class="ml-4 mt-10 mb-10 text-center text-gray-500 text-sm">生え変わり済み</div>
    </div>
    <div class="flex items-center justify-center ">
        <img src="../myimg/new.png" alt="" width="30px">
        <div class="ml-4 mt-2 mb-5 text-center text-gray-500 text-sm">生えるの待ち</div>
    </div>



    <footer class="py-4">
        <div class="container mx-auto mt-20">
            <p class="text-center text-xs">© su. All rights reserved.</p>
        </div>
    </footer>
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        //jsで作った要素に関する動きは、$(document).ready(function() {この中に全部書く})
        $(document).ready(function() {
            const jsonData = <?= ($json); ?>;
            // console.log(jsonData);

            const container = $("#container");

            //個別のIDを持ったセルを80個作る、配置はgrid
            for (let i = 0; i < 10; i++) {
                for (let j = 0; j < 8; j++) {

                    const cell = $("<div>").addClass('cell').attr("id", `cell-${i}-${j}`);
                    cell.text(`${i}-${j}`);
                    container.append(cell);

                    const cellValue = `${i}-${j}`;
                    const cellData = jsonData.filter(item => item[3] === cellValue);
                    // ここでセルにデータを追加するなどの処理を行います
                    // console.log(cellData);


                    // const filteredData = jsonData.filter(item => item.h_date === null);
                    // console.log(filteredData);
                    if (cellData.length > 0) {
                        cellData.forEach(data => {
                            const imageContainer = $("<div>").addClass('image-container');
                            const image = $("<img>").addClass("image opacity-50").attr("src", data.h_date == null ? "../myimg/new.png" : "../myimg/already.png").attr("alt", "Image");
                            imageContainer.append(image);
                            cell.append(imageContainer);
                        });
                    }
                }
            }



            //クリックイベント セルの番号をtextとして取得、URLのクエリパラメータとして渡す（埋め込む）
            $(".cell").on("click", function() {

                const position = $(this).text();
                console.log(position);
                if (position !== "0-2" &&
                    position !== "0-3" &&
                    position !== "0-4" &&
                    position !== "0-5" &&
                    position !== "1-1" &&
                    position !== "1-6" &&
                    position !== "2-0" &&
                    position !== "2-1" &&
                    position !== "2-6" &&
                    position !== "2-7" &&
                    position !== "3-0" &&
                    position !== "3-1" &&
                    position !== "3-6" &&
                    position !== "3-7" &&
                    position !== "5-0" &&
                    // position !== "5-1" &&
                    // position !== "5-6" &&
                    position !== "5-7" &&
                    position !== "6-0" &&
                    position !== "6-1" &&
                    position !== "6-6" &&
                    position !== "6-7" &&
                    position !== "7-0" &&
                    position !== "7-1" &&
                    position !== "7-6" &&
                    position !== "7-7" &&
                    position !== "8-1" &&
                    position !== "8-6" &&
                    position !== "9-2" &&
                    position !== "9-3" &&
                    position !== "9-4" &&
                    position !== "9-5"
                ) {
                    return;
                }

                const url = `input.php?position=${encodeURIComponent(position)}`;
                console.log(url);
                window.location.href = url;

            });
        });

        //if文で書くとこう
        // if (data.h_date == null) {
        //   const image = $("<img>").addClass('image').attr("src", "./myimg/poti.png").attr("alt", "Image");
        //   cell.append(image);
        //   }else{
        //    const image = $("<img>").addClass('image').attr("src", "./myimg/icon.png").attr("alt", "Image");
        //    cell.append(image);
        //   }
    </script>
</body>

</html>