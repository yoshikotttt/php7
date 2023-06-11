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
    <title>トップページ</title>
</head>

<body class="bg-sky-100">

    <!-- ヘッダー -->
    <header class="h-12 flex">
      
    </header>

    <!-- メインコンテンツ -->
    <main class="container mx-auto py-8 ">
        <p class="text-center mb-16 text-xl">新規登録</p>

        <form action="new_backend.php" method="post" class="max-w-sm mx-auto items-center">
            <div class="container space-y-4 px-12">

                <div class="text-center">
                    <p class="text-gray-600 pb-1 text-left pl-4">ログインID</p>
                    <input type="text" id="logIdInput" placeholder="例) neko1213" name="log_id" class="w-64 h-10 p-2 rounded-md">
                </div>
                <div class="text-center">
                    <p class="text-gray-600 pb-1 text-left pl-4">パスワード</p>
                    <input type="password" name="password" placeholder="4〜20文字の英数字" class="w-64 h-10 p-2 rounded-md">
                </div>
                <div class="text-center">
                    <p class="text-gray-600 pb-1 text-left pl-4">ニックネーム</p>
                    <input type="text" name="n_name" placeholder="例) てか" class="w-64 h-10 p-2  rounded-md">
                    <p class="text-gray-600 pb-1 text-xs text-left pl-4">(後から変更できます)</p>
                </div>
                <div class="text-center">
                    <p class="text-gray-600 pb-1 text-left pl-4">生年月日</p>
                    <input type="date" name="birthday" class="w-64 h-10 p-2 rounded-md">
                </div>
                <div class="text-center">
                    <input type="submit" id="submitBtn" value="上記の内容で登録する" class="bg-cyan-500  hover:bg-cyan-600 text-white font-bold py-3 px-4 rounded-md mt-14  mb-8 transition-colors duration-300">
                </div>
            </div>
        </form>

    </main>

    <!-- フッター -->
    <footer class="py-4">
        <div class="container mx-auto">
            <p class="text-center text-xs">© su. All rights reserved.</p>
        </div>
    </footer>
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ajaxリクエストを送信して重複チェックを行う
            $("#submitBtn").on("click", function() {
                // alert("ok");
                event.preventDefault(); //フォーム送信をキャンセルしている

                const logId = $("#logIdInput").val();

                $.ajax({
                    type: "POST",
                    url: "new_check.php", // 重複チェックを行うPHPファイルのパス
                    data: {
                        log_id: logId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.duplicate) {
                            alert("ログインIDが既に使用されています");
                        } else {
                           $("form").submit(); //フォームを送信
                        }
                    },
                    error: function() {
                        alert("エラーが発生しました");
                    }
                });
            });
        });
    </script>
</body>

</html>