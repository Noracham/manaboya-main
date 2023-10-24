<?php
$current_category = get_queried_object(); // 現在のカテゴリーを取得

// 現在のカテゴリーの子カテゴリーを取得
$args = array(
    'child_of' => $current_category->term_id,
    'hide_empty' => 0
);
$child_categories = get_categories($args);

// 子カテゴリーの一覧を表示
if ($child_categories) {
    echo '<ul class="problem">';
    foreach ($child_categories as $child_category) {
        $args = array(
            'cat' => $child_category->term_id,
            'posts_per_page' => 1,
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $query->the_post();
            /*
            問題のタイトル
            問題の説明
            問題(1問目)へのリンク の順で表示
            */
            echo '<li class="problem-list">
                    <h3 class="problem-list-title">' . $child_category->name . '</h3>
                    <p class="problem-list-desc">' . $child_category->description . '</p>
                    <a class="problem-list-link" href="' . get_permalink() . '">はじめる</a>
                  </li>';
        }
        wp_reset_postdata();
        
    }
    echo '</ul>';
} else {
    echo '(´・ω・｀)問題がないよ';
}
?>

