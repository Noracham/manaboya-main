<?php get_header(); ?>

<div id="container" class="wrapper">
    <main>
        <?php
        $current_category = get_queried_object();

        $child_categories = get_categories(array(
            //親カテゴリーを指定する
            'parent' => $current_category->term_id,
            //カテゴリーに属する投稿がない場合でも表示する
            'hide_empty' => false,
        ));
        if ($child_categories) {
            echo '<ul>';

            foreach ($child_categories as $category) {
                // 子カテゴリーに孫カテゴリーが存在するかチェック
                $has_grandchild = get_categories(array(
                    'child_of' => $category->term_id,
                    'hide_empty' => false,
                ));

                // 子カテゴリーの投稿を取得
                $args = array(
                    //取得する問題のカテゴリーを指定
                    'category' => $category->term_id,
                    //投稿を昇順に並び替える(1問目から投稿を取得するため)
                    'order' => 'asc',
                    'orderby' => 'date',
                    //取得する情報の数を指定
                    'posts_per_page' => 1,

                    'hide_empty' => false,
                );
                $child_posts = get_posts($args);

                // リンクを生成
                $category_link = get_category_link($category->term_id);

                //孫カテゴリーが存在するとき
                if ($has_grandchild) {
                    $inner = '<li><a href="' . esc_url($category_link) . '">' . $category->name . '</a></li>';
                }
                //孫カテゴリーは存在しないが、カテゴリーに投稿が存在するとき
                elseif ($child_posts) {
                    $first_post_permalink = get_permalink($child_posts[0]->ID);
                    $inner = '<li><a href="' . esc_url($first_post_permalink) . '">' . $category->name . '</a></li>';
                } else {
                    $inner = '';
                }

                echo $inner;
            }
            echo '</ul>';
        }
        ?>
    </main>
</div>

<?php get_footer(); ?>