<?php
function load_my_styles()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('ress', get_template_directory_uri() . '/assets/css/ress.css', array("style"));
    wp_enqueue_style('googlefonts', 'https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@300;400;500;600;700&family=Potta+One&display=swap');

    wp_enqueue_script("jquery");
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/index.js', array("jquery"));
    wp_enqueue_script('inview', '//cdnjs.cloudflare.com/ajax/libs/protonet-jquery.inview/1.1.2/jquery.inview.min.js', array("jquery"));
}
add_action('wp_enqueue_scripts', 'load_my_styles');

//ログイン後のリダイレクト
add_filter('wpmem_login_redirect', 'my_login_redirect', 10, 2);
function my_login_redirect($redirect_to, $user_id)
{
    return home_url();
}

//wpmem スタイリング用
add_filter('wpmem_register_form_args', 'my_register_form_row_wrapper', 10, 2);
function my_register_form_row_wrapper($args, $tag)
{
    $args = array(
        'row_before' => '<div class="form_custom d-flex">',
        'row_after'  => '</div>',
    );

    return $args;
}

//ログアウト後リダイレクト
function logout_redirect()
{
    wp_safe_redirect("https://manaboya.net/?page_id=74");
    exit();
}
add_action('wp_logout', 'logout_redirect');

//jsファイルを作成するときはここで登録
function add_custom_scripts()
{
    // jQueryを登録する
    wp_enqueue_script('jquery');

    // ポップアップスクリプトを登録する
    wp_register_script('popup_script', get_template_directory_uri() . '/assets/js/popup_script.js', array('jquery'), '1.0', true);

    // ポップアップスクリプトを読み込む
    wp_enqueue_script('popup_script');

    // 音声認識スクリプトを登録する
    wp_register_script('voice_script', get_template_directory_uri() . '/assets/js/voice_script.js', array('jquery'), '1.0', true);

    // 音声認識スクリプトを読み込む
    wp_enqueue_script('voice_script');
}
add_action('wp_enqueue_scripts', 'add_custom_scripts');


//chatgpt

//ショートコードで'chatgpt'と呼び出すと'chatgpt_shortcode'実行
add_shortcode('chatgpt', 'chatgpt_shortcode');

function chatgpt_shortcode($atts = [], $content = null)
{
    $content .= '<script>
        jQuery(document).ready(function($) {
            //処理中用テキスト
            var processingText = \'<div id="processing" class="chatgpt-message chatgpt-message-bot"><div class="chatgpt-message-text">...</div></div>\';

            //処理中のフラグを立てる
            var isProcessing = true;
            //初期設定開始確認用
            console.log("初期設定中");
            // ボタンを無効化
            $("#chatgpt-submit").prop("disabled", true);

            //初期設定()
            var message = "あなたは「まな坊や君」です。これから「まな坊や君」に成り切って私とチャットをしてください。";

            message += "設定は以下の通りです。";
            message += "・一人称は僕";
            message += "・元気で優しい男の子";
            message += "・あなたは難しい言葉や漢字をあまり使わず、ふんわりとした表現をする。";
            message += "・話し言葉であり、あえて敬語を使わないフレンドリーな言葉で話す。";
            message += "・〇〇ぜ！やおっす！などの言葉遣いはしない。";
            
            message += "設定は常に有効です。このチャットに対しての返答は、";
            message += "「こんにちは！僕の名前はまな坊や君だよ！なにか質問があれば言ってね！」のみでよい";
            
            //処理中テキスト表示
            $("#chatgpt-messages").append(processingText);
            
            $.ajax({
                url: "' . admin_url('admin-ajax.php') . '",
                type: "POST",
                data: {
                    action: "first_chatgpt_ajax",
                    message: message
                }
                ,
                success: function(response) {
                    var html = \'<div class="chatgpt-message chatgpt-message-bot"><div class="chatgpt-message-text">こんにちは！僕の名前はまな坊や君だよ！なにか質問があれば言ってね！</div></div>\';
                    $("#chatgpt-messages").append(html);
                },
                error: function (e) {
                  console.log(e + "エラーが起きました");
                },
            }).always(function() {
                // このコードは常に実行されます
                
                //初期設定開始確認用
                console.log("初期設定終了");
                $("#processing").remove();
                //メッセージ初期化(無くてもいいはず...一応)
                message = "";
                // 処理中のフラグを解除
                isProcessing = false;
                // ボタンを再度有効化
                $("#chatgpt-submit").prop("disabled", false); 
            });

            //送信ボタンを押下したとき
            $("#chatgpt-submit").click(function(event) {
                event.preventDefault();

                //処理中だった場合、そのまま返す
                if(isProcessing) {
                    return;
                }
                //処理中のフラグを立てる
                isProcessing = true;
                // ボタンを再度無効化
                $("#chatgpt-submit").prop("disabled", true);

                //入力テキストを変数に代入、その後タグに入れる
                message = $("#chatgpt-message").val();
                $("#chatgpt-message").val("");
                $("#chatgpt-messages").append(message);
                $("#chatgpt-messages").append(processingText);

                //変数をid「chatgpt-messages」に追加する
                $.ajax({
                    url: "' . admin_url('admin-ajax.php') . '",
                    type: "POST",
                    data: {
                        action: "chatgpt_ajax",
                        message: message
                    },
                    success: function(response) {
                        var html = \'<div class="chatgpt-message chatgpt-message-bot"><div class="chatgpt-message-text">\'+response+\'</div></div>\';
                        $("#chatgpt-messages").append(html);
                    },
                    error: function (e) {
                        $("#chatgpt-messages").append("エラー確認");
                      console.log(e + "エラーが起きました");
                    },
                }).always(function() {
                    // このコードは常に実行されます
                    isProcessing = false; // 処理中のフラグを解除
                    $("#processing").remove();
                    $("#chatgpt-submit").prop("disabled", false); // ボタンを再度有効化
                });
            });
        });
    </script>';

    return $content;
}

