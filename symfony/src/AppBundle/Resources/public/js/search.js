
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
    var favoriteEl = el.find('.favorite');

    var url = el.data('url');
    var description = el.data('description');
    var title = el.data('title');

    var unMarkUrl = favoriteEl.data('un-mark');
    var markUrl = favoriteEl.data('mark');

    $('#result-title').text(title);
    $('#result-url').attr('href', url).text(url);
    $('#result-description').text(title);
    $('#result-iframe').attr('src', url);

    var unMarkFavoriteEl = $('#un-mark-favorite');
    var markFavoriteEl = $('#mark-favorite');
    unMarkFavoriteEl.attr('href', unMarkUrl);
    markFavoriteEl.attr('href', markUrl);

    if(favoriteEl.hasClass('hide')) {
        markFavoriteEl.removeClass('hide');
        unMarkFavoriteEl.addClass('hide');
    }
    else {
        markFavoriteEl.addClass('hide');
        unMarkFavoriteEl.removeClass('hide');
    }

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

$('#un-mark-favorite').click(function(e) {
    e.preventDefault();

    var el = $(this);
    var url = el.attr('href');
    $.get(url, function() {
        $('#un-mark-favorite').addClass('hide');
        $('#mark-favorite').removeClass('hide');

        $('.search-results .list-group a.active .favorite').addClass('hide');
    });
});

$('#mark-favorite').click(function(e) {
    e.preventDefault();

    var el = $(this);
    var url = el.attr('href');
    $.get(url, function() {
        $('#un-mark-favorite').removeClass('hide');
        $('#mark-favorite').addClass('hide');

        $('.search-results .list-group a.active .favorite').removeClass('hide');
    });
});
