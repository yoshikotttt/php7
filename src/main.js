// モーダルを表示させる
function openModal(buttonSelector, modalSelector) {
    $(buttonSelector).on("click", function() {
        $('#overlay,' + modalSelector).fadeIn();
    });
}

// モーダルを非表示にする
function closeModal(buttonSelector, modalSelector) {
    $(buttonSelector).on('click', function() {
        $('#overlay, ' + modalSelector).fadeOut();
    });
}

// 日付フォーマットを変換する関数
  function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = ("0" + (date.getMonth() + 1)).slice(-2);
    const day = ("0" + date.getDate()).slice(-2);
    return year + "年" + month + "月" + day + "日";
}