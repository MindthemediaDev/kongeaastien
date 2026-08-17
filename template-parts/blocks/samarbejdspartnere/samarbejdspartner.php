<?php
/**
 * Block: Samarbejdspartnere
 */

$samarbejdspartnere = get_field('samarbejdspartnere');
print  '<div class=" container mx-auto mt-10">';
if ($samarbejdspartnere) : ?>
  <section class="samarbejdspartnere grid grip-cols-1 px-0 lg:px-3">
    <div class="samarbejdspartnere__grid grid grid-cols-2 lg:grid-cols-3 gap-4">
      <?php foreach ($samarbejdspartnere as $item) :
        $logo = $item['logo'] ?? null;
        $link = $item['link'] ?? '';

        if (!$logo) {
          continue;
        }

        $logo_url = $logo['url'] ?? '';
        $logo_alt = $logo['alt'] ?? '';
        ?>

        <div class="samarbejdspartnere__item aspect-square items-center content-center p-[50px] md:p-[60px] lg:p-[70px] xl:p-[80px] 2xl:p-[100px] bg-white">
          <?php if ($link) : ?>
          <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-full h-full">
            <?php endif; ?>

            <img
              src="<?php echo esc_url($logo_url); ?>"
              alt="<?php echo esc_attr($logo_alt); ?>"
              loading="lazy"
              class="max-w-full max-h-full object-contain"
            >

            <?php if ($link) : ?>
          </a>
        <?php endif; ?>
        </div>

      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>
</div>
