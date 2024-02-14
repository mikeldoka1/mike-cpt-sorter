jQuery(function($) {
    const $searchBox = $('.mike-search-box');
    const $searchText = $('.mike-search-text');
    const $searchSubmit = $('.mike-search-submit');
    const $loadMoreButton = $('.mike-load-more-button');
    const $gridContainer = $('.mike-grid-container');
    const $list = $('.mike-list');
    const $loadMoreError = $('.mike-load-more-error');
    let currentPage = 1;

    $searchBox.on('submit', function(e) {
        e.preventDefault();
        const searchQuery = $searchText.val();
        const postTypes = $searchSubmit.data('post-types');
        const perPage = $searchSubmit.data('per-page');
        mikeLoadPosts(postTypes, perPage, 1, searchQuery, true);
    });

    $loadMoreButton.on('click', function() {
        currentPage++;
        const postTypes = $searchSubmit.data('post-types');
        const perPage = $searchSubmit.data('per-page');
        const searchQuery = $searchText.val();
        mikeLoadPosts(postTypes, perPage, currentPage, searchQuery);
    });

    function mikeLoadPosts(postTypes, perPage, paged = 1, searchQuery = null, isSearch = false) {
        $.ajax({
            type: 'POST',
            url: '/wp-json/mike_cpt/v1/paginate',
            dataType: 'json',
            data: {
                s: searchQuery,
                paged: paged,
                post_types: postTypes,
                posts_per_page: perPage,
            },
            success: function(res) {
                const htmlItems = res.data.map(value => value.html);
                $loadMoreError.css('display', 'none');
                if (res.data.length === parseInt(perPage)) {
                    $loadMoreButton.show();
                } else {
                    $loadMoreButton.hide();
                }
                if (isSearch) {
                    $gridContainer.html(htmlItems);
                    $list.html(htmlItems);
                } else {
                    $gridContainer.append(htmlItems);
                    $list.append(htmlItems);
                }
            },
            error: function() {
                $loadMoreError.css('display', 'block');
                $loadMoreButton.hide();
            }
        });
    }
});