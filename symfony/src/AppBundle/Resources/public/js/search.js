var supportHistory = false;
if (history.pushState) {
    supportHistory = true;
}
var pageCounter = -1;
var oPageInfo = {
    'title': document.title,
    'url': location.href
};

var pageChanged = false;
$('.search-results .list-group a').click(function (e) {
    e.preventDefault();

    var el = $(this);
    var favoriteEl = el.find('.favorite');

    if (el.hasClass('active')) {
        return;
    }
    pageChanged = true;
    hideSpinnerForFavoriteChange();

    var url = el.attr('data-url');
    var description = el.attr('data-description');
    var title = el.attr('data-title');

    var unMarkUrl = favoriteEl.attr('data-un-mark');
    var markUrl = favoriteEl.attr('data-mark');

    $('#result-title').text(title);
    $('#result-url').attr('href', url).text(url);
    $('#result-description').text(title);
    $('#result-iframe').attr('src', url);
    $('#mark-favorite-login').attr('href', markUrl);

    var unMarkFavoriteEl = $('#un-mark-favorite');
    var markFavoriteEl = $('#mark-favorite');
    unMarkFavoriteEl.attr('href', unMarkUrl);
    markFavoriteEl.attr('href', markUrl);

    if (favoriteEl.hasClass('hide')) {
        markFavoriteEl.removeClass('hide');
        unMarkFavoriteEl.addClass('hide');
    }
    else {
        markFavoriteEl.addClass('hide');
        unMarkFavoriteEl.removeClass('hide');
    }

    $('.search-results .list-group a').removeClass('active');
    el.addClass('active');

    if (supportHistory) {
        oPageInfo.title = document.title;
        oPageInfo.url = el.attr('href');
        history.pushState(oPageInfo, oPageInfo.title, oPageInfo.url);

        if (pageCounter == -1) {
            pageCounter = 1;
        }
        else {
            pageCounter++;
        }
    }
});

if (supportHistory) {
    window.onpopstate = function (event) {
        var link = $.url('?link');
        if (link) {
            link = decodeURIComponent(link);
            $('.search-results .list-group a[data-url="' + link + '"]').click();
        }
        else {
            $('.search-results .list-group a').first().click();
        }
    };
}

$('#un-mark-favorite').click(function (e) {
    e.preventDefault();

    $('#un-mark-favorite').addClass('hide');
    showSpinnerForFavoriteChange();
    pageChanged = false;

    var el = $(this);
    var url = el.attr('href');
    $.get(url, function () {
        hideSpinnerForFavoriteChange();
        if (!pageChanged) {
            $('#mark-favorite').removeClass('hide');
        }
        pageChanged = false;

        $('.search-results .list-group a.active .favorite').addClass('hide');
    });
});

$('#mark-favorite').click(function (e) {
    e.preventDefault();

    $('#mark-favorite').addClass('hide');
    showSpinnerForFavoriteChange();
    pageChanged = false;

    var el = $(this);
    var url = el.attr('href');
    $.get(url, function () {
        hideSpinnerForFavoriteChange();
        if (!pageChanged) {
            $('#un-mark-favorite').removeClass('hide');
        }
        pageChanged = false;

        $('.search-results .list-group a.active .favorite').removeClass('hide');
    });
});

var spinnerForFavoriteChange = null;
function showSpinnerForFavoriteChange() {
    if (spinnerForFavoriteChange) {
        hideSpinnerForFavoriteChange();
    }

    var container = $('#change-favorite-spin-container');
    spinnerForFavoriteChange = new Spinner({
        'top': '16px',
        'left': '-20px',
        'position': 'relative'
    });
    spinnerForFavoriteChange.spin();
    container.append(spinnerForFavoriteChange.el);
}

function hideSpinnerForFavoriteChange() {
    if (spinnerForFavoriteChange) {
        spinnerForFavoriteChange.stop();
        spinnerForFavoriteChange = null;
    }

    var container = $('#change-favorite-spin-container');
    container.html('');
}

Ladda.bind('input[type=submit]');
Ladda.bind('button[type=submit]');
