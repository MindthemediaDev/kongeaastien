<section class="container municipality-logos mx-auto">
  <div class="grid grid-cols-12 gap-4 pt-8 items-start">
    <div class="col-span-12 lg:col-span-2"></div>
    <?php if( have_rows('municipalities', 'option') ): ?>
      <?php while( have_rows('municipalities', 'option') ): the_row();

        $logo = get_sub_field('logo');
        $contact = get_sub_field('contactinfo');
        $url = get_sub_field('url');

        ?>

        <div class="col-span-12 lg:col-span-3 text-center lg:text-left mb-6">

          <?php if($url): ?>
          <a href="<?php echo esc_url($url); ?>" target="_blank">
            <?php endif; ?>

            <?php if($logo): ?>
              <img
                src="<?php echo esc_url($logo['url']); ?>"
                alt="<?php echo esc_attr($logo['alt']); ?>"
                class="mx-auto lg:mx-0 mb-4"
              >
            <?php endif; ?>

            <?php if($url): ?>
          </a>
        <?php endif; ?>

          <?php if($contact): ?>
            <div class="municipality-logos__contact">
              <?php echo nl2br(wp_kses_post($contact)); ?>
            </div>
          <?php endif; ?>

        </div>

      <?php endwhile; ?>

    <?php endif; ?>
    <div class="col-span-12 lg:col-span-2"></div>
  </div>


  <?php
  $foundation_logo = get_field('ap_mollerske_stottefond', 'option');
  $foundation_url = get_field('url', 'option');


  ?>

  <?php if($foundation_logo): ?>

    <div class="municipality-logos__foundation text-center mt-[60px]">Støttet af:<br><br><br>

      <?php if($foundation_url): ?>
      <a href="<?php echo esc_url($foundation_url); ?>" target="_blank">
        <?php endif; ?>

        <img
          src="<?php echo esc_url($foundation_logo['url']); ?>"
          alt="<?php echo esc_attr($foundation_logo['alt']); ?>"
        >

        <?php if($foundation_url): ?>
      </a>
    <?php endif; ?>

    </div>

  <?php endif; ?>

</section>
