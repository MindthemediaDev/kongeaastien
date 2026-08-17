(function () {
  tinymce.PluginManager.add('etape_teaser', function (editor) {
    editor.addButton('etape_teaser_button', {
      text: 'Etapeteaser',
      icon: false,
      onclick: function () {
        var etapeOptions = (window.EtapeTeaserData && window.EtapeTeaserData.etaper) || [];

        editor.windowManager.open({
          title: 'Indsæt Etapeteaser',
          body: [
            {
              type: 'listbox',
              name: 'etape_id',
              label: 'Vælg etape',
              values: etapeOptions
            }
          ],
          onsubmit: function (e) {
            if (!e.data.etape_id) {
              return;
            }

            editor.insertContent('[etape_teaser nummer="' + e.data.etape_id + '"]');
          }
        });
      }
    });
  });
})();
