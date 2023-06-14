<?php
function load_my_styles()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('ress', get_template_directory_uri() . '/assets/css/ress.css', array("style"));

    wp_enqueue_script("jquery");
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/index.js', array("jquery"));
    wp_enqueue_script('inview', '//cdnjs.cloudflare.com/ajax/libs/protonet-jquery.inview/1.1.2/jquery.inview.min.js', array("jquery"));
}
add_action('wp_enqueue_scripts', 'load_my_styles');

//ログイン後のリダイレクト
add_filter('wpmem_login_redirect', 'my_login_redirect', 10, 2);
function my_login_redirect($redirect_to, $user_id)
{
    return home_url();
}

//wpmem スタイリング用
add_filter('wpmem_register_form_args', 'my_register_form_row_wrapper', 10, 2);
function my_register_form_row_wrapper($args, $tag)
{
    $args = array(
        'row_before' => '<div class="form_custom d-flex">',
        'row_after'  => '</div>',
    );

    return $args;
}

//ログアウト後リダイレクト
function logout_redirect()
{
    wp_safe_redirect("https://manaboya.net/?page_id=74");
    exit();
}
add_action('wp_logout', 'logout_redirect');
