<?php
/**
 * Text Image Block
 */

$spacer          = get_field('spacer') ?: '';
$block_id = 'spacer-' . $block['id'];

?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($spacer); ?>"></div>
