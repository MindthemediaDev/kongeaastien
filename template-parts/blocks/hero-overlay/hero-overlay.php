<?php
/**
 * Hero Overlay Block
 */

$label = get_field('label') ?: '';
$heading = get_field('heading') ?: '';
$description = get_field('description') ?: '';
$image = get_field('image');
$anchor_links = get_field('anchor_links');

$block_id = 'hero-overlay-' . $block['id'];

if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

$class_name = 'relative w-full';

if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <div class="relative w-full overflow-hidden">
        <?php if ($image) : ?>
            <img
                    src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>"
                    class="w-full h-auto max-h-[800px] object-cover"
            />
        <?php endif; ?>
    </div>

    <div class="relative -mt-32 flex justify-center w-full px-4 lg:-mt-[380px] lg:px-6">
        <div class="w-full max-w-2xl bg-white p-6 lg:p-12">
            <?php if ($label) : ?>
                <div class="mb-6 text-xs font-black uppercase tracking-widest text-sage lg:mb-8">
                    <?php echo esc_html($label); ?>
                </div>
            <?php endif; ?>

            <?php if ($heading) : ?>
                <h1 class="mb-6 text-3xl font-bold leading-tight text-black lg:mb-8 lg:text-5xl">
                    <?php echo esc_html($heading); ?>
                </h1>
            <?php endif; ?>

            <?php if ($description) : ?>
                <div class="mb-12 text-base leading-relaxed text-black lg:mb-16 lg:text-lg">
                    <?php echo wp_kses_post(wpautop($description)); ?>
                </div>
            <?php endif; ?>

          <?php if ($anchor_links) : ?>
            <div class="mb-8 h-px w-full bg-gray-200 lg:mb-10"></div>


                <div class="flex flex-col items-center justify-start gap-4 lg:flex-row lg:gap-8">
                    <?php foreach ($anchor_links as $link_item) :
                        $text = $link_item['text'] ?? '';
                        $url = $link_item['url'] ?? '#';
                        ?>
                        <?php if ($text && $url) : ?>
                        <a
                                href="<?php echo esc_url($url); ?>"
                                class="flex items-center gap-2 text-sm font-normal text-black underline hover:no-underline"
                        >
                                <span class="flex h-6 w-6 flex-shrink-0 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 9l6 6 6-6"/>
                                    </svg>
                                </span>
                            <span><?php echo esc_html($text); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
