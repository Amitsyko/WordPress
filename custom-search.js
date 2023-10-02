jQuery(document).ready(function ($) {
    var searchField = $('#s');
    var suggestions = $('#search-suggestions');

    searchField.on('input', function () {
        var searchTerm = $(this).val();

        // Make an AJAX request to fetch search suggestions
        $.ajax({
            url: custom_search_vars.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_search_suggestions',
                term: searchTerm,
            },
            success: function (response) {
                suggestions.html(response);
            },
        });
    });
});
