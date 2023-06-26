<?php wp_footer(); ?>

<footer>
    <ul>
        <!--ブラウザバックボタン-->
        <li class="footer-btn"><img src="<?php echo get_theme_file_uri('/assets/img/caret-back-outline.svg') ?>">もどる<a href="javascript:history.back()"></a></li>

        <?php
        //ホームページのURLを取得
        $home_url = home_url();

        //ホームボタンを表示
        echo '<li class="footer-btn"><img src="' . get_theme_file_uri('/assets/img/home-outline.svg') . '">ホーム<a href="' . esc_url($home_url) . '"></a></li>';
        ?>

        <!--チャットボタン表示-->
        <li id="chatgpt_pop" class="footer-btn"><img src="<?php echo get_theme_file_uri('/assets/img/chatbubbles-outline.svg') ?>">きく</li>
    </ul>
</footer>
<div id="pop">
    <div id="popup">
        <?php echo do_shortcode('[chatgpt]'); ?>
    </div>
</div>

</div>
</body>

</html>