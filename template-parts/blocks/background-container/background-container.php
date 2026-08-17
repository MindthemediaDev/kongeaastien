<?php
$bg = get_field('background_color') ?: 'white';
$fields = get_field('text_with_image');
$heading          = $fields['heading'] ?: '';
$body_text        = $fields['body_text'] ?: '';
$button           = $fields['button'];
$image            = $fields['image'];
$image_position   = $fields['image_position'] ?: 'left';

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$block_id = 'text-image-' . $block['id'];
if($bg == '#EBE2D4'){
  $textcolor = "text-black";
  $btn_color = "bg-darkgreen";
} else {
  $btn_color = "primary";
  $textcolor = "text-white";
}
//var_dump($fields);
?>

<section class="section dark-bg" style="background-color:<?php echo esc_attr($bg); ?>">
  <div class="px-6 <?php print $textcolor; ?> >">

    <section id="<?php echo esc_attr($block_id); ?>" class="container mx-auto text-image-block">
      <div class="text-image-inner text-image-inner--<?php echo esc_attr($image_position); ?>">

        <div class="text-image-content">

          <?php if ($heading) : ?>
            <h2 class="text-image-heading">
              <?php echo esc_html($heading); ?>
            </h2>
          <?php endif; ?>

          <?php if ($body_text) : ?>
            <div class="text-image-body">
              <?php echo wp_kses_post(wpautop($body_text)); ?>
            </div>
          <?php endif; ?>

          <?php if ($button && !empty($button['url'])) : ?>
            <a
              href="<?php echo esc_url($button['url']); ?>"
              class="text-image-btn <?php echo $btn_color; ?>"
              <?php echo $button['target'] ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>
            >
              <?php echo esc_html($button['title']); ?>
            </a>
          <?php endif; ?>

        </div>

        <?php if ($image) : ?>
          <div class="text-image-media">
            <img
              src="<?php echo esc_url($image['url']); ?>"
              alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>"
              class="text-image-photo"
            />
          </div>
        <?php endif; ?>

      </div>
    </section>


  </div>
</section>
