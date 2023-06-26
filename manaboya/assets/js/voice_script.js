// $(document).ready(function () {

//     // const recognition = new webkitSpeechRecognition();
//     const textElement = $('#chatgpt-message');

//     // recognition.onresult = function (event) {
//     //     const transcript = event.results[0][0].transcript;
//     //     transcriptElement.text(transcript);
//     // };

//     $('#recognition').click(function () {
//         // recognition.start();
//         event.preventDefault();
//         textElement.val("テスト");
//     });
// });
$(document).ready(function () {
    $("#recognition").click(function (event) {
        event.preventDefault();
        // ボタンを押下した際の処理

        alert('リンクがクリックされましたが、ページ遷移はキャンセルされました。');

        // テキストボックスの内容を変更する場合
        // var newMessage = "新しいメッセージ";
        // $("#chatgpt-message").val(newMessage);
    });
});
