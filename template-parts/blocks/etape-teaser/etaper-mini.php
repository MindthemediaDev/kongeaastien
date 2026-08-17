<?php
$etaper = new WP_Query([
  'post_type'      => 'etape',
  'posts_per_page' => -1,
  'orderby'        => 'meta_value_num',
  'meta_key'       => 'etapenummer',
  'order'          => 'ASC',
  'meta_query'     => [
    [
      'key'     => 'rundtur',
      'value'   => 0,
      'compare' => '='
    ]
  ]
]);
$headline = get_field('headline');

$block_id = 'etaper-mini-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

$class_name = 'etaper-mini-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="container mx-auto <?php echo esc_attr($class_name); ?>">
    <div class="etaper-mini-inner">

<?php if ($headline) : ?>
    <h2 class="etaper-mini-headline"><?php echo esc_html($headline); ?></h2>
<?php endif; ?>

<?php if ($etaper->have_posts()) : ?>
    <div class="">

        <?php if ($etaper && $etaper->have_posts()) : ?>
            <ul class="etaper-mini-list" aria-label="<?php echo esc_attr($headline ?? 'Etaper'); ?>">
                <?php while ($etaper->have_posts()) : $etaper->the_post();

                    $post_id  = get_the_ID();
                    $nummer   = get_field('etapenummer', $post_id);
                    $fra      = get_field('etapestart', $post_id);
                    $til      = get_field('etapeslut', $post_id);
                    $distance = get_field('etapelaengde', $post_id);
                    $link     = get_field('link_til_etapeside', $post_id);

                    $route_text = trim(($fra ?: '') . ' → ' . ($til ?: ''));
                    $distance_text = $distance ? $distance . ' km' : '';

                    $aria_parts = [];
                    if ($nummer) {
                        $aria_parts[] = 'Etape ' . $nummer;
                    }
                    if ($route_text !== '→') {
                        $aria_parts[] = $route_text;
                    }
                    if ($distance_text) {
                        $aria_parts[] = $distance_text;
                    }

                    $aria_label = implode(', ', $aria_parts);
                    $is_link = !empty($nummer);
                    $tag = $is_link ? 'a' : 'button';
                    ?>

                  <li class="border-b border-black/20">
                  <<?php echo $tag; ?>
                  class="etaper-mini-row-inner grid w-full grid-cols-[120px_1fr_120px_40px] items-center gap-6 py-6 text-left"
                    <?php if ($is_link) : ?>
                        href="/etape/etape-<?php echo esc_html($nummer); ?>"
                    <?php else : ?>
                        type="button"
                    <?php endif; ?>
                    <?php if ($aria_label) : ?>
                        aria-label="<?php echo esc_attr($aria_label); ?>"
                    <?php endif; ?>
                    >
                    <?php if ($nummer) : ?>
                        <span class="etaper-mini-number">Etape <?php echo esc_html($nummer); ?></span>
                    <?php endif; ?>

                  <span class="etaper-mini-route flex items-center gap-3 min-w-0">
                        <span class="etaper-mini-fra"><?php echo esc_html($fra); ?></span>

                        <svg class="etaper-mini-arrow-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18.5 12H5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 18C13 18 19 13.5811 19 12C19 10.4188 13 6 13 6" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <span class="etaper-mini-til"><?php echo esc_html($til); ?></span>
                    </span>

                    <?php if ($distance_text) : ?>
                      <span class="etaper-mini-distance text-right"><?php echo esc_html($distance_text); ?></span>
                    <?php endif; ?>

                    <span class="flex justify-end">
                        <svg class="etaper-mini-link-arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path d="M18.5 12H5" stroke="#141B34" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M13 18C13 18 19 13.5811 19 12C19 10.4188 13 6 13 6" stroke="#141B34" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>

                    </<?php echo $tag; ?>>
                    </li>

                <?php endwhile; ?>
            </ul>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
<?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
    </div>
    </section>

<?php

/**
 * Etaper Mini Block
 * Displays a list of route stages with from/to locations and distances.
 */


$etaper   = get_field('etaper');

?>
