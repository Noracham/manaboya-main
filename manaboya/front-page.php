<?php get_header(); ?>

<div class="message message-front">
    <p id="message-txt-front">まな<ruby>坊<rt>ぼう</rt></ruby>やくんです！<br>おとうさん、おかあさんにおねがいしてはじめよう！</p>
</div>
<div class="t-next">
    <div id="new-account" class="t-next-link">
        <p>初めてご利用の方はこちら</p>
        <div class="t-next-link-btn"><a href="<?php echo esc_url(get_permalink(67)); ?>"></a>
            <p>新規登録</p>
        </div>
    </div>
    <div id="user-login" class="t-next-link">
        <p>すでに会員の方はこちら</p>
        <div class="t-next-link-btn"><a class="t-next-hover" href="<?php echo esc_url(get_permalink(74)); ?>"></a>
            <p>ログイン</p>
        </div>
    </div>
    <p><a href="<?php echo esc_url(get_permalink(458)); ?>">ページへ遷移する（仮メインページへ）</a></p>
</div>
<style>
    .link {
        display: flex;
        flex-direction: column;
    }
</style>
<?php get_footer(); ?>