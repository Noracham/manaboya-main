<?php
// // 現在の投稿のカテゴリーを取得
// $categories = get_the_category();
// $category = $categories[0]->term_id;

// // カテゴリー内の投稿を取得
// $args = array(
//     'category' => $category,
//     'order' => 'ASC',
//     'orderby' => 'date',
//     'posts_per_page' => -1
// );
// $query = new WP_Query($args);

// // カテゴリー内の投稿をループ処理
// while ($query->have_posts()) {
//     $query->the_post();

//     // ACFフィールドグループのデータを取得
//     $field_group = get_field('problem'); 
    
//     // テキストエリアの表示
//     $textarea_value = $field_group['problem_statement']; 
//     echo '<p class="problem">' . $textarea_value . '</p>';
    
//     // サブグループの表示
//     $sub_group = $field_group['choices']; 
//     if ($sub_group) {
//         // サブグループ内のテキストフィールドを表示
//         foreach ($sub_group as $sub_field) {
//             $text_value = $sub_field; 
//             echo '<div class="problem-choice">' . $text_value . '</div>';
//         }
//     }
//     //var_dump($sub_group);

//     // 現在の投稿と次の投稿の比較
//     if (get_the_ID() == get_the_ID()) {
        
        
//         // 現在の投稿の場合、次の投稿へのリンクを表示
//         $query->the_post();
//         echo '<a class="nextProblem" href="' . get_permalink() . '">' . "次の問題へ" . '</a>';
//         break;
//     }
//     else{
//         //現在が最終問題の場合のリンクを表示
//     }
// }

// // ループ処理の後始末
// wp_reset_postdata();


$current_post = get_queried_object(); // 現在の投稿を取得
$current_category = get_the_category($current_post->ID)[0]->term_id; // 現在の投稿のカテゴリーIDを取得

$field_group = get_field('problem'); 
    
// テキストエリアの表示
$textarea_value = $field_group['problem_statement']; 
echo '<p class="problem">' . $textarea_value . '</p>';

// サブグループの表示
$sub_group = $field_group['choices']; 
if ($sub_group) {
    echo '<div class="problem-choice">';
    // サブグループ内のテキストフィールドを表示
    foreach ($sub_group as $sub_field) {
        $text_value = $sub_field; 
        echo '<input type="radio" name="choice">' . $text_value;
    }
    echo '</div>';
}

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

if ($next_post) {
    $next_post_link = get_permalink($next_post[0]->ID); // 次の投稿へのリンクを取得
    echo '<a href="' . esc_url($next_post_link) . '">次の投稿へ</a>';
}else{
    echo "終了";
}


?>
