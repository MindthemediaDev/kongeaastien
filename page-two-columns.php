<?php
/*
Template Name: Two Columns Layout
*/
get_header();
?>

  <main class="container mx-auto py-16">

    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-12">

      <!-- LEFT COLUMN -->
      <div class="content-left">
        <?php the_content(); ?>
      </div>

      <!-- RIGHT COLUMN -->
      <aside class="content-right">
        <?php
        get_template_part('template-parts/blocks/cards');
        ?>
      </aside>

    </div>

  </main>

<?php get_footer(); ?>
