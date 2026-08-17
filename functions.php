<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Theme setup
 */
function kongeaastien_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('responsive-embeds');
  add_theme_support('editor-styles');
  add_theme_support('wp-block-styles');
  add_theme_support('align-wide');
  add_theme_support('automatic-feed-links');
  add_theme_support('html5', [
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script',
  ]);

  register_nav_menus([
    'primary' => __('Primary Menu', 'kongeaastien'),
  ]);

  // Load editor stylesheet
  add_editor_style('assets/css/editor.css');
}
add_action('after_setup_theme', 'kongeaastien_theme_setup');

add_action('template_redirect', function () {
    if (is_404() && !is_admin()) {
        wp_redirect(home_url('/'), 301);
        exit;
    }
});

/**
 * Enqueue frontend assets
 */
function kongeaastien_enqueue_assets() {
  $theme_version = wp_get_theme()->get('Version');

  // Only keep this if you actually use style.css for real styling.
  // Otherwise remove it.
  wp_enqueue_style(
    'kongeaastien-style',
    get_stylesheet_uri(),
    [],
    $theme_version
  );

  wp_enqueue_style(
    'kongeaastien-main',
    get_template_directory_uri() . '/assets/css/main.css',
    [],
    $theme_version
  );
}
add_action('wp_enqueue_scripts', 'kongeaastien_enqueue_assets');


/**
 * Enqueue block editor assets
 */
function kongeaastien_enqueue_block_editor_assets() {
  $theme_version = wp_get_theme()->get('Version');

  wp_enqueue_style(
    'kongeaastien-editor',
    get_template_directory_uri() . '/assets/css/editor.css',
    [],
    $theme_version
  );
}
add_action('enqueue_block_editor_assets', 'kongeaastien_enqueue_block_editor_assets');


/**
 * Register ACF blocks from block folders
 */
function kongeaastien_register_blocks() {
  $blocks = glob(get_template_directory() . '/template-parts/blocks/*');

  if (!$blocks) {
    return;
  }

  foreach ($blocks as $block) {
    if (file_exists($block . '/block.json')) {
      register_block_type($block);
    }
  }
}
add_action('init', 'kongeaastien_register_blocks');


/**
 * Change Yoast breadcrumb separator
 */
add_filter('wpseo_breadcrumb_separator', function () {
  return ' / ';
});


/**
 * Make backend/editor more readable
 */
function kongeaastien_admin_styles() {
  echo '<style>
        .editor-styles-wrapper {
            font-family: Arial, sans-serif;
        }

        .acf-fields.-left > .acf-field:before {
            background: #f8f8f8;
        }

        .acf-field .acf-label label {
            font-weight: 600;
        }

        .interface-interface-skeleton__content {
            background: #f5f5f5;
        }
    </style>';
}
add_action('admin_head', 'kongeaastien_admin_styles');


/**
 * Optional: disable Gutenberg custom colors if you want stricter control
 */
function kongeaastien_editor_settings($editor_settings, $editor_context) {
  $editor_settings['disableCustomColors'] = true;
  $editor_settings['disableCustomGradients'] = true;

  return $editor_settings;
}
add_filter('block_editor_settings_all', 'kongeaastien_editor_settings', 10, 2);

function kongeaastien_block_category($categories) {
  $categories[] = [
    'slug'  => 'kongeaastien',
    'title' => __('Kongeåstien Blocks', 'kongeaastien'),
    'icon'  => null,
  ];

  return $categories;
}
add_filter('block_categories_all', 'kongeaastien_block_category');

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title' => 'Footer Settings',
    'menu_title' => 'Footer Settings',
    'menu_slug'  => 'footer-settings',
    'capability' => 'edit_posts',
    'redirect'   => false
  ));
}



function theme_scripts() {

  wp_enqueue_script(
    'openlayers',
    'https://cdn.jsdelivr.net/npm/ol@latest/dist/ol.js',
    [],
    null,
    true
  );

  wp_enqueue_style(
    'openlayers',
    'https://cdn.jsdelivr.net/npm/ol@latest/ol.css'
  );

  wp_enqueue_script(
    'map-script',
    get_template_directory_uri() . '/assets/js/map.js',
    ['openlayers'],
    null,
    true
  );
}

add_action('wp_enqueue_scripts', 'theme_scripts');


