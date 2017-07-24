(function ($) {
    'use strict';

    $(document).ready(function () {
        $(".rt-tab-nav li:first-child a").trigger('click');
        if ($(".kcseo-date").length) {
            $('.kcseo-date').datepicker({
                'format': 'yyyy-mm-dd',
                'autoclose': true
            });
        }
    });

    showHideType();
    $("#site_type, #_schema_aggregate_rating_schema_type").change(function () {
        showHideType();
    });

    if ($("#kcseo-wordpres-seo-structured-data-schema-meta-box").length) {

        $("select.select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
    } else {
        $("select.select2").select2({
            dropdownAutoWidth: true
        });
    }


    $(document).on('click', ".social-remove", function () {
        if (confirm("Are you sure?")) {
            $(this).parent('.sfield').slideUp('slow', function () {
                $(this).remove();
            });
        }
    });

    $("#social-add").on('click', function () {
        var bindElement = $("#social-add");
        var count = $("#social-field-holder .sfield").length;
        var arg = 'id=' + count;
        AjaxCall(bindElement, 'newSocial', arg, function (data) {
            if (data.data) {
                $("#social-field-holder").append(data.data);
            }
        });
    });

    $('.schema-tooltip').each(function () { // Notice the .each() loop, discussed below
        $(this).qtip({
            content: {
                text: $(this).next('div') // Use the "div" element next to this for the content
            },
            hide: {
                fixed: true,
                delay: 300
            }
        });
    });

    $(".rt-tab-nav li").on('click', 'a', function (e) {
        e.preventDefault();
        var container = $(this).parents('.rt-tab-container');
        var nav = container.children('.rt-tab-nav');
        var content = container.children(".rt-tab-content");
        var $this, $id;
        $this = $(this);
        $id = $this.attr('href');
        content.hide();
        nav.find('li').removeClass('active');
        $this.parent().addClass('active');
        container.find($id).show();
    });

    $(".kSeoImgAdd").on("click", function (e) {
        var file_frame,
            $this = $(this).parents('.kSeo-image-wrapper');
        if (undefined !== file_frame) {
            file_frame.open();
            return;
        }
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload Media For your profile gallery',
            button: {
                text: 'Use this media'
            },
            multiple: false
        });
        file_frame.on('select', function () {
            var attachment = file_frame.state().get('selection').first().toJSON(),
                imgId = attachment.id,
                imgUrl = (typeof attachment.sizes.thumbnail === "undefined") ? attachment.url : attachment.sizes.thumbnail.url,
                imgInfo = "<span><strong>URL: </strong>" + attachment.sizes.full.url + "</span>",
                imgInfo = imgInfo + "<span><strong>Width: </strong>" + attachment.sizes.full.width + "px</span>",
                imgInfo = imgInfo + "<span><strong>Height: </strong>" + attachment.sizes.full.height + "px</span>";
            $this.find('input').val(imgId);
            $this.find('.kSeoImgRemove').removeClass('kSeo-hidden');
            $this.find('img').remove();
            $this.find('.kSeo-image-preview').append("<img src='" + imgUrl + "' />");
            $this.parents('.kSeo-image').find('.image-info').html(imgInfo);
        });
        // Now display the actual file_frame
        file_frame.open();
    });

    $(".kSeoImgRemove").on("click", function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var $this = $(this).parents('.kSeo-image-wrapper');
            $this.find('input').val('');
            $this.find('.kSeoImgRemove').addClass('kSeo-hidden');
            $this.find('img').remove();
            $this.parents('.kSeo-image').find('.image-info').html('');
        }
    });

})(jQuery);


function showHideType() {
    if(jQuery('#_schema_aggregate_rating_schema_type').length){
        var id = jQuery("#_schema_aggregate_rating_schema_type option:selected").val();
    }
    if(jQuery('#site_type').length){
        var id = jQuery("#site_type option:selected").val();
    }

    if (id == "Person") {
        jQuery(".form-table tr.person, .aggregate-person-holder").show();
    } else {
        jQuery(".form-table tr.person, .aggregate-person-holder").hide();
    }
    if (id == "Organization") {
        jQuery(".form-table tr.business-info,.form-table tr.all-type-data, .aggregate-except-organization-holder").hide();
    } else {
        jQuery(".form-table tr.business-info,.form-table tr.all-type-data, .aggregate-except-organization-holder").show();
    }
}
function wpSchemaSettings(e) {

    jQuery('#response').hide();
    arg = jQuery(e).serialize();
    bindElement = jQuery('#tlpSaveButton');
    AjaxCall(bindElement, 'kcSeoWpSchemaSettings', arg, function (data) {
        console.log(data);
        jQuery('#response').addClass('updated');
        if (!data.error) {
            jQuery('#response').removeClass('error');
            jQuery('#response').show('slow').text(data.msg);
        } else {
            jQuery('#response').addClass('error');
            jQuery('#response').show('slow').text(data.msg);
        }
    });

}

function AjaxCall(element, action, arg, handle) {
    if (action) data = "action=" + action;
    if (arg)    data = arg + "&action=" + action;
    if (arg && !action) data = arg;
    data = data;

    jQuery.ajax({
        type: "post",
        url: ajaxurl,
        data: data,
        beforeSend: function () {
            jQuery("<span class='wseo_loading'></span>").insertAfter(element);
        },
        success: function (data) {
            jQuery(".wseo_loading").remove();
            handle(data);
        }
    });
}
