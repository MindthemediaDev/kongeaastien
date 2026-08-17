<?php

$overtekst = get_field('toptekst');
$titel = get_field('bokstitel');
$links = get_field('links');
$bg = get_field('baggrundsfarve') ?: '#244d1e';

?>

<section class="article-links-block" style="background-color: <?php echo esc_attr($bg); ?>">

    <div class="container">

        <?php if($overtekst): ?>
            <div class="article-links-overtekst">
                <?php echo esc_html($overtekst); ?>
            </div>
        <?php endif; ?>

        <?php if($titel): ?>
            <h2 class="article-links-title">
                <?php echo esc_html($titel); ?>
            </h2>
        <?php endif; ?>

        <?php if($links): ?>
            <div class="article-links-list">

                <?php foreach($links as $row):
                    $link = $row['link'];
                    ?>

                    <span class="arrow">→</span><a class="article-link" href="<?php echo esc_url($link['url']); ?>">
                        <?php echo esc_html($link['title']); ?>
                    </a>

                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </div>

</section>