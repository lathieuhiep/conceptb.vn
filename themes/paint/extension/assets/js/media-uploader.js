jQuery(document).ready(function($) {
    $(document).on('click', '.media-uploader-button', function(e) {
        e.preventDefault();
        const button = $(this);
        const wrapper = button.closest('.media-uploader-wrapper');
        const custom_uploader = wp.media({
            title: button.data('uploader_title'),
            button: {
                text: button.data('uploader_button_text')
            },
            multiple: false
        });

        custom_uploader.on('select', function() {
            const attachment = custom_uploader.state().get('selection').first().toJSON();
            wrapper.find('.media-uploader-preview').attr('src', attachment.url).show();
            wrapper.find('.media-uploader-url').val(attachment.url).trigger('change');
            wrapper.find('.media-uploader-id').val(attachment.id).trigger('change');
            wrapper.find('.media-uploader-remove').show();
            button.text('Sửa ảnh');  // Change button text to "Edit Image"
        });

        custom_uploader.open();
    });

    $(document).on('click', '.media-uploader-remove', function(e) {
        e.preventDefault();
        const wrapper = $(this).closest('.media-uploader-wrapper');
        wrapper.find('.media-uploader-preview').hide();
        wrapper.find('.media-uploader-url').val('').trigger('change');
        wrapper.find('.media-uploader-id').val('').trigger('change');
        wrapper.find('.media-uploader-remove').hide();
        wrapper.find('.media-uploader-button').text('Thêm ảnh');  // Change button text back to "Add Image"
    });
});