$(document).ready(function() {
    initAjax();
    initExternalLinks();
});

/**
 * Enables easy to implement Ajax data replace.
 */
function initAjax() {
    $(document).on('submit', 'form[data-ajax-replace]', function(event) {
        event.preventDefault();

        var form = $(this);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),

            success: function(data, status) {
                $('#' + form.attr('data-ajax-replace')).html(data);
            }
        });
    });
}

/**
 * Makes sure external links open in a new tab.
 */
function initExternalLinks() {
    var hostname = window.location.hostname;
    $('a').filter(function() { return hostname != this.hostname; } ).click(function () {
        $(this).attr('target', '_blank');
    });
}
