jQuery(document).ready(function ($) {
    var recognition;
    var isListening = false;

    function startRecognition() {
        recognition = new webkitSpeechRecognition() || new SpeechRecognition();
        recognition.lang = 'ja-JP';

        recognition.continuous = true;

        recognition.onresult = function (event) {
            var result = event.results[event.results.length - 1][0].transcript;
            $('#FlexTextarea').val(function (_, text) {
                return text + ' ' + result;
            });
        };

        recognition.start();
        isListening = true;
        $('#recognition').html('<img src="https://manaboya.net/wp-content/themes/manaboya/assets/img/pause-circle-outline.svg">ストップ');
    }

    function stopRecognition() {
        if (recognition) {
            recognition.stop();
            isListening = false;
            $('#recognition').html('<img src="https://manaboya.net/wp-content/themes/manaboya/assets/img/mic-outline.svg">こえできく');
        }
    }

    $('#recognition').click(function () {
        if (isListening) {
            stopRecognition();
        } else {
            startRecognition();
        }
    });
});

    // jQuery("#recognition").click(function (event) {
    //     event.preventDefault();
    //     // ボタンを押下した際の処理
    //     SpeechRecognition = webkitSpeechRecognition || SpeechRecognition;
    //     const recognition = new SpeechRecognition();

    //     if (recognition.continuous) {
    //         recognition.continuous = false;
    //         return;
    //     } else {
    //         recognition.continuous = true;
    //     }

    //     recognition.start();

    //     recognition.onresult = (event) => {
    //         var result = event.results[event.results.length - 1][0].transcript; // 最後に認識された音声のテキストを取得します。
    //         $('#FlexTextarea').val(function (_, text) {
    //             return text + ' ' + result; // テキストエリアに追加します。
    //         });
    //     }

    // $("#FlexTextarea").val(event.results[0][0].transcript);

    // テキストボックスの内容を変更する場合
    // var newMessage = "新しいメッセージ";
    // $("#chatgpt-message").val(newMessage);
