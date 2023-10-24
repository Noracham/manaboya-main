<?php get_header(); ?>
<div class="message">
    <p class="message-txt">
        <?php
        $current_ctgr = get_queried_object(); // 現在のカテゴリーオブジェクトを取得

        // 現在のカテゴリーが存在するか確認
        if ($current_ctgr) {
            // 子カテゴリーを取得
            $child_ctgr = get_terms(array(
                'taxonomy' => 'category',
                'parent' => $current_ctgr->term_id,
            ));

            if ($child_ctgr && !is_wp_error($child_ctgr)) {
                // 子カテゴリーが存在する場合

                $has_grandchildren = false;

                foreach ($child_ctgr as $child_category) {
                    // 各子カテゴリーに対して、さらに子カテゴリーが存在するか確認
                    $grandchildren = get_terms(array(
                        'taxonomy' => 'category',
                        'parent' => $child_category->term_id,
                    ));

                    if ($grandchildren && !is_wp_error($grandchildren)) {
                        $has_grandchildren = true;
                        break; // 孫カテゴリーが見つかったらループを終了
                    }
                }

                if ($has_grandchildren) {
                    // 孫カテゴリーが存在する場合
                    echo '<ruby>教科<rt>きょうか</rt></ruby>を<ruby>選<rt>えら</rt></ruby>んでね';
                } else {
                    // 孫カテゴリーが存在しない場合
                    echo '<ruby>問題<rt>もんだい</rt></ruby>を<ruby>選<rt>えら</rt></ruby>んでね';
                }
            } else {
                // 子カテゴリーが存在しない場合
                echo '(´・ω・｀)';
            }
        }
        ?>
    </p>
</div>
<div id="container" class="wrapper">
    <?php
    $current_category = get_queried_object();

    $child_categories = get_categories(array(
        //親カテゴリーを指定する
        'parent' => $current_category->term_id,
        //カテゴリーに属する投稿がない場合でも表示する
        'hide_empty' => false,
    ));
    // $classNameGrid;
    $flag = false;
    if ($child_categories) {
        // $classNameGrid = "grid";
        // if ($child_posts) {
        //     $classNameGrid = "grid-in-post";
        // }
        // echo '<ul class="' . $classNameGrid . '">';
        $problemCount = 1;
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
                if ($flag == false) {
                    echo '<ul class="grid">';

                    $flag = true;
                }
                switch ($category->name) {
                    case '漢字':
                        $category_ruby = "かんじ";
                        break;
                    case '算数':
                        $category_ruby = "さんすう";
                        break;
                    case '理科':
                        $category_ruby = "りか";
                        break;
                    case '社会':
                        $category_ruby = "しゃかい";
                        break;
                    case '英語':
                        $category_ruby = "えいご";
                        break;
                    default:
                        $category_ruby = "";
                        # code...
                        break;
                }

                $inner = '<li class="category-grid grid-box grid-box-cat"><a href="' . esc_url($category_link) . '"></a><ruby>' . $category->name . '<rt>' . $category_ruby . '</rt></ruby></li>';
            }
            //孫カテゴリーは存在しないが、カテゴリーに投稿が存在するとき
            elseif ($child_posts) {
                if ($flag == false) {
                    echo '<ul class="grid-in-post">';

                    $flag = true;
                }
                $target_post_id = $category->term_id;
                $first_post_permalink = get_permalink($child_posts[0]->ID);


                $description = category_description($target_post_id);
                $description = wpautop($description);
                $inner = '<li><details><summary>' . $category->name . '</summary><p>' . $description . '</p><a class="q-link" href="' . esc_url($first_post_permalink) . '">はじめる</a></details></li>';
                $problemCount++;
            } else {
                $inner = '';
            }

            echo $inner;
        }
        echo '</ul>';
    }
    ?>
</div>

<?php get_footer(); ?>

<script src="<?php echo get_theme_file_uri("assets/js/count_init.js") ?>"></script>