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

<?php
/*
$etaper = new WP_Query([
  'post_type'      => 'etape',
  'posts_per_page' => 1,
  'orderby'        => 'meta_value_num',
  'meta_key'       => 'etapenummer',
  'order'          => 'ASC',
]);
*/
?>

<main class="mx-auto pb-12">
  <?php if (have_posts()) : ?>
    <section id="<?php echo esc_attr($block_id); ?>" class="pt-0 <?php echo esc_attr($class_name); ?>" style="padding: 0 0 0 0;">
      <?php while (have_posts()) : the_post(); ?>
          <?php
          $fields = get_fields();
          $post_id = get_the_ID();
          $hero_image           = $fields['hero_image'] ?? null;
          $etapenummer          = $fields['etapenummer'] ?? null;
          $etapestart           = $fields['etapestart'] ?? null;
          $etapeslut            = $fields['etapeslut'] ?? null;
          $etapelaengde         = $fields['etapelaengde'] ?? null;
          $short_description    = $fields['short_etapebeskrivelse'] ?? null;
          $long_description     = $fields['long_description'] ?? null;
          $embedded_map         = $fields['embedded_map'] ?? null;
          $gpx_fil              = $fields['gpx_fil'] ?? null;

          $articles_titel       = $fields['articles_titel'] ?? null;
          $articles_link        = $fields['articles_link'] ?? null;
          $articles_links       = $fields['articles_links'] ?? null;

          $history_titel        = $fields['history_titel'] ?? null;
          $history_link         = $fields['history_link'] ?? null;
          $history_links        = $fields['history_links'] ?? null;

          $practic_text         = $fields['practic_text'] ?? null;
          $startaddress         = $fields['startaddress'] ?? null;
          $destination_address  = $fields['destination_address'] ?? null;

          //print_r($hero_image);
          ?>

        <div class="relative w-full overflow-hidden">
          <?php if ($hero_image) : ?>
            <img
              src="<?php echo esc_url($hero_image['url']); ?>"
              alt="<?php echo esc_attr($hero_image['alt'] ?: $etapestart . ' - ' . $etapeslut); ?>"
              class="w-full h-auto max-h-[800px] object-cover"
            />
          <?php endif; ?>
        </div>

      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:gap-12">

          <div class="lg:col-span-6">
            <h1 class="mt-12 mb-4">
                            <span class="inline-flex flex-wrap items-center gap-3 text-4xl font-bold tracking-tight text-heading md:text-5xl lg:text-5xl">
                              <?php echo esc_html($etapestart); ?>
                              <?php if($etapeslut != ""){ ?>
                              <svg class="etaper-teaser-link-arrow w-10 h-10" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path d="M18.5 12H5" stroke="#141B34" stroke-linecap="round" stroke-linejoin="round"/>
                                  <path d="M13 18C13 18 19 13.5811 19 12C19 10.4188 13 6 13 6" stroke="#141B34" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                          
                              <?php echo esc_html($etapeslut); ?>
                              <?php } ?>
                            </span>
                         </h1>
            <?php echo '<span class="long_description">' . $long_description . ' </span>'; ?>



          </div>
          <div class="hidden lg:block lg:col-span-1"></div>
          <aside class="lg:col-span-5 mt-10 lg:-mt-32 z-50">
            <div class="space-y-6">
              <div class="articles bg-[#2B4D18] text-[#FBF6EF] p-[30px] lg:p-[60px]">
                <?php
                  echo '<div class="uppercase font-bold mb-3 hidden">' . __('Artikler om landskab og arter', 'kongeaastien') .'</div>';
                  if($articles_link){
                    echo '<h3><a href="' . $articles_link . '">' . $articles_titel . '</a></h3>';
                  } else {
                    echo '<h3>' . $articles_titel . '</h3>';
                  }
                  echo '<ul class="mt-10">';
                  if($articles_links) {
                    foreach ($articles_links as $article) {

                      $article_id = is_object($article) ? $article->ID : $article;

                      $title = get_field('title', $article_id) ?: get_the_title($article_id);
                      $link = get_permalink($article_id);

                      if (!$title || !$link) {
                        continue;
                      }

                      echo '<li class="flex items-center gap-2 mt-6">';

                      echo '<svg class="etaper-teaser-link-arrow flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path d="M18.5 12H5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M13 18C13 18 19 13.5811 19 12C19 10.4188 13 6 13 6" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>';

                      echo '<a href="' . esc_url($link) . '" class="text-white hover:underline underline">';
                      echo esc_html($title);
                      echo '</a>';

                      echo '</li>';
                    }
                  }
                  echo '</ul>';
                ?>
              </div>
              <div class="history_articles bg-[#347A28] text-[#FBF6EF] p-[30px] lg:p-[60px]">
                <?php
                echo '<div class="uppercase font-bold mb-3 hidden">' . __('Historiske artikler', 'kongeaastien') . '</div>';

                if($history_link){
                  echo '<h3><a href="' . $history_link . '">' . $history_titel . '</a></h3>';
                } else {
                  echo '<h3>' . $history_titel . '</h3>';
                }
                echo '<ul class="mt-10">';
                if($history_links) {
                  foreach ($history_links as $article) {

                    $article_id = is_object($article) ? $article->ID : $article;

                    $title = get_field('title', $article_id) ?: get_the_title($article_id);
                    $link = get_permalink($article_id);

                    if (!$title || !$link) {
                      continue;
                    }

                    echo '<li class="flex items-center gap-2 mt-6">';

                    echo '<svg class="etaper-teaser-link-arrow flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18.5 12H5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 18C13 18 19 13.5811 19 12C19 10.4188 13 6 13 6" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>';

                    echo '<a href="' . esc_url($link) . '" class="text-white hover:underline underline">';
                    echo esc_html($title);
                    echo '</a>';

                    echo '</li>';
                  }
                }
                echo '</ul>';
                ?>
              </div>
              <div class="praktisk text-[#2B4D18] bg-[#FBF6EF] p-[32px] lg:pr-[60px]">
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
                    echo '<p>' . $practic_text . '</p>';
                    ?>


                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-6 mt-16 mb-10 mr-6 lg:mr-12">
                      <div class="flex items-start gap-2">
                        <div>
                          <div class="mb-4 font-bold"><?php print __('Startadresse', 'kongeaastien') ?></div>
                          <?php echo nl2br($startaddress); ?>
                        </div>
                      </div>
                      <div class="flex items-start gap-2">
                        <div>
                          <?php if($destination_address != ""){ ?>
                          <div class="mb-4 font-bold"><?php print __('Slutadresse', 'kongeaastien') ?></div>
                          <?php echo nl2br($destination_address); ?>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </aside>
        </div>
        <div class="embedded_map pt-10 relative">

          <iframe
            id="mapFrame"
            class="w-full h-[450px] sm:h-[450px] md:h-[600px] lg:h-[450px] xl:h-[750px] mt-10"
            src="<?php echo $embedded_map; ?>"
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

        <script>
          const iframe = document.getElementById('mapFrame');
          const fallback = document.getElementById('mapFallback');

          let loaded = false;

          iframe.addEventListener('load', () => {
            loaded = true;
          });

          setTimeout(() => {
            if (!loaded) {
              fallback.classList.remove('hidden');
            }
          }, 4000);
        </script>
      </div>


        <?php endwhile; ?>
    </section>

    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</main>

<?php get_template_part('parts/footer'); ?>
