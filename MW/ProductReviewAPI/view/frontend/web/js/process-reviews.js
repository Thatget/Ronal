/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery'
], function ($) {
    'use strict';

    /**
     * @param {String} url
     * @param {*} fromPages
     */
    function processReviews(url, fromPages) {

        var search_keyword = $('#search_review_keyword').val();
        var search_review_sort = $('#search_review_sort').val();
        var search_review_filter = $('#search_review_filter').val();

        $.ajax({
            url: url,
            cache: true,
            dataType: 'html',
            showLoader: false,
            loaderContext: $('.product.data.items'),
            data: {key: search_keyword, sort_by: search_review_sort, filter: search_review_filter}
        }).done(function (data) {
            if(data.trim() != "") {
                $('#product-review-container').html(data.trim());
            }
        }).complete(function () {
            if (fromPages == true) { //eslint-disable-line eqeqeq
                $('html, body').animate({
                    scrollTop: $('#reviews').offset().top - 50
                }, 300);
            }
        });
    }

    return function (config) {
        var productReviewSearchUrl = config.productReviewSearchUrl,
            requiredReviewTabRole = 'tab';

        // if (reviewTab.attr('role') === requiredReviewTabRole && reviewTab.hasClass('active')) {
        //     processReviews(productReviewSearchUrl);
        // } else {
        //     reviewTab.one('beforeOpen', function () {
        //         processReviews(productReviewSearchUrl);
        //     });
        // }

        console.log(config);
        $("#search_review").on('click', function () {
            var search_keyword = $('#search_review_keyword').val();
            processReviews(productReviewSearchUrl);
        });
    };
});
