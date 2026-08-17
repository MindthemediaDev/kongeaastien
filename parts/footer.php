
</div>
<?php
// If using a global block in the footer
$footer_content = ' <!-- wp:acf/footer-block /--> '; // placeholder for your block
echo do_blocks( $footer_content );
?>


<footer class="py-3">
  <div class="container mx-auto">

    <div class="flex text-[13px] sm:justify-center">
      <ul class="flex w-full flex-col flex-wrap text-neutral-50 sm:flex-row sm:justify-center sm:space-x-8 ml-4">
        <li>
          <label class="inline-flex items-center gap-2 cursor-pointer select-none py-2">
            <span class="flex h-6 w-8 items-center justify-center text-white">
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" data-icon="sign-language" data-prefix="fas" viewBox="0 0 448 512" class="mr-1 h-6 w-6"><path fill="currentColor" d="M91.434 483.987c-.307-16.018 13.109-29.129 29.13-29.129h62.293v-5.714H56.993c-16.021 0-29.437-13.111-29.13-29.129C28.16 404.491 40.835 392 56.428 392h126.429v-5.714H29.136c-16.021 0-29.437-13.111-29.13-29.129.297-15.522 12.973-28.013 28.566-28.013h154.286v-5.714H57.707c-16.021 0-29.437-13.111-29.13-29.129.297-15.522 12.973-28.013 28.566-28.013h168.566l-31.085-22.606c-12.762-9.281-15.583-27.149-6.302-39.912 9.281-12.761 27.15-15.582 39.912-6.302l123.361 89.715a34.287 34.287 0 0 1 14.12 27.728v141.136c0 15.91-10.946 29.73-26.433 33.374l-80.471 18.934a137.16 137.16 0 0 1-31.411 3.646H120c-15.593-.001-28.269-12.492-28.566-28.014m73.249-225.701h36.423l-11.187-8.136c-18.579-13.511-20.313-40.887-3.17-56.536l-13.004-16.7c-9.843-12.641-28.43-15.171-40.88-5.088-12.065 9.771-14.133 27.447-4.553 39.75zm283.298-2.103-5.003-152.452c-.518-15.771-13.722-28.136-29.493-27.619-15.773.518-28.137 13.722-27.619 29.493l1.262 38.415L283.565 11.019c-9.58-12.303-27.223-14.63-39.653-5.328-12.827 9.599-14.929 28.24-5.086 40.881l76.889 98.745-4.509 3.511-94.79-121.734c-9.58-12.303-27.223-14.63-39.653-5.328-12.827 9.599-14.929 28.24-5.086 40.881l94.443 121.288-4.509 3.511-77.675-99.754c-9.58-12.303-27.223-14.63-39.653-5.328-12.827 9.599-14.929 28.24-5.086 40.881l52.053 66.849c12.497-8.257 29.055-8.285 41.69.904l123.36 89.714c10.904 7.93 17.415 20.715 17.415 34.198v16.999l61.064-47.549a34.285 34.285 0 0 0 13.202-28.177"></path></svg>
            </span>

            <span class="text-white text-sm font-normal leading-none">
              Adgang med tegn
            </span>

            <input
              id="sign-toggle"
              type="checkbox"
              class="sr-only peer"
              role="switch"
              aria-label="Adgang med tegn"
              aria-checked="false"
            >

            <span class="relative h-6 w-[50px] rounded-full border-2 border-white/80 bg-transparent transition
              after:content-[''] after:absolute after:left-1 after:top-1 after:h-3 after:w-3 after:rounded-full after:bg-white after:transition-transform after:duration-200
              peer-checked:after:translate-x-6">
            </span>
          </label>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const toggle = document.getElementById('sign-toggle');

              toggle.addEventListener('change', function () {
                if (typeof SignLanguageMark === 'function') {
                  SignLanguageMark(null, '#BCD463');
                }
              });
            });
          </script>
        </li>
        <li>
          <a class="flex w-full items-center whitespace-nowrap py-2" target="_blank" href="https://was.digst.dk/kongeaastien-dk">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" data-icon="file-alt" data-prefix="far" viewBox="0 0 384 512" class="mr-2 h-6 w-6"><path fill="currentColor" d="M288 248v28c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-28c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12m-12 72H108c-6.6 0-12 5.4-12 12v28c0 6.6 5.4 12 12 12h168c6.6 0 12-5.4 12-12v-28c0-6.6-5.4-12-12-12m108-188.1V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V48C0 21.5 21.5 0 48 0h204.1C264.8 0 277 5.1 286 14.1L369.9 98c9 8.9 14.1 21.2 14.1 33.9m-128-80V128h76.1zM336 464V176H232c-13.3 0-24-10.7-24-24V48H48v416z"></path></svg>
            <span>Tilgængelighedserklæring</span>
          </a>
        </li>
        <li>
          <a target="_blank" class="flex w-full items-center whitespace-nowrap py-2" href="/sitemap.xml">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" data-icon="sitemap" data-prefix="fas" viewBox="0 0 640 512" class="mr-2 h-6 w-6"><path fill="currentColor" d="M128 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32m-24-80h192v48h48v-48h192v48h48v-57.59c0-21.17-17.23-38.41-38.41-38.41H344v-64h40c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32H256c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h40v64H94.41C73.23 224 56 241.23 56 262.41V320h48zm264 80h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32m240 0h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32"></path></svg>
            <span>Sitemap</span>
          </a>
        </li>
        <li>
          <a class="flex w-full items-center whitespace-nowrap py-2" href="/privatlivspolitik">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" data-icon="file-powerpoint" data-prefix="far" viewBox="0 0 384 512" class="mr-2 h-6 w-6"><path fill="currentColor" d="M369.9 97.9 286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M332.1 128H256V51.9zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288zm72-60V236c0-6.6 5.4-12 12-12h69.2c36.7 0 62.8 27 62.8 66.3 0 74.3-68.7 66.5-95.5 66.5V404c0 6.6-5.4 12-12 12H132c-6.6 0-12-5.4-12-12m48.5-87.4h23c7.9 0 13.9-2.4 18.1-7.2 8.5-9.8 8.4-28.5.1-37.8-4.1-4.6-9.9-7-17.4-7h-23.9v52z"></path></svg>
            <span>Privatlivspolitik</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</footer>



<?php wp_footer(); ?>
<script>
  document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
  });
</script>
<script type="text/javascript">
  (function() {
    var lwfile = 'https://cdhsign.dk/cdh_player.js';
    var lw = document.createElement('script');
    lw.type = 'text/javascript';
    lw.async = true;
    lw.src = lwfile;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(lw, s);
  })
  ();
</script>

</body>
</html>
