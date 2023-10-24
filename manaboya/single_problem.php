<?php
$current_post = get_queried_object(); // 現在の投稿を取得
$current_category = get_the_category($current_post->ID)[0]->term_id; // 現在の投稿のカテゴリーIDを取得

$field_group = get_field('problem');

// テキストエリア(問題文)の表示
$textarea_value = $field_group['problem_statement'];
echo '<p class="problem">' . $textarea_value . '</p>';

// サブグループ(選択肢)の表示
$sub_group = $field_group['choices'];
if ($sub_group) {
    echo '<div class="problem-choice">';
    // サブグループ内のテキストフィールド(各選択肢)を表示
    foreach ($sub_group as $sub_field) {
        $text_value = $sub_field;
        echo '<label><input type="radio" name="choice" value="' . $text_value . '">' . $text_value . '</label>';
    }
    echo '</div>';
}

// 正解を取得
$answer = $field_group['answer'];

// 解答用のボタンを表示 div・inputにはクラスじゃなくてIDを割り当ててます
echo '<div id="btn"><input type="button" value="解答" id="checkButton"></div>';

$args = array(
    'category' => $current_category,
    'order'    => 'ASC',
    'orderby'  => 'date',
    'exclude'  => $current_post->ID,
    'posts_per_page' => 1,
    'date_query' => array(
        array(
            'after'     => $current_post->post_date, // 現在の投稿の日付より後の投稿を取得
            'inclusive' => false,
        ),
    ),
);

$next_post = get_posts($args); // 次の投稿を取得

echo "<div class='problem_next'>";
if ($next_post) {
    $next_post_link = get_permalink($next_post[0]->ID); // 次の投稿へのリンクを取得
    echo '<a href="' . esc_url($next_post_link) . '">次の問題へ</a>';
    echo '<a href="' . esc_url(get_permalink(514)) . '">解答を終える</a>';
} else {
    echo '<a href="' . esc_url(get_permalink(514)) . '">結果を見る</a>';
}
echo "</div>";

echo "<div class='problem_backbtn'>";

$category = get_term($current_category, 'category');
$parent_category = get_term($category->parent, 'category'); // 親カテゴリーオブジェクトを取得

if ($parent_category && !is_wp_error($parent_category)) {
    // 親カテゴリーが存在する場合
    echo '<a href="' . get_term_link($parent_category) . '">単元選択へ</a>';

    // 親カテゴリーがさらに親カテゴリーを持つか確認
    if ($parent_category->parent) {
        $grandparent_category = get_term($parent_category->parent, 'category'); // さらに親カテゴリーオブジェクトを取得

        if ($grandparent_category && !is_wp_error($grandparent_category)) {
            // さらに親カテゴリーが存在する場合
            echo '<a href="' . get_term_link($grandparent_category) . '">教科選択へ</a>';
        }
    }
}
echo "</div>";

?>

<script>
    // Cookieの値を取得する関数
    function getCookie(name) {
        const cookieName = name + "=";
        const cookies = document.cookie.split(";");

        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i];
            while (cookie.charAt(0) === " ") {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(cookieName) === 0) {
                return cookie.substring(cookieName.length, cookie.length);
            }
        }

        return "";
    }

    // Cookieの値を更新する関数
    function updateCookie(name, value, days) {
        const expirationDate = new Date();
        expirationDate.setTime(expirationDate.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + expirationDate.toUTCString();
        document.cookie = name + "=" + value + "; " + expires + "; path=/";
    }



    // 指定した要素の直後に新しい要素を挿入する関数
    function insertAfter(newElement, targetElement) {
        const parent = targetElement.parentNode;

        if (parent.lastChild === targetElement) {
            // targetElementが最後の子要素の場合、新しい要素を直接追加
            parent.appendChild(newElement);
        } else {
            // targetElementの次の兄弟要素を取得し、その前に新しい要素を挿入
            parent.insertBefore(newElement, targetElement.nextSibling);
        }
    }

    // 問題の正解を取得
    const answer = '<?php echo $answer; ?>';
    // 解答結果用の要素作成
    const newElement = document.createElement("div");
    newElement.classList.add('result');



    const btnClick = () => {
        let checkValue = '';
        var result;

        // 解いた問題数の値を取得
        const pCountValue = parseInt(getCookie("pCount"));
        console.log("解いた数(更新前):", pCountValue);
        // 解いた問題数の値を更新
        const newpCountValue = pCountValue + 1;
        updateCookie("pCount", newpCountValue, 7);
        console.log("解いた数(更新後):", getCookie("pCount"));

        // 正解した問題数の値を取得
        const cCountValue = parseInt(getCookie("cCount"));
        console.log("正答数(更新前):", cCountValue);

        // どの選択肢を選んだかを取得
        for (let i = 0; i < len; i++) {
            if (question.item(i).checked) {
                checkValue = question.item(i).value;
            }
        }
        // 正誤判定
        if (checkValue === answer) {
            result = 'せいかい';
            const newcCountValue = cCountValue + 1;
            updateCookie("cCount", newcCountValue, 7);
        } else {
            result = 'ふせいかい';
        }
        console.log('選択されているのは ' + checkValue + ' です');
        console.log('正解:' + answer)
        console.log("正答数(更新後):", getCookie("cCount"));
        newElement.textContent = result;

        // 挿入する位置(一旦解答ボタンの下にしてる)の要素を取得
        const targetElement = document.getElementById("btn");

        // 新しい要素を指定した要素の直後に挿入
        insertAfter(newElement, targetElement);

    }

    // 選択肢の数の取得、1つ目の選択肢にチェックを入れておく処理
    let question = document.getElementsByName('choice');
    let len = question.length;
    question[0].checked = true;

    // 解答ボタンにクリックイベントを設定
    let checkButton = document.getElementById('checkButton');
    checkButton.addEventListener('click', btnClick);

    if (getCookie('pCount') === "0") {
        const startTime = new Date();

        // Cookieに時間を保存
        document.cookie = "startTime=" + startTime.getTime() + "; path=/";
    }
</script>

<!-- <script src="<?php echo get_theme_file_uri("assets/js/problemCount.js") ?>"></script> -->