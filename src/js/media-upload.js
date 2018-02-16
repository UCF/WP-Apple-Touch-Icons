/* global wp */

const iconMediaUpload = ($) => {
  let uploadFrame;

  const $metaBox  = $('#wp_ati_page_icon_metabox');
  const $addLink  = $metaBox.find('.icon-upload');
  const $delLink  = $metaBox.find('.icon-remove');
  const $input    = $metaBox.find('#wp_ati_icon');
  const $filename = $metaBox.find('#icon-filename');
  const $preview  = $metaBox.find('.icon-preview');

  const upload = (e) => {
    e.preventDefault();

    if (uploadFrame) {
      uploadFrame.open();
      return;
    }

    uploadFrame = wp.media({
      title: 'Select the default apple-touch-icon for this page.',
      button: {
        text: 'Select Image'
      },
      multiple: false
    });

    uploadFrame.on('select', () => {
      const attachment = uploadFrame.state().get('selection').first().toJSON();
      $preview.removeClass('hidden');
      $input.val(attachment.id);
      $filename.text(attachment.filename);
      $addLink.addClass('hidden');
      $delLink.removeClass('hidden');
    });

    uploadFrame.open();
  };

  const removeMedia = (e) => {
    e.preventDefault();

    $preview.addClass('hidden');
    $addLink.removeClass('hidden');
    $delLink.addClass('hidden');
    $input.val('');
    $filename.text('');
  };

  $addLink.on('click', upload);
  $delLink.on('click', removeMedia);
};

if (typeof jQuery !== 'undefined') {
  jQuery(document).ready(($) => {
    iconMediaUpload($);
  });
}
