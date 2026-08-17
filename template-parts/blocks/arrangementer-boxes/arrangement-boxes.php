<?php
$current_post_id = $GLOBALS['tema_article_id'] ?? get_the_ID();

$selected_stories = get_field('selected_stories');
$numbers_with_image = get_field('antal_med_billede') ?? 0;

$get_story_id = function ($story) {
  if (is_object($story) && isset($story->ID)) {
    return (int) $story->ID;
  }

  if (is_array($story) && isset($story['ID'])) {
    return (int) $story['ID'];
  }

  return (int) $story;
};

if (get_field('use_tema_template', $current_post_id)) {

  $category_to_page = [
    'historien'   => 36,
    'aktiviteter' => 40,
    'naturen'     => 38,
  ];

  $categories = get_the_category($current_post_id);
//print $categories[0]->slug;
  if (!empty($categories)) {
    //print $categories[0]->slug;

    $category_name = $categories[0]->slug;
//print $category_name;
    if (isset($category_to_page[$category_name])) {
//print "hest";
      $source_page_id = $category_to_page[$category_name];
//print $source_page_id;
      $block_data = mtm_get_acf_block_data_from_post(
        $source_page_id,
        'acf/arrangementer-boxes'
      );

      $selected_stories = $block_data['selected_stories'] ?? [];
      //print_r($selected_stories);
      $numbers_with_image = 0;
    }
  }
}
//sprint_r($selected_stories);
if($numbers_with_image<4){
  $numbers_with_image = $numbers_with_image;
  $per_line = $numbers_with_image;
} else{
  if($numbers_with_image%3 == 0){
    $per_line = 3;
  } else {
    $per_line = 2;
  }
}

$all_stories = is_array($selected_stories) ? $selected_stories : [];

$featured_stories = array_slice($all_stories, 0, $numbers_with_image);
$remaining_stories = array_slice($all_stories, $numbers_with_image);

$get_story_id = function ($story) {
  return is_object($story) ? $story->ID : (int) $story;
};

$has_huhej_tema = function ($tema) {
  return mb_strtolower(trim((string) $tema)) === 'huhej';
};
?>

<section class="historier-oversigten container mx-auto px-4 mt-10">

  <?php if (!empty($featured_stories)) : ?>
    <div class="historier-fremhaevede" style="grid-template-columns: repeat(<?= $per_line ?>, 1fr);">
      <?php foreach ($featured_stories as $story) : ?>
        <?php
      //print_r($story);
        $story_id = $get_story_id($story);
//print $story_id;
        $title = get_the_title($story_id);
        $permalink = get_permalink($story_id);
        $thumbnail = get_the_post_thumbnail_url($story_id, 'large');
        $tema = get_field('tema', $story_id);
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
        $story_id = $get_story_id($story);

        $title = get_the_title($story_id);
        $permalink = get_permalink($story_id);
        $thumbnail = get_the_post_thumbnail_url($story_id, 'large');
        $tema = get_field('tema', $story_id);


        $current_post_id = get_the_ID();

        if ($story_id === $current_post_id) {
          ?>
          <a href="<?php echo esc_url($permalink); ?>" class="historier-graa-kort w-1/3">
          <?php if ($tema) : ?>
            <span class="historier-groen-tema"><?php echo esc_html($tema); ?></span>
          <?php endif; ?>
          <h2 class="historier-groen-titel"><?php echo esc_html($title); ?></h2>
          </a>
        <?php
        } else {
          ?>
          <a href="<?php echo esc_url($permalink); ?>" class="historier-groen-kort w-1/3">
          <?php if ($tema) : ?>
            <span class="historier-groen-tema"><?php echo esc_html($tema); ?></span>
          <?php endif; ?>
          <h2 class="historier-groen-titel"><?php echo esc_html($title); ?></h2>
          </a>
        <?php
        }
        ?>
        <?php
        ?>

      <?php endforeach; ?>

    </div>
  <?php endif; ?>

</section>

<?php
// mtm_get_acf_block_data_from_post() er flyttet til functions.php
?>
