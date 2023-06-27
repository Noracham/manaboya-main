jQuery(document).ready(function ($) {
    jQuery("#recognition").click(function (event) {
        event.preventDefault();
        // ボタンを押下した際の処理

        // テキストボックスの内容を変更する場合
        var newMessage = "新しいメッセージ";
        $("#chatgpt-message").val(newMessage);
    });
});
