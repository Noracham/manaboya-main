<?php get_header(); ?>

<div id="container" class="wrapper">
    <main>
        <?php
        //最上位(親)カテゴリーを取得
        $grade_categories = get_categories(array(
            'parent' => 0,
            'hide_empty' => false,
        ));
        ?>
        <nav id="grade-select" class="navi">
            <ul class="wrapper">
                <?php
                //学年を出力するための数値(繰り返しで増分1)
                $grade_num = 1;

                //最上位(親)カテゴリーの数だけ繰り返し
                foreach ($grade_categories as $grade_category) {
                    //未定義カテゴリーを除く
                    if ($grade_category->slug !== 'uncategorized') {    //"uncategorizedを除く"
                        echo '<li class="grade"><a href="' . get_category_link($grade_category->term_id) . '">'
                            . $grade_num . '<br>ねんせい
                                    </a></li>';
                        $grade_num += 1;
                    }
                }
                ?>
            </ul>
        </nav>
    </main>
</div>

<?php get_footer(); ?>