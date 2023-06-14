<?php get_header(); ?>

<div id="container" class="wrapper">
    <main>
        <?php
        // 現在のカテゴリーページの情報を取得
        $current_category = get_queried_object();
        $current_category_id = $current_category->term_id;

        // 子カテゴリーを取得
        $child_categories = get_categories(array(
            'child_of' => $current_category_id,
            'parent' => $current_category_id,
            'hide_empty' => false,
        ));

        // 子カテゴリーが存在する場合、子カテゴリーのリンクを表示
        if ($child_categories) {
            echo '<ul>';
            foreach ($child_categories as $child_category) {
                echo '<li><a href="' . get_category_link($child_category->term_id) . '">' . $child_category->name . '</a></li>';
            }
            echo '</ul>';
        } else {
            // 子カテゴリーが存在しない場合

            // カテゴリーに所属する投稿数を取得
            $category_post_count = get_category($current_category_id)->count;

            if ($category_post_count > 0) {
                // 投稿が存在する場合は、最新の投稿にリダイレクト
                $args = array(
                    'posts_per_page' => 1,
                    'category' => $current_category_id,
                    'orderby' => 'date',
                    'order' => 'ASC',
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    $query->the_post();
                    wp_redirect(get_permalink());
                    exit;
                }
            } else {
                // 投稿が存在しない場合は、カテゴリーページの内容を表示
                echo '<h2>' . $current_category->name . '</h2>';
                echo '<p>このカテゴリーには投稿がありません。</p>';
            }
        }
        ?>
    </main>
</div>

<?php get_footer(); ?>