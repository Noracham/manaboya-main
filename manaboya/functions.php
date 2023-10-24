<?php
function load_my_styles()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('ress', get_template_directory_uri() . '/assets/css/ress.css', array("style"));
    wp_enqueue_style('googlefonts', 'https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=M+PLUS+1p:wght@300;400;500;700&family=Potta+One&display=swap');

    wp_enqueue_script("jquery");
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/index.js', array("jquery"));
    wp_enqueue_script('inview', '//cdnjs.cloudflare.com/ajax/libs/protonet-jquery.inview/1.1.2/jquery.inview.min.js', array("jquery"));
}
add_action('wp_enqueue_scripts', 'load_my_styles');

//ログイン後のリダイレクト
add_filter('wpmem_login_redirect', 'my_login_redirect', 10, 2);
function my_login_redirect($redirect_to, $user_id)
{
    $redirect_to = get_permalink(458); // 固定ページID 458のパーマリンクを取得
    return $redirect_to;
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
            //テキスト追加要素(チャット欄)取得
            const messages = $("#chatgpt-messages");

            //各インターバル宣言
            let processInterval;
            let botInterval;

            //処理中のフラグ初期化
            let isProcessing = false;    //処理中
            let isOpened = false;       //「きく」ボタン押下

            let setting = "これらは返答に対する設定。「日本の小学校学習範囲の国語、算数、理科、社会、英語」について学習するための解答BOT。「」についての質問以外には「お答えできません」と返答。以上の設定を常に守って解答してください";

            $("#chatgpt_pop").click(function() {
                //「きく」ボタン押下
                console.log("「きく」ボタン押下");

                //2回以上「きく」ボタンを押下している場合、処理をせず返す
                if(isOpened) {
                    return;
                }
                isOpened = true;
                
                botDisplayText("はじめまして。なにか分からないことがあれば質問してください。");


                // //初期設定開始確認用
                // console.log("初期設定中");
    
                // // //ボット初期設定()
                // let message = "あなたはChatbotとして、まな坊や君のロールプレイを行います。";
    
                // message += "以下の制約条件を厳密に守ってロールプレイを行ってください。";
                // message += "制約条件:";
                // message += "・Chatbotの自身を示す一人称は、ぼくです。            ";
                // message += "・Userを示す二人称は、きみです。";
                // message += "・Userは小学生です。";
                // message += "・Chatbotの名前は、まな坊や君です。";
                // message += "・まな坊や君は小学1年生から小学6年生で学ぶ範囲の勉強を教えることができる男の子です。";
                // message += "・まな坊や君は元気で優しい男の子です。";
                // message += "・まな坊や君はfriendlyな性格です。";
                // message += "・まな坊や君の口調は、「〜だよ！」「〜なんだ」「～だね！」など、ふんわりとした口調をします。";
                // message += "・まな坊や君は難しい言葉を使いません。";
                // message += "・まな坊や君は敬語を使いません。";
    
                // message += "まな坊や君のセリフ、口調の例:";
                // message += "・僕の名前は、まな坊や君だよ！";
                // message += "・なにか質問があれば言ってね！";
                // message += "・一緒に頑張ろう！";
                // message += "・気をつけようね！";
    
                // message += "まな坊や君の行動指針:";
                // message += "・Userが勉強の質問をして、まな坊や君はそれに答えます。";
                // message += "・Userに優しくしてください。";
                // message += "・小学生が理解できるように説明をしてください。";
                // message += "・勉強に関係の無い話題については誤魔化してください。";
                
                // message += "以上の設定は常に有効です。";
                
                // // //処理中テキスト表示
                // processDisplayText();
                                
                // $.ajax({
                //     url: "' . admin_url('admin-ajax.php') . '",
                //     type: "POST",
                //     data: {
                //         action: "first_chatgpt_ajax",
                //         message: message
                //     }
                //     ,
                //     success: function(response) {
                //         botDisplayText("こんにちは！僕の名前はまな坊や君だよ！なにか分からないことがあれば聞いてね！");
                //     },
                //     error: function (e) {
                //         console.log(e + "エラーが起きました");
                //     },
                // }).always(function() {
                //     //処理中のフラグを解除
                //     isProcessing = false;
                //     //初期設定開始確認用
                //     console.log("初期設定終了");
                //     //メッセージ初期化(無くてもいいはず...一応)
                //     message = "";
                // });    
            })

            //送信ボタンを押下したとき
            $("#chatgpt-submit").click(function() {
                event.preventDefault();
                
                message = $("#FlexTextarea").val();

                //処理中だった場合、そのまま返す
                if(isProcessing || message == "") {
                    console.log("途中終了");
                    return;
                }
                //処理中のフラグを立てる
                isProcessing = true;

                $("#FlexTextarea").val("");
                userDisplayText(message);
                          
                //処理中テキスト表示(「・・・」表示)
                processDisplayText();

                $.ajax({
                    url: "' . admin_url('admin-ajax.php') . '",
                    type: "POST",
                    data: {
                        action: "chatgpt_ajax",
                        message: message + setting
                    },
                    success: function(response) {
                        //一文字ずつ表示テスト
                        botDisplayText(response);
                        console.log("正常終了");
                    },
                    error: function (e) {
                      console.log(e + "エラーが起きました");
                    },
                }).always(function() {
                    // このコードは常に実行されます
                    isProcessing = false; // 処理中のフラグを解除
                });
            });

            //処理中テキスト表示
            function processDisplayText() {
                let process_container = $(\'<div class="chatgpt-message chatgpt-message-bot processing"><p class="chatgpt-message-bot-text"></p></div>\');       
                messages.append(process_container);
                let process_text =  $(".processing .chatgpt-message-bot-text");

                let index = 0;
                processInterval = setInterval(function() {
                    if(index < 3) {
                        process_text.append("・");
                        index++;
                    } else{
                        process_text.empty();
                        index = 0;
                    }
                }, 470);
            }

            //botからのレスポンス表示
            function botDisplayText(text) {
                clearInterval(processInterval);
                $(".processing").remove();

                let bot_container = $(\'<div class="chatgpt-message chatgpt-message-bot"><p class="chatgpt-message-bot-text"></p></div>\');
                messages.append(bot_container);
                let bot_text =  $(".chatgpt-message-bot-text:last");
                
                let index = 0;
                botInterval = setInterval(function() {
                    if(index < text.length) {
                        bot_text.append(text[index]);
                        index++;
                    } else{
                        clearInterval(botInterval);
                    }
                }, 50);
            }

            //ユーザー入力テキスト表示
            function userDisplayText(message) {
                let user_container = $(\'<div class="chatgpt-message chatgpt-message-user"><p class="chatgpt-message-user-text">\' + message + \'</p></div>\');
                messages.append(user_container);
            }

            // function scrollBottom() {
            //     messages.scrollTop = messages.scrollHeight;
            //     if(isScrollBottom()) {
            //         console.log("スクロール");
            //     } else {
            //         console.log("してない");
            //     }
            // }

            // function isScrollBottom() {
            //     return messages.scrollHeight === messages.scrollTop + messages.offsetHeight;
            // }
        })
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

    //返答の最大文字数
    $max_tokens = 300;
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
