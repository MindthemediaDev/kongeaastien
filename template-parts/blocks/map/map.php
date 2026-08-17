<div class="container mx-auto map-wrapper mt-12 mb-12">
  <div id="map" class="w-full h-[500px]"></div>
</div>

<script>
  window.mapBounds = [
    100000, 5900000,  // minX, minY
    1000000, 6500000  // maxX, maxY
  ];
</script>

<?php

$args = [
  'post_type' => 'etape',
  'posts_per_page' => -1,
  'post_status' => 'publish',
];

$query = new WP_Query($args);

$gpx_files = [];

while ($query->have_posts()) {
  $query->the_post();
  //echo "<p>Post: " . get_the_title() . "</p>";

  // Get the raw post meta (attachment ID)
  $gpx_id = get_post_meta(get_the_ID(), 'gpx_file', true);
  $color = get_post_meta(get_the_ID(), 'rutefarve', true);
  $etape_start = get_post_meta(get_the_ID(), 'etapestart', true) ?: '';
  $etape_slut = get_post_meta(get_the_ID(), 'etapeslut', true) ?: '';
  $etapelaengde = get_post_meta(get_the_ID(), 'etapelaengde', true) ?: '';
  $etapenr = __('Etape', 'kongeaastien').' '.get_post_meta(get_the_ID(), 'etapenummer', true) ?: '';
  $etapenummer = get_post_meta(get_the_ID(), 'etapenummer', true) ?: '';
  $readmore = '<a href="'.get_permalink(get_the_ID()).'">'.__('Læs mere her', 'kongeaastien').'</a>';
  $rundtur = get_post_meta(get_the_ID(), 'rundtur', true) ?: '';

  if ($gpx_id) {
    // Convert attachment ID to URL
    $gpx_url = wp_get_attachment_url($gpx_id);
    //echo "GPX URL: " . $gpx_url . "<br>";
    if ($etape_slut == "") {
      $name = $etape_start . " (Rundtur)";
    } else {
      $name = $etape_start . " → " . $etape_slut;
    }
    $gpx_files[] = [
      'url'   => $gpx_url,
      'color' => $color ?: '#000000', // fallback color
      'name'  => $name,
      'laengde' => $etapelaengde,
      'etapenr' => $etapenr,
      'etapenummer' => $etapenummer,
      'readmore' => $readmore,
      'rundtur' => $rundtur,

    ];
  }
}
wp_reset_postdata();



$args = [
  'post_type' => 'kortelement',
  'posts_per_page' => -1,
  'post_status' => 'publish'
];

$query = new WP_Query($args);

$data = [];

while ($query->have_posts()) {
  $query->the_post();

  $post_id = get_the_ID(); // 👈 important

  $lat = get_field('latitude', $post_id);
  $lng = get_field('longitude', $post_id);

 // if (!is_numeric($lat) || !is_numeric($lng)) continue;

  $data[] = [
    'title' => get_field('titel', $post_id) ?: get_the_title(),
    'lat' => (float) $lat,
    'lng' => (float) $lng,
    'category' => get_field('category', $post_id),
    'image' => ''
  ];
}

wp_reset_postdata();


echo "<script>
  window.mapPoints = " . json_encode($data) . "
</script>";


echo "<script>window.etapeGpxFiles = " . json_encode($gpx_files) . ";</script>";

?>

<script>

</script>
