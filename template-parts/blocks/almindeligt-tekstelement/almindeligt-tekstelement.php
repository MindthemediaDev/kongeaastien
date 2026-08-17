<?php
/**
 * Article Sidebar Block
 *
 * ACF Fields:
 * - highlighted_articles (repeater)
 *   - billede (image)
 *   - titel (text)
 *   - beskrivelse (textarea)
 *   - link (link)
 * - archive_section_title (text) - defaults to "Artikler fra arkivet"
 * - archive_links (repeater)
 *   - link (link)
 */

$header = get_field('overskrift');
$content = get_field('elementstekst') ?: '';

$block_id = 'text-element-' . $block['id'];

if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="container mx-auto text-block">
    <div id="<?php echo esc_attr($block_id); ?>" class="almindeligt-tekstelement px-3 lg:px-0">

        <h1 class="h1 text-3xl mb-3 almindeligt-tekstelement-head"><?= $header ?></h1>
        <div class="almindeligt-tekstelement-body"><?= $content ?></div>
    </div>
</section>
