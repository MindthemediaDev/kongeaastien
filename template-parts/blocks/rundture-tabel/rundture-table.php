<?php
if (is_admin()) {
  echo '<p>Rundture listing vises kun på frontend.</p>';
  return;
}

$etaper = new WP_Query([
  'post_type'      => 'etape',
  'posts_per_page' => -1,
  'meta_key'       => 'etapenummer',
  'orderby'        => 'meta_value_num',
  'order'          => 'ASC',
  'meta_query'     => [
    [
      'key'     => 'rundtur',
      'value'   => 1,
      'compare' => '='
    ]
  ]
]);

$headline = "Se Kongeåstiens rundture her"; //get_field('headline');

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

  <div class="etaper-overview">

    <?php if ($headline) : ?>
      <h2 class="mb-8 text-4xl font-bold"><?php echo esc_html($headline); ?></h2>
    <?php endif; ?>

    <div class="flex justify-end">
    <a href="#map"><span class="inline-flex rounded-full bg-darkgreen px-4 py-1 text-white mb-2">
      Se kortoversigt
      </span></a>
    </div>
    <?php if ($etaper->have_posts()) : ?>
      <div class="border border-black">

        <?php while ($etaper->have_posts()) : $etaper->the_post(); ?>
          <?php
          $post_id = get_the_ID();

          $nummer        = get_field('etapenummer', $post_id);
          $fra           = get_field('etapestart', $post_id);
          $til           = get_field('etapeslut', $post_id);
          $distance      = get_field('etapelaengde', $post_id);
          $beskrivelse   = get_field('short_etapebeskrivelse', $post_id); // replace with your actual field name
          $link          = get_permalink($post_id);

          // Rundtur fields - replace these with your actual ACF field names
          $rundtur       = get_field('rundtur', $post_id);
          $rundtur_tekst = get_field('rundtur_tekst', $post_id); // textarea
          $rundture      = get_field('rundture', $post_id); // repeater, optional
          ?>

          <article class="grid grid-cols-1 md:grid-cols-[220px_1fr_380px] border-b border-black last:border-b-0">

            <div class="border-b border-black md:border-b-0 md:border-r border-black p-6">
              <?php if ($nummer) : ?>
                <div class="text-2xl font-bold leading-none">
                  Etape <?php echo esc_html($nummer); ?>.
                </div>
              <?php endif; ?>
            </div>

            <div class="border-b border-black md:border-b-0 md:border-r border-black p-6">
              <?php if ($fra || $til || $distance) : ?>
                <?php
                $link  = get_permalink($post_id);
                echo '<a href="'.$link.'">';
                ?>
                <span class="mb-6 text-2xl leading-tight">
                  <?php if ($fra) : ?>
                    <?php echo esc_html($fra); ?>
                  <?php endif; ?>

                  <?php if ($distance) : ?>
                    <span class="ml-3"><?php echo esc_html($distance); ?> km.</span>
                  <?php endif; ?>
                </span>
                </a>
              <?php endif; ?>

              <?php if ($beskrivelse) : ?>
                <div class="max-w-4xl text-sm leading-relaxed">
                  <?php echo wp_kses_post(wpautop($beskrivelse)); ?>
                </div>
              <?php endif; ?>

            </div>

            <div class="p-6">
              <?php if ($rundtur || $rundtur_tekst || $rundture) : ?>
                <div class="space-y-4">

                                    <span class="inline-flex rounded-full bg-lightgreen px-4 py-1 text-sm text-white">
                                        Rundtur
                                    </span>

                  <?php if (!empty($rundture) && is_array($rundture)) : ?>
                    <div class="space-y-3 leading-snug">
                      <?php foreach ($rundture as $item) : ?>
                        <?php
                        $rundtur_post_id = is_object($item) ? $item->ID : $item;

                        $titel = get_field('etapestart', $rundtur_post_id);
                        $km    = get_field('etapelaengde', $rundtur_post_id);
                        ?>

                        <?php if ($titel || $km) : ?>
                          <div>
                            <?php
                              $link  = get_permalink($rundtur_post_id);
                              echo '<a href="'.$link.'">';
                            ?>
                            <?php echo esc_html($titel); ?>
                            <?php if ($km) : ?>
                              <span><?php echo esc_html($km); ?> km.</span>
                            <?php endif; ?>
                            <?php echo '</a>'; ?>
                          </div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>

                  <?php elseif ($rundtur_tekst) : ?>
                    <div class="text-2xl leading-snug">
                      <?php echo wp_kses_post(wpautop($rundtur_tekst)); ?>
                    </div>
                  <?php endif; ?>

                </div>
              <?php endif; ?>
            </div>

          </article>

        <?php endwhile; ?>

      </div>

      <?php wp_reset_postdata(); ?>
    <?php endif; ?>

  </div>
</section>
