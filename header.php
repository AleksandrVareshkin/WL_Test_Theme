<?php
$phone = get_theme_mod('title_tagline_phone');
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

    <title>
    </title>
    <?php wp_head(); ?>
</head>

<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <div class="header__inner">
                    <div class="header__logo">
                        <?php the_custom_logo(); ?>
                    </div>
                    <?php if ($phone): ?>
                    <div class="header__phone">
                        <a href="tel:<?php echo $phone; ?>">
                            <?php echo $phone; ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>