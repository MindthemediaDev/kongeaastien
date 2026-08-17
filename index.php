<!DOCTYPE html>
<html lang="da_DK">
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

<main class="container mx-auto py-12">
  <?php
  if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
      <article class="prose mx-auto">
        <h1 class="text-3xl font-bold"><?php the_title(); ?></h1>
        <div class="mt-4"><?php the_content(); ?></div>
      </article>
    <?php endwhile;
  endif;
  ?>
</main>

<?php get_template_part('parts/footer'); ?>