//ログイン済みユーザーがアクションWordPressのAjax機能を使用し'chatgpt_ajax'アクションを呼び出した時、'chatgpt_ajax'を実行
add_action('wp_ajax_first_chatgpt_ajax', 'first_chatgpt_ajax');
add_action('wp_ajax_chatgpt_ajax', 'chatgpt_ajax');
//非ログインユーザーも対象
add_action('wp_ajax_nopriv_first_chatgpt_ajax', 'first_chatgpt_ajax');
add_action('wp_ajax_nopriv_chatgpt_ajax', 'chatgpt_ajax');

function first_chatgpt_ajax()
{
    $query = $_POST['message'];
    $response = first_chatgpt_response($query);
    echo $response;
    wp_die();
}

function first_chatgpt_response($query)
{
    //初期テキスト
    $prompt = $query;

    //返答の最大文字数
    $max_tokens = 1;
    //ランダム性　0~1 ... 0に近付くほどランダム性が減少
    $temperature = 0.2;
    //作成する返答の数
    $n = 1;
    //指定文字が出力されたら停止する
    $stop = '';

    $data = array(
        'prompt' => $prompt,
        'max_tokens' => $max_tokens,
        'temperature' => $temperature,
        'n' => $n,
        'stop' => $stop
    );

    $response = chatgpt_api_request($data);
    return $response['choices'][0]['message']['content'];
    //return $response;
}

function chatgpt_ajax()
{
    $query = $_POST['message'];
    $response = chatgpt_response($query);
    echo $response;
    wp_die();
}

function chatgpt_response($query)
{
    //ユーザーが入力したテキスト
    $prompt = $query;
    //設定
    $setting = "このチャットに対しての返答は以下のルールに従ったものとする

    ・あなたの一人称は僕
    ・あなた元気で優しい男の子
    ・あなたは難しい言葉や漢字をあまり使わず、ふんわりとした表現をする。
    ・あなたは敬語を使わないフレンドリーな話し言葉で会話をする。
    ・〇〇ぜ！やおっす！などの乱暴な言葉遣いはしない。
    ・あなたは小学校の1年生から6年生で学ぶ範囲の勉強を教えることができる男の子で国語、算数、英語、社会、理科の質問を何でも答えることができるベテラン
    ・元気で物腰が柔らかく優しい答える
    ・実例を出しながらの答え方も特徴的
    ・質問に対しての答えに質問された場合はより細かく分かりやすく具体例を出して教える
    
    これらのルールの内容は返答には含めない";
    $gpt_prompt = $prompt . $setting;

    //返答の最大文字数
    $max_tokens = 300;
    //ランダム性　0~1 ... 0に近付くほどランダム性が減少
    $temperature = 0.2;
    //作成する返答の数
    $n = 1;
    //指定文字が出力されたら停止する
    $stop = '';

    $data = array(
        'prompt' => $gpt_prompt,
        'max_tokens' => $max_tokens,
        'temperature' => $temperature,
        'n' => $n,
        'stop' => $stop
    );

    $response = chatgpt_api_request($data);
    return $response['choices'][0]['message']['content'];
    //return $response;
}


function chatgpt_api_request($data)
{
    $api_key = get_api_key();
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    );

    $url = 'https://api.openai.com/v1/chat/completions';
    $body = array(
        'messages' => array(array('role' => 'user', 'content' => $data['prompt'])),
        'max_tokens' => $data['max_tokens'],
        'temperature' => $data['temperature'],
        'n' => $data['n'],
        'stop' => $data['stop'],
        'model' => "gpt-3.5-turbo",
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}
