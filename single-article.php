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

<main class="mx-auto pb-12 www">
  <?php if (have_posts()) : ?>
    <section id="<?php echo esc_attr($block_id); ?>" class="pt-0 <?php echo esc_attr($class_name); ?>">
      <?php while (have_posts()) : the_post(); ?>
        <?php
        $fields = get_fields();
        $post_id = get_the_ID();

        $header                     = $fields['header'] ?? null;
        $underrubrik                = $fields['underrubrik'] ?? null;
        $article_text               = $fields['article_text'] ?? null;
        $primary_related_articles   = $fields['primary_related_articles'] ?? null;
        $secondary_related_articles = $fields['secondary_related_articles'] ?? null;
        $indlejret_kort             = $fields['indlejret_kort'] ?? null;

        $featured_image_id          = get_post_thumbnail_id(get_the_ID());
        $featured_image_url         = $featured_image_id ? wp_get_attachment_image_url($featured_image_id, 'full') : null;
        $featured_image_caption     = wp_get_attachment_caption($featured_image_id);

        //print_r($hero_image);
        ?>

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
                <?php if ($featured_image_id) : ?>
                  <?php echo wp_get_attachment_image($featured_image_id, 'full', false, ['class' => 'w-full h-auto']); ?>
                  <div class="text-xs mt-1"><?php echo $featured_image_caption; ?></div>
                <?php endif; ?>


                <div class="p-[30px] mt-10">

                  <?php if ($primary_related_articles) : ?>
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
                  <?php endif; ?>

                </div>




                <div class="p-[30px]">
                  <?php if ($secondary_related_articles) : ?>
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
                  <?php endif; ?>

                </div>

              </div>
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
    </section>

    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</main>

<?php get_template_part('parts/footer'); ?>
