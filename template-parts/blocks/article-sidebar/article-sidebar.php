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

$highlighted_articles  = get_field('highlighted_articles');
$archive_section_title = get_field('archive_section_title') ?: 'Artikler fra arkivet';
$archive_links         = get_field('archive_links');

$block_id = 'article-sidebar-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="article-sidebar-block">

    <?php if ($highlighted_articles) : ?>
        <div class="highlighted-articles">
            <?php foreach ($highlighted_articles as $article) :
                $image       = $article['billede'] ?? null;
                $image_url   = $image['url'] ?? '';
                $image_alt   = $image['alt'] ?? '';
                $titel       = $article['titel'] ?? '';
                $beskrivelse = $article['beskrivelse'] ?? '';
                $link        = $article['link'] ?? null;
                $link_url    = $link['url'] ?? '#';
                $link_title  = $link['title'] ?: 'Læs historien her';
                $link_target = $link['target'] ?? '_self';
            ?>
                <article class="article-card">
                    <?php if ($image_url) : ?>
                        <div class="article-card__image-wrapper">
                            <img
                                src="<?php echo esc_url($image_url); ?>"
                                alt="<?php echo esc_attr($image_alt ?: $titel); ?>"
                                class="article-card__image"
                            />
                        </div>
                    <?php endif; ?>

                    <div class="article-card__content">
                        <div class="article-card__text">
                            <?php if ($titel) : ?>
                                <h3 class="article-card__title"><?php echo esc_html($titel); ?></h3>
                            <?php endif; ?>
                            <?php if ($beskrivelse) : ?>
                                <p class="article-card__excerpt"><?php echo esc_html($beskrivelse); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if ($link_url) : ?>
                            <a
                                href="<?php echo esc_url($link_url); ?>"
                                class="article-card__link"
                                target="<?php echo esc_attr($link_target); ?>"
                                <?php if ($link_target === '_blank') : ?>
                                    aria-label="<?php echo esc_attr($link_title . ' (åbner i nyt vindue)'); ?>"
                                <?php endif; ?>
                            >
                                <?php echo esc_html($link_title); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($archive_links) : ?>
        <div class="archive-links">
            <h3 class="archive-links__title"><?php echo esc_html($archive_section_title); ?></h3>

            <ul class="archive-links__list">
                <?php foreach ($archive_links as $row) :
                    $link        = $row['link'] ?? null;
                    $url         = $link['url'] ?? '#';
                    $title       = $link['title'] ?? '';
                    $link_target = $link['target'] ?? '_self';
                    if (!$title) continue;
                ?>
                    <li class="archive-links__item">
                        <svg class="archive-links__arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18.5 12H5" stroke="#22281F" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 18C13 18 19 13.5811 19 12C19 10.4188 13 6 13 6" stroke="#22281F" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <a
                            href="<?php echo esc_url($url); ?>"
                            class="archive-links__link"
                            target="<?php echo esc_attr($link_target); ?>"
                            <?php if ($link_target === '_blank') : ?>
                                aria-label="<?php echo esc_attr($title . ' (åbner i nyt vindue)'); ?>"
                            <?php endif; ?>
                        >
                            <?php echo esc_html($title); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>
