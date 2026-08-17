<?php
/**
 * Historier Oversigt Block
 * Shows manually highlighted stories with image cards,
 * followed by remaining stories as text-only green cards.
 */

$fremhaevet_1 = get_field('fremhaevet_historie_1');
$fremhaevet_2 = get_field('fremhaevet_historie_2');

$highlighted_ids = [];
if ($fremhaevet_1) $highlighted_ids[] = $fremhaevet_1->ID;
if ($fremhaevet_2) $highlighted_ids[] = $fremhaevet_2->ID;

$args = [
    'post_type'      => 'historier',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
];

if (!empty($highlighted_ids)) {
    $args['post__not_in'] = $highlighted_ids;
}

$remaining_stories = new WP_Query($args);

function render_tema_label($post_id) {
    $tema = get_field('tema', $post_id);
    if (!$tema) {
        $terms = get_the_terms($post_id, 'tema');
        if ($terms && !is_wp_error($terms)) {
            $tema = $terms[0]->name;
        }
    }
    return $tema;
}
?>

<section class="historier-oversigt">

    <?php if ($fremhaevet_1 || $fremhaevet_2) : ?>
        <div class="historier-fremhaevede">
            <?php
            $highlighted = array_filter([$fremhaevet_1, $fremhaevet_2]);
            foreach ($highlighted as $story) :
                $tema = render_tema_label($story->ID);
                $thumbnail = get_the_post_thumbnail_url($story->ID, 'large');
                $permalink = get_permalink($story->ID);
            ?>
                <a href="<?php echo esc_url($permalink); ?>" class="historier-fremhaevet-kort">
                    <?php if ($thumbnail) : ?>
                        <div class="historier-fremhaevet-billede">
                            <img
                                src="<?php echo esc_url($thumbnail); ?>"
                                alt="<?php echo esc_attr(get_the_title($story->ID)); ?>"
                            />
                        </div>
                    <?php endif; ?>
                    <div class="historier-fremhaevet-indhold">
                        <?php if ($tema) : ?>
                            <span class="historier-tema-label"><?php echo esc_html($tema); ?></span>
                        <?php endif; ?>
                        <h2 class="historier-fremhaevet-titel"><?php echo esc_html(get_the_title($story->ID)); ?></h2>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

  <?php if (!empty($remaining_stories)) : ?>
    <div class="historier-groen-grid mt-10 flex flex-wrap justify-center gap-6">

      <?php foreach ($remaining_stories as $story) : ?>
        <?php
        $tema = get_field("tema", $story->ID);
        $permalink = get_permalink($story->ID);
        $title = get_the_title($story->ID);
        ?>

        <a href="<?php echo esc_url($permalink); ?>" class="historier-groen-kort w-1/3">
          <?php if ($tema) : ?>
            <span class="historier-groen-tema"><?php echo esc_html($tema); ?></span>
          <?php endif; ?>

          <h2 class="historier-groen-titel"><?php echo esc_html($title); ?></h2>
        </a>

      <?php endforeach; ?>

    </div>
  <?php endif; ?>

</section>
