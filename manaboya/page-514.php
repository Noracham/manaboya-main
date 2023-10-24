<?php get_header(); ?>
<div class="message">
    <p class="message-txt">
        <ruby>結果<rt>けっか</rt></ruby>
    </p>
</div>

<?php
$pCount = intval($_COOKIE['pCount']);
$cCount = intval($_COOKIE['cCount']);
$percent = round($cCount * 100 / $pCount);

echo '<div class="result-all" ><div class="result">' . $pCount . '問中' . $cCount . '問正解(' . $percent . '%)</div>';

?>

<script>
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

    const targetElement = document.getElementsByClassName("result")[0];
    const newElement = document.createElement('div');
    newElement.classList.add('time');
    // Cookieから保存した時間を取得
    const cookieValue = document.cookie
        .split("; ")
        .find(row => row.startsWith("startTime="))
        .split("=")[1];

    // Cookieに保存した時間をDateオブジェクトに変換
    const savedTime = new Date(parseInt(cookieValue));

    // 現在の時間を取得
    const currentTime = new Date();

    // 経過時間を計算（ミリ秒単位）
    const elapsedTimeMs = currentTime - savedTime;

    // ミリ秒を分と秒に変換
    const minutes = Math.floor(elapsedTimeMs / 60000);
    const seconds = Math.floor((elapsedTimeMs % 60000) / 1000);

    console.log("経過時間（分:秒）:", minutes, "分", seconds, "秒");


    newElement.textContent = "解くのにかかった時間:" + minutes + "分" + seconds + "秒";
    insertAfter(newElement, targetElement);
</script>
</div>

<?php
echo "<div class='backbtn'>";

if (isset($_COOKIE['category'])) {
    $current_category = $_COOKIE['category'];

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
} 
echo "</div>";
?>

<?php get_footer(); ?>