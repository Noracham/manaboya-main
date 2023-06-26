<?php get_header(); ?>
<div class="message">
    <p class="message-txt">
        <ruby>学年<rt>がくねん</rt></ruby>を<ruby>選<rt>えら</rt></ruby>んでね
    </p>
</div>
<div id="container" class="wrapper">
    <?php
    //最上位(親)カテゴリーを取得
    $grade_categories = get_categories(array(
        'parent' => 0,
        'hide_empty' => false,
    ));
    ?>
    <ul class="grid">
        <?php
        //学年を出力するための数値(繰り返しで増分1)
        $grade_num = 1;

        //最上位(親)カテゴリーの数だけ繰り返し
        foreach ($grade_categories as $grade_category) {
            //未定義カテゴリーを除く
            if ($grade_category->slug !== 'uncategorized') {    //"uncategorizedを除く"
                echo '<li class="grid-box"><p>'
                    . $grade_num . '</p>ねんせい
                            <a class="all-link" href="' . get_category_link($grade_category->term_id) . '"></a></li>';
                $grade_num += 1;
            }
        }
        ?>
    </ul>
</div>
<?php get_footer(); ?>