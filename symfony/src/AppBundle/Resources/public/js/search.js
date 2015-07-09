
var supportHistory = false;
if (history.pushState) {
    supportHistory = true;
}
var pageCounter = -1;
var oPageInfo = {
    'title': document.title,
    'url': location.href
};

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

    if(supportHistory) {
        oPageInfo.title = document.title;
        oPageInfo.url = el.attr('href');
        history.pushState(oPageInfo, oPageInfo.title, oPageInfo.url);

        if(pageCounter == -1) {
            pageCounter = 1;
        }
        else {
            pageCounter++;
        }
    }
});

if(supportHistory) {
    window.onpopstate = function(event) {
        var link = $.url('?link');
        if(link) {
            link = decodeURIComponent(link);
            $('.search-results .list-group a[data-url="' + link + '"]').click();
        }
        else {
            $('.search-results .list-group a').first().click();
        }
    };
}