function allow_gpx_uploads($mimes) {
  $mimes['gpx'] = 'application/gpx+xml';
  $mimes['gpx'] = 'text/xml';
  return $mimes;
}
add_filter('upload_mimes', 'allow_gpx_uploads');

function etape_teaser_shortcode($atts) {
  $atts = shortcode_atts([
    'nummer' => '', // etapenummer
  ], $atts);

  ob_start();

  $args = [
    'post_type'      => 'etape',
    'posts_per_page' => 1,
    'meta_key'       => 'etapenummer',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
  ];

  // If a specific etape is requested
  if (!empty($atts['nummer'])) {
    $args['meta_query'] = [
      [
        'key'   => 'etapenummer',
        'value' => $atts['nummer'],
        'compare' => '='
      ]
    ];
  }

  $etaper = new WP_Query($args);

  if ($etaper->have_posts()) :
    while ($etaper->have_posts()) : $etaper->the_post();

      $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
      $nummer   = get_field('etapenummer');
      $fra      = get_field('etapestart');
      $til      = get_field('etapeslut');
      $distance = get_field('etapelaengde');
      ?>

      <div class="relative w-full aspect-video mt-12"  style="background-image: url('<?php echo esc_url($image_url); ?>');">
        <!-- Content -->

          <div class="etape-teaser absolute bottom-5 left-5 w-full">
            <div class="bg-white p-3 w-9/12">
              <strong>Relevant etape</strong><br>
                <span class="text-3xl font-light">
              <?php echo esc_html($fra); ?> → <?php echo esc_html($til); ?>&nbsp;&nbsp;&nbsp;
              <?php if ($distance) : ?>
                <?php echo esc_html($distance); ?> km.
              <?php endif; ?>
                </span>
            </div>
          </div>

      </div>
    <?php endwhile;
    wp_reset_postdata();
  endif;

  return ob_get_clean();
}

add_shortcode('etape_teaser', 'etape_teaser_shortcode');

add_filter('mce_buttons', function ($buttons) {
  $buttons[] = 'etape_teaser_button';
  return $buttons;
});

add_filter('mce_external_plugins', function ($plugins) {
  $plugins['etape_teaser'] = get_template_directory_uri() . '/assets/js/tinymce-etape.js';
  return $plugins;
});

add_filter('single_template', function ($template) {
  if (is_singular('article')) {
    $use_tema_template = function_exists('get_field')
      ? get_field('use_tema_template', get_the_ID())
      : false;

    if ($use_tema_template) {

      $new_template = locate_template('single-tema.php');

      if (!empty($new_template)) {
        return $new_template;
      }
    }
  }

  return $template;
});

add_action('admin_enqueue_scripts', function ($hook) {
  // Adjust this if needed, but this is usually enough for editor screens
  wp_register_script(
    'tinymce-etape-data',
    get_template_directory_uri() . '/assets/js/tinymce-etape-data.js',
    [],
    null,
    true
  );

  $etaper_posts = get_posts([
    'post_type'      => 'etape',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'title',
    'order'          => 'ASC',
  ]);

  $etaper = array_map(function ($post) {
    $nummer = get_field('etapenummer', $post->ID);

    if (!$nummer) {
      return null; // skip if missing
    }

    return [
      'text'  => html_entity_decode(get_the_title($post->ID)),
      'value' => $nummer,
    ];
  }, $etaper_posts);

// remove null values
  $etaper = array_values(array_filter($etaper));

  wp_localize_script('tinymce-etape-data', 'EtapeTeaserData', [
    'etaper' => $etaper,
  ]);

  wp_enqueue_script('tinymce-etape-data');
});

/**
 * Henter ACF-blokdata fra en anden side/posts indhold.
 * Bruges af history-boxes, nature-boxes og arrangement-boxes.
 * Ligger her (og ikke i blok-filerne), så den er defineret,
 * FØR blokkene renderes – jf. fatal error på /article/-sider.
 */
if (!function_exists('mtm_get_acf_block_data_from_post')) {
  function mtm_get_acf_block_data_from_post($post_id, $block_name)
  {
    $content = get_post_field('post_content', $post_id);
    $blocks  = parse_blocks($content);

    foreach ($blocks as $block) {
      if (($block['blockName'] ?? '') === $block_name) {
        return $block['attrs']['data'] ?? [];
      }
    }

    return [];
  }
}
