let currentPage = 1;
jQuery('.mike-load-more-button').on('click', function() {
    currentPage++;

    let postTypes = jQuery(this).attr('data-post-types');
    let perPage = jQuery(this).attr('data-per-page');

    jQuery.ajax({
        type: 'POST',
        url: '/wp-json/mike_cpt/v1/paginate',
        dataType: 'json',
        data: {
            paged: currentPage,
            post_types: postTypes,
            posts_per_page: perPage,
        },
        success: function (res) {
            jQuery.each(res.data, function (i, value) {
                if (jQuery('.mike-grid-container').length){
                    jQuery(this).append(value.html);
                } else {
                    jQuery('.mike-list').append(value.html);
                }
            });
        },
        error: function () {
            jQuery('.mike-load-more-error').css('display', 'block');
            jQuery('.mike-load-more-button').hide();
        }
    });
});