<!-- header.php -->
<header class="bg-[#e9e3d8] border-b border-black/10">
  <div class="container mx-auto px-6">
    <a href="#tegn-div" class="skip bg-darkgreen border-darkgreen text-[#F2ECE2] mx-auto " aria-label="Gå til hovedindholdet">Gå til hovedindholdet</a>
    <div class="grid grid-cols-12 gap-4 pt-8 items-start">

      <!-- Logo (left) -->
      <div class="col-span-12 lg:col-span-2">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-start" aria-label="<?php bloginfo('name'); ?>">
          <img
            class="h-10 w-auto block"
            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/gfx/kongeaastien_logo.svg"
            alt="Kongeåstien"
          >
        </a>
      </div>

      <!-- Middle: Nav -->
      <div class="col-span-12 lg:col-span-10">

        <!-- Navigation -->
        <nav id="mobile-menu" class="hidden lg:block mt-4 pb-6 lg:pb-0">
          <?php
          wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class' => 'flex flex-col lg:flex-row lg:justify-start text-[20px] font-normal text-black lg:[&>li]:mx-8 [&>li]:my-3 lg:[&>li]:my-0 [&>.current-menu-item>a]:text-red',
          ]);
          ?>
        </nav>
      </div>

      <div class="col-span-12 lg:col-span-10">
        <button
          id="mobile-menu-toggle"
          class="ml-auto mt-6 lg:hidden flex items-center"
          aria-label="Open menu"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <div class="col-span-10 col-start-0 lg:col-start-3">
        <?php if ( function_exists('yoast_breadcrumb') ) : ?>
          <div class="pb-4 ml-0 lg:ml-8 mt-0 lg:mt-2">
            <?php if ( ! is_front_page() ) : ?>
              <?php yoast_breadcrumb('<nav class="text-sm text-black/60">','</nav>'); ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>
<div id="tegn-div">
