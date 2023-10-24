<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@300;400;500;600;700&family=Yatra+One&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/6f1fb1342b.js" crossorigin="anonymous"></script>
    <title><?php echo bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body>

    <?php if (!is_single()) : ?>
        <div class="loader">
            <div class="loader-content">
                <img src="<?php echo get_theme_file_uri("assets/img/manaboyaKUN.png") ?>" alt="">
                <p>Loading</p>
            </div>
        </div>
    <?php endif; ?>
    <div <?php echo is_front_page() ? 'class="main-visual main"' : 'class="main main-visual"'; ?>>
        <header>
            <div class="logo">まな<span>坊</span>や<a href="<?php echo esc_url(home_url()) ?>"></a></div>
        </header>