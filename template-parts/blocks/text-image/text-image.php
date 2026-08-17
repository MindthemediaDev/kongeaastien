<?php
/**
 * Text Image Block
 */

$heading          = get_field('heading') ?: '';
$body_text        = get_field('body_text') ?: '';
$button           = get_field('button');
$image            = get_field('image');
$image_position   = get_field('image_position') ?: 'left';
$block_id = 'text-image-' . $block['id'];

if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="container mx-auto text-image-block">
  <div class="text-image-inner text-image-inner--<?php echo esc_attr($image_position); ?>">

        <div class="text-image-content">

            <?php if ($heading) : ?>
                <h2 class="text-image-heading">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($body_text) : ?>
                <div class="text-image-body">
                    <?php echo wp_kses_post(wpautop($body_text)); ?>
                </div>
            <?php endif; ?>

            <?php if ($button && !empty($button['url'])) : ?>
                <a
                    href="<?php echo esc_url($button['url']); ?>"
                    class="text-image-btn"
                    <?php echo $button['target'] ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>
                >
                    <?php echo esc_html($button['title']); ?>
                </a>
            <?php endif; ?>

        </div>

        <?php if ($image) : ?>
            <div class="text-image-media">
                <img
                    src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>"
                    class="text-image-photo"
                />
            </div>
        <?php endif; ?>

    </div>
</section>
