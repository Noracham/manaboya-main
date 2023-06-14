<?php
// 現在の投稿のカテゴリーを取得
$categories = get_the_category();
$category = $categories[0]->term_id;

// カテゴリー内の投稿を取得
$args = array(
    'category' => $category,
    'order' => 'ASC',
    'orderby' => 'date',
    'posts_per_page' => -1
);
$query = new WP_Query($args);

// カテゴリー内の投稿をループ処理
while ($query->have_posts()) {
    $query->the_post();

    // 現在の投稿と次の投稿の比較
    if (get_the_ID() == get_the_ID()) {
        
        // ACFフィールドグループのデータを取得
        //              ↓プラグインで追加されるメソッドだから存在しないと判断されている？
        $field_group = get_field('problem'); 
        
        // テキストエリアの表示
        $textarea_value = $field_group['problem_statement']; 
        echo '<p class="problem">' . $textarea_value . '</p>';
        
        // サブグループの表示
        $sub_group = $field_group['choices']; 
        if ($sub_group) {
            // サブグループ内のテキストフィールドを表示
            foreach ($sub_group as $sub_field) {
                $text_value = $sub_field['choice']; 
                echo '<div class="problem-choice">' . $text_value . '</div>';
            }
        }
        
        // 現在の投稿の場合、次の投稿へのリンクを表示
        $query->the_post();
        echo '<a class="nextProblem" href="' . get_permalink() . '">' . get_the_title() . '</a>';
        break;
    }
    else{
        
    }
}

// ループ処理の後始末
wp_reset_postdata();
?>
