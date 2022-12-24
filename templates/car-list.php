<?php
$posts = new WP_Query(
    array(
        "post_type" => 'car',
        "post_status" => "publish",
        "posts_per_page" => 10,
    )
);
if ($posts->have_posts()):
?>
<div class="car">
    <?php
    while ($posts->have_posts()):
        $posts->the_post();
        $id = get_the_ID();
    ?>

    <div class="car__item">
        <a class="car__title" href="<?php echo get_permalink(); ?>"><?php echo get_the_title($id); ?></a>
    </div>

    <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>
</div>