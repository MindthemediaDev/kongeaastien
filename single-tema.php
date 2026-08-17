<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="9694592d-aa39-415d-a1bb-6c1a3e70626c" data-blockingmode="auto" type="text/javascript"></script>
  <!-- Matomo -->
  <script>
    var _paq = window._paq = window._paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u='https://kolding.matomo.cloud/';
      _paq.push(['setTrackerUrl', u+'matomo.php']);
      _paq.push(['setSiteId', '13']);
      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      g.async=true; g.src='https://cdn.matomo.cloud/kolding.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <!-- End Matomo Code -->
  <?php wp_head(); ?>
</head>

<body <?php body_class('bg-primary'); ?>>

<?php get_template_part('parts/header'); ?>

<main class="mx-auto pb-12">
  <?php if (have_posts()) : ?>
    <section id="<?php echo esc_attr($block_id); ?>" class="pt-0 <?php echo esc_attr($class_name); ?>" style="padding: 0;">
      <?php while (have_posts()) : the_post(); ?>
        <?php
        $fields = get_fields();
        $post_id = get_the_ID();
        $featured_image_id          = get_post_thumbnail_id(get_the_ID());
        //print_r($fields);
        $hero_image                 = $featured_image_id ? wp_get_attachment_image_url($featured_image_id, 'full') : null;
        $focal_x                    = $fields['focal_x'] ?? null;
        $focal_y                    = $fields['focal_y'] ?? null;
        $header                     = $fields['header'] ?? null;
        $underrubrik                = $fields['underrubrik'] ?? null;
        $article_text               = $fields['article_text'] ?? null;
        $primary_related_articles   = $fields['primary_related_articles'] ?? null;
        $secondary_related_articles = $fields['secondary_related_articles'] ?? null;
        $indlejret_kort             = $fields['indlejret_kort'] ?? null;
        $practic_text               = $fields['praktiske'] ?? null;
        $info_boks                  = $fields['infoboks'] ?? null;

        $featured_image_id          = get_post_thumbnail_id(get_the_ID());
        $featured_image_url         = $featured_image_id ? wp_get_attachment_image_url($featured_image_id, 'full') : null;
        $featured_image_caption     = wp_get_attachment_caption($featured_image_id);

        //print_r($hero_image);
        ?>

        <div class="relative w-full overflow-hidden" style="aspect-ratio:167/59">
          <?php if ($hero_image) : ?>
            <img
              src="<?php echo esc_url($hero_image); ?>"
              alt="<?php echo $fields["header"]; ?>"
              class="w-full h-auto max-h-[800px] object-cover object-center hidden"
            />
            <img
              src="<?php echo esc_url($hero_image); ?>"
              alt="<?php echo $fields["header"]; ?>"
              class="w-full h-full object-cover"
              style="object-position: <?php echo esc_attr($focal_x); ?>% <?php echo esc_attr($focal_y); ?>%;"
            >
          <?php endif; ?>
        </div>

        <div class="container mx-auto px-4">
          <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:gap-12">

            <div class="lg:col-span-6">
              <h1 class="mt-12 mb-4 text-4xl">
                <?php echo esc_html($header); ?>
              </h1>
              <?php echo '<div class="underrubrik text-darkgreen text-2xl mb-6">' . $underrubrik . ' </div>'; ?>
              <?php echo '<div class="artikeltekst">' . $article_text . ' </div>'; ?>
            </div>
            <aside class="lg:col-span-6 mt-10">
              <div class="">


                  <?php if ($primary_related_articles) : ?>
                    <div class="p-[30px] mt-10">

                    <?php foreach ($primary_related_articles as $article) : ?>
                      <?php
                      $article_id     = $article->ID;
                      $article_fields = get_fields($article_id);

                      $related_header      = $article_fields['header'] ?? null;
                      $related_underrubrik = substr($article_fields['underrubrik'], 0, 150) ?? null;

                      $article_link      = get_permalink($article_id);
                      $article_image_id  = get_post_thumbnail_id($article_id);
                      ?>
                      <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 items-center">
                        <div class="lg:col-span-1">
                          <a href="<?php echo esc_url($article_link); ?>" class="block">
                            <?php if ($article_image_id) : ?>
                              <?php echo wp_get_attachment_image($article_image_id, 'medium_large', false, ['class' => 'w-full h-auto']); ?>
                            <?php endif; ?>
                          </a>
                        </div>
                        <div class="lg:col-span-1">
                          <?php if ($related_header) : ?>
                            <h3 class="text-xl"><?php echo esc_html($related_header); ?></h3>
                          <?php endif; ?>

                          <?php if ($related_underrubrik) : ?>
                            <p class="mt-6"><?php echo esc_html($related_underrubrik); ?></p>
                          <?php endif; ?>

                          <p class="mt-6"></p><a href="<?php echo $article_link ; ?>" class="underline"><?php print __('Læs historien her', 'kongeaastien') ?></a></p>

                        </div>
                      </div>
                    <?php endforeach; ?>
                    </div>
                  <?php endif; ?>






                <?php if ($secondary_related_articles) : ?>
                  <div class="p-[30px]">
                    <h3 class="text-2xl mb-6"><?php print __('Artikler fra arkivet', 'kongeaastien') ?></h3>

                    <?php foreach ($secondary_related_articles as $article) : ?>
                      <?php
                      $article_id    = $article->ID;
                      $article_link  = get_permalink($article_id);
                      $article_title = get_the_title($article_id);
                      ?>

                      <a href="<?php echo esc_url($article_link); ?>" class="flex items-center gap-2 underline ms-2">
                        <svg class="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path d="M18.5 12H5" stroke="#141B34" stroke-linecap="round" stroke-linejoin="round"></path>
                          <path d="M13 18C13 18 19 13.5811 19 12C19 10.4188 13 6 13 6" stroke="#141B34" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <?php echo esc_html($article_title); ?>
                      </a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>



              </div>
              <?php
              if($practic_text != ""){
                ?>

                <div class="praktisk text-[#2B4D18] bg-[#FBF6EF] p-[32px] lg:pr-[60px] mb-6 mt-[70px]">
                  <div class="flex items-start gap-[30px]">

                    <svg class="flex-shrink-0 w-10 h-10" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M16.0002 10.6667V16.6667M3.3335 16C3.3335 10.0294 3.3335 7.04271 5.18816 5.18804C7.04283 3.33337 10.0282 3.33337 16.0002 3.33337C21.9708 3.33337 24.9575 3.33337 26.8122 5.18804C28.6668 7.04271 28.6668 10.028 28.6668 16C28.6668 21.9707 28.6668 24.9574 26.8122 26.812C24.9575 28.6667 21.9722 28.6667 16.0002 28.6667C10.0295 28.6667 7.04283 28.6667 5.18816 26.812C3.3335 24.9574 3.3335 21.972 3.3335 16Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M16 21.3174V21.3307" stroke="black" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <div>
                      <?php
                      echo '<div class="font-bold mb-3 text-xl">' . __('Praktisk', 'kongeaastien') . '</div>';
                      ?>
                      <?php
                      echo nl2br($practic_text);
                      ?>

                    </div>
                  </div>
                </div>
                <?php
              }
              ?>
              <?php
              if($info_boks != ""){
                ?>

                <div class="praktisk text-[#2B4D18] bg-[#FBF6EF] p-[32px] lg:pr-[60px] mb-6">
                  <div class="flex items-start gap-[30px]">

                    <svg class="flex-shrink-0 w-10 h-10" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M16.0002 10.6667V16.6667M3.3335 16C3.3335 10.0294 3.3335 7.04271 5.18816 5.18804C7.04283 3.33337 10.0282 3.33337 16.0002 3.33337C21.9708 3.33337 24.9575 3.33337 26.8122 5.18804C28.6668 7.04271 28.6668 10.028 28.6668 16C28.6668 21.9707 28.6668 24.9574 26.8122 26.812C24.9575 28.6667 21.9722 28.6667 16.0002 28.6667C10.0295 28.6667 7.04283 28.6667 5.18816 26.812C3.3335 24.9574 3.3335 21.972 3.3335 16Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M16 21.3174V21.3307" stroke="black" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <div>
                      <?php
                      echo nl2br($info_boks);
                      ?>

                    </div>
                  </div>
                </div>
                <?php
              }
              ?>
            </aside>

          </div>

          <?php if($indlejret_kort != ""){ ?>
            <div class="embedded_map pt-10 relative">
              <iframe
                id="mapFrame"
                class="w-full h-[450px] sm:h-[450px] md:h-[600px] lg:h-[450px] xl:h-[750px] mt-10"
                src="<?php echo $indlejret_kort; ?>"
              ></iframe>

              <div
                id="mapFallback"
                class="hidden absolute inset-0 flex items-center justify-center bg-[#F2ECE2] p-6 text-center"
              >
                <div>
                  <p class="text-lg font-semibold mb-2">
                    Kortet kunne ikke indlæses
                  </p>

                  <p>
                    Accepter venligst cookies for at vise det indlejrede kort.
                  </p>
                  <button
                    type="button"
                    onclick="Cookiebot.renew()"
                    class="bg-darkgreen text-white px-6 py-3 rounded-md"
                  >
                    Cookieindstillinger
                  </button>
                </div>
              </div>

            </div>
          <?php } ?>

        </div>
      <?php endwhile; ?>

      <?php
      $current_post = $post;
      $current_post_id = get_the_ID();

      // Hent kategorier på den aktuelle artikel
      $categories = get_the_category($current_post_id);
      $cat_slug = !empty($categories) ? $categories[0]->slug : '';

      // Vælg block alt efter kategori
      if ($cat_slug === 'historie') {
        $block = '<!-- wp:acf/history-boxes {"name":"acf/history-boxes","mode":"preview"} /-->';
      } elseif ($cat_slug === 'naturen') {
        $block = '<!-- wp:acf/nature-boxes {"name":"acf/nature-boxes","mode":"preview"} /-->';
      } elseif ($cat_slug === 'aktiviteter') {
        $block = '<!-- wp:acf/arrangementer-boxes {"name":"acf/arrangementer-boxes","mode":"preview"} /-->';
      } else {
        // Fallback hvis ingen kategori matcher
        $block = '<!-- wp:acf/arrangementer-boxes {"name":"acf/arrangementer-boxes","mode":"preview"} /-->';
      }
//print htmlspecialchars($block);
      echo do_blocks($block);

      //echo do_blocks('<!-- wp:acf/arrangementer-boxes {"name":"acf/arrangementer-boxes","mode":"preview"} /-->');

      $post = $current_post;
      setup_postdata($post);
      ?>

    </section>

    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</main>

<?php get_template_part('parts/footer'); ?>
