
$('.search-results .list-group a').click(function(e) {
    e.preventDefault();

    var el = $(this);

    var url = el.data('url');
    var description = el.data('description');
    var title = el.data('title');

    $('#result-title').text(title);
    $('#result-url').attr('href', url).text(url);
    $('#result-description').text(title);
    $('#result-iframe').attr('src', url);

    $('.search-results .list-group a').removeClass('active');
    el.addClass('active');
});