<?php wp_footer(); ?>

<?php if (!is_front_page() || !is_home()) :; ?>
    <footer>
        <ul>
            <!--ブラウザバックボタン-->
            <li class="footer-btn"><img src="<?php echo get_theme_file_uri('/assets/img/arrow-undo-outline.svg') ?>">もどる<a href="javascript:history.back()"></a></li>

            <?php
            //ホームページのURLを取得
            $home_url = get_permalink(458);

            //ホームボタンを表示
            echo '<li class="footer-btn"><img src="' . get_theme_file_uri('/assets/img/home-outline.svg') . '">ホーム<a href="' . esc_url($home_url) . '"></a></li>';
            ?>

            <!--チャットボタン表示-->
            <li id="chatgpt_pop" class="footer-btn"><img src="<?php echo get_theme_file_uri('/assets/img/chatbubbles-outline.svg') ?>">きく</li>
        </ul>
    </footer>
    <div id="pop">
        <div id="popup">
            <div id="chatgpt-messages">
            </div>
            <?php echo do_shortcode('[chatgpt]'); ?>
            <form id="chatgpt-form" method="post">
                <!--<input type="textarea" name="message" id="chatgpt-message" placeholder="質問を入力してください">-->
                <div class="FlexTextarea">
                    <div class="FlexTextarea__dummy" aria-hidden="true"></div>
                    <textarea name="message" id="FlexTextarea" class="FlexTextarea__textarea" placeholder="タップしてしつもんしてね！"></textarea>
                </div>
                <div class="chatgpt-btn">
                    <button type="button" id="chatgpt-submit" class="popup-button"><img src="<?php echo get_theme_file_uri('/assets/img/ear-outline.svg') ?>">きく</button>
                    <button type="button" id="recognition" class="popup-button"><img src="<?php echo get_theme_file_uri('/assets/img/mic-outline.svg') ?>">こえできく</button>
                </div>
                <!-- <button type="button" id="scroll" class="scroll-button">スクロール</button> -->
            </form>
        </div>
    </div>
<?php endif; ?>

</div>
</body>

</html>