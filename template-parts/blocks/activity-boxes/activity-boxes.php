<?php
$args = [
  'post_type'      => 'article',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
  'tax_query'      => [
    [
      'taxonomy' => 'category',
      'field'    => 'slug',
      'terms'    => 'aktiviteter',
    ],
  ],
];

$stories_query = new WP_Query($args);
echo '<pre>';
//print_r(get_object_taxonomies('article'));
echo '</pre>';
$all_stories = $stories_query->posts ?? [];
//print_r($all_stories);
$featured_stories = array_slice($all_stories, 0, 0);
$remaining_stories = array_slice($all_stories, 0);
?>

<section class="historier-oversigten container mx-auto px-4 mt-10">

  <?php if (!empty($featured_stories)) : ?>
    <div class="historier-fremhaevede">
      <?php foreach ($featured_stories as $story) : ?>
        <?php
        $tema = get_field("tema", $story->ID); //render_tema_label($story->ID);
        $thumbnail = get_the_post_thumbnail_url($story->ID, 'large');
        $permalink = get_permalink($story->ID);
        $title = get_the_title($story->ID);
        ?>
        <a href="<?php echo esc_url($permalink); ?>" class="historier-fremhaevet-kort">
          <?php if ($thumbnail) : ?>
            <div class="historier-fremhaevet-billede">
              <img
                src="<?php echo esc_url($thumbnail); ?>"
                alt="<?php echo esc_attr($title); ?>"
              />
            </div>
          <?php endif; ?>

          <div class="historier-fremhaevet-indhold bg-lightsand">
            <?php if ($tema) : ?>
              <span class="historier-tema-label"><?php echo esc_html($tema); ?></span>
            <?php endif; ?>

            <h2 class="historier-fremhaevet-titel"><?php echo esc_html($title); ?></h2>
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
