// jQuery(function ($) {
//     $(document).on('click', '.pagination a', function (e) {
//         e.preventDefault();

//         var page = $(this).data('page');

//         $.ajax({
//             url: ajaxpagination.ajaxurl,
//             type: 'post',
//             data: {
//                 action: 'ajax_pagination',
//                 query_vars: ajaxpagination.query_vars,
//                 page: page,
//             },
//             success: function (response) {
//             console.log('AJAX Response:', response);
//             // Update your content with the new paginated data
//             $('.main .one').html(response);
//             // Update the URL with the new page number
//             history.pushState(null, null, '?paged=' + page);
// },

//         });
//     });
// });
