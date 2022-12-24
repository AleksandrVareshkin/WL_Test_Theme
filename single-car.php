<?php
get_header();
$id = get_the_ID();
$brand_terms = get_the_terms($id, 'brand');
$manufacturer_terms = get_the_terms($id, 'manufacturer');
$power = get_post_meta($id, 'power', true);
$price = get_post_meta($id, 'price', true);
$select = get_post_meta($id, 'select', true);
$color = get_post_meta($id, 'car_color', true);
?>

<main class="main">
    <section class="section">
        <div class="container">
            <div class="car-item">
                <div class="car-item__descriptions">
                    <div class="car-item__content">
                        <?php the_content() ?>
                    </div>
                    <div class="car-item__img"
                        style="background-image: url(<?php echo get_the_post_thumbnail_url($id, 'large'); ?>)">
                    </div>
                    <a class="car-item__title" href="<?php echo get_permalink(); ?>"><?php echo get_the_title($id); ?></a>

                    <?php if ($power): ?>
                    <div class="car-item__property">
                        <div class="property-name">
                            Engine power:
                        </div>
                        <div class="property-value">
                            <?php echo $power; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($price): ?>
                    <div class="car-item__property">
                        <div class="property-name">
                            Car price:
                        </div>
                        <div class="property-value">
                            <?php echo $price; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($select): ?>
                    <div class="car-item__property">
                        <div class="property-name">
                            Engine type:
                        </div>
                        <div class="property-value">
                            <?php echo $select; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($color): ?>
                    <div class="car-item__property">
                        <div class="property-name">
                            Car color:
                        </div>

                        <div class="property-value">
                            <div class="car-item__color" style="background-color:<?php echo $color; ?>"></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($brand_terms): ?>
                    <div class="car-item__property">
                        <div class="property-name">
                            Brand:
                        </div>
                        <div class="property-value">
                            <?php
                        foreach ($brand_terms as $tax) {
                            echo '<span>' . __($tax->name) . '</span>';
                        }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($manufacturer_terms): ?>
                    <div class="car-item__property">
                        <div class="property-name">
                            Manufacturer:
                        </div>
                        <div class="property-value">
                            <?php
                        foreach ($manufacturer_terms as $tax) {
                            echo '<span>' . __($tax->name) . '</span>';
                        }
                            ?>
                        </div>
                    </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>