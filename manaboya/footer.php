<?php wp_footer(); ?>

<footer>
    <nav id="footer" class="navi">
        <ul>
            <!--ブラウザバックボタン-->
            <li class="pagination"><a href="javascript:history.back()">もどる</a></li>

            <?php
            //ホームページのURLを取得
            $home_url = home_url();

            //ホームボタンを表示
            echo '<li class="pagination"><a href="' . esc_url($home_url) . '">ホーム</a></li>';
            ?>

            <!--チャットボタン表示-->
            <li class="pagination"><a href="">きく</a></li>
        </ul>
    </nav>
</footer>

</div>
</body>

</html>