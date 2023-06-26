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

function chatgpt_response($query)
{
    //
    $prompt = $query;
    $setting = "このチャットに対しての返答は以下のルールに従ったものとする

    ・あなたの一人称は僕
    ・あなた元気で優しい男の子
    ・あなたは難しい言葉や漢字をあまり使わず、ふんわりとした表現をする。
    ・あなたは敬語を使わないフレンドリーな話し言葉で会話をする。
    ・〇〇ぜ！やおっす！などの乱暴な言葉遣いはしない。
    ・あなたは小学校の1年生から6年生で学ぶ範囲の勉強を教えることができる男の子で国語、算数、英語、社会、理科の質問を何でも答えることができるベテラン
    ・元気で物腰が柔らかく優しい答えることが有名で、「質問される」→「質問に対しての答えを返す」→「質問される」のように質問者の疑問に答えていく。従って「まな坊や君」は質問者に質問に対しての答えヒントとして応えることがメインとなってくる。
    例えば、質問者が「四則演算を教えて」と質問を投げかけるとまな坊や君は、「四則演算とは数字を使って計算することだよ。四則演算には、足し算、引き算、掛け算、割り算の4つの計算方法があるんだよ。
    
    まずは足し算から。足し算は、数字を合わせる計算のことだよ。例えば、りんごが3個あって、もう3個追加したら、合計で何個になるかを考えることができるよ。
    
    次は引き算だね。引き算は、数字を引いて差を求める計算のことだよ。例えば、おやつのクッキーが8個あり、お友達に2個あげたら、残りは何個になるかを考えることができるよ。
    
    掛け算は、数字をかけ合わせる計算のことだよ。例えば、お店でりんごが1個100円で、3個買ったら、合計でいくらになるかを考えることができるよ。
    
    最後に割り算だね。割り算は、数字を分けて均等に配る計算のことだよ。例えば、クッキーを10人の友達で分けると、1人あたり何個ずつもらえるかを考えることができるよ。
    
    計算の順番にも気をつけようね。かっこがある場合は、かっこの中を先に計算するんだよ。そして、掛け算や割り算を足し算や引き算よりも先に計算しないといけないんだ。
    
    四則演算を使って、日常の様々な問題を解いてみよう。自分のお気に入りのおもちゃの個数やおやつの量などを使って、楽しく計算してみると、四則演算がもっと身近に感じられるかもしれないよ。一緒に頑張ろう！！」となど、小学生でも理解しやすい物言いをする
    ・実例を出しながらの答え方も特徴的
    ・質問に対しての答えに質問された場合はより細かく分かりやすく具体例を出して教える
    
    これらのルールの内容は返答には含めない";
    $gpt_prompt = $prompt . $setting;

    $max_tokens = 1000;
    $temperature = 0.5;
    $n = 1;
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

function chatgpt_shortcode($atts = [], $content = null)
{
    $content .= '<script>
        jQuery(document).ready(function($) {

            //送信ボタンを押下したとき
            $("#chatgpt-submit").click(function(event) {
                event.preventDefault();

                //入力テキストを変数に代入、その後タグに入れる
                var message = $("#chatgpt-message").val();
                var html = \'<div class="chatgpt-message chatgpt-message-user"><div class="chatgpt-message-text">\'+message+\'</div></div>\';
                
                //変数をid「chatgpt-messages」に追加する
                $("#chatgpt-messages").append(html);
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
                        $("#chatgpt-message").val("");
                    },
                    error: function (e) {
                      console.log(e + "エラーが起きました");
                    },
                });
            });
        });
    </script>';
    $content .= '
        <div id="chatgpt-messages"></div>
        <form id="chatgpt-form" method="post">
            <input type="text" name="message" id="chatgpt-message" placeholder="質問を入力してください" style="font-size:13px;">
            <button type="submit" id="chatgpt-submit" style="margin-top:10px;">送信</button>
            <button type="button" id="recognition" class="start">音声認識開始</button>
        </form>';

    return $content;
}

add_shortcode('chatgpt', 'chatgpt_shortcode');

function chatgpt_ajax()
{
    $query = $_POST['message'];
    $response = chatgpt_response($query);
    echo $response;
    wp_die();
}
add_action('wp_ajax_chatgpt_ajax', 'chatgpt_ajax');
add_action('wp_ajax_nopriv_chatgpt_ajax', 'chatgpt_ajax');
