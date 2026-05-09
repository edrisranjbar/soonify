jQuery(document).ready(function($){
    // Initialize color picker
    $('.soonify-color-picker').wpColorPicker();

    // Toggle background fields
    $('input[name="soonify_bg_type"]').change(function(){
        if($(this).val() === 'color'){
            $('.soonify-bg-color-field').show();
            $('.soonify-bg-image-field').hide();
        } else {
            $('.soonify-bg-color-field').hide();
            $('.soonify-bg-image-field').show();
        }
    });

    // Trigger on load
    $('input[name="soonify_bg_type"]:checked').trigger('change');

    // Media uploader
    $('.soonify-upload-btn').click(function(e){
        e.preventDefault();
        var target = $(this).data('target');
        var frame = wp.media({
            title: 'Select or Upload Image',
            button: { text: 'Use this image' },
            multiple: false,
            library: { type: 'image' }
        });
        frame.on('select', function(){
            var attachment = frame.state().get('selection').first().toJSON();
            $('#' + target).val(attachment.id);
            $('#' + target + '_preview').html('<img src="' + attachment.url + '" style="max-width:200px;">');
            $('#' + target).siblings('.soonify-remove-btn').show();
        });
        frame.open();
    });

    $('.soonify-remove-btn').click(function(e){
        e.preventDefault();
        var target = $(this).data('target');
        $('#' + target).val('');
        $('#' + target + '_preview').html('');
        $(this).hide();
    });

    // Load existing images
    function loadImagePreview(target){
        var id = $('#' + target).val();
        if(id){
            wp.media.attachment(id).fetch().then(function(attachment){
                $('#' + target + '_preview').html('<img src="' + attachment.url + '" style="max-width:200px;">');
                $('#' + target).siblings('.soonify-remove-btn').show();
            });
        }
    }

    loadImagePreview('soonify_bg_image');
    loadImagePreview('soonify_logo_image');
});