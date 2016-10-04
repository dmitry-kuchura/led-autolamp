var closePopup = function (it) {
    it.fadeOut(650);
    setTimeout(function () {
        it.remove();
    }, 700);
};
var generate = function (message, type, time) {
    var mainBlock = $('#fPopUp');
    var current;
    if (!mainBlock.length) {
        $('<div id="fPopUp"></div>').appendTo('body');
        mainBlock = $('#fPopUp');
    }
    var i = 1;
    var count = 0;
    mainBlock.find('.content').each(function () {
        current = parseInt($(this).data('i'));
        if (current + 1 > i) {
            i = current + 1;
        }
        count++;
    });
    if (count >= 5) {
        mainBlock.find('div.content:first-child').remove();
    }
    $('<div class="content ' + type + '" data-i="' + i + '" style="display: none;">' + message + '</div>').appendTo(mainBlock);
    mainBlock.find('div.content[data-i="' + i + '"]').fadeIn(200);
    if (time) {
        setTimeout(function () {
            closePopup(mainBlock.find('div.content[data-i="' + i + '"]'));
        }, time);
    }
};

$(function () {
    $('body').on('click', '#fPopUp div.content', function () {
        closePopup($(this));
    });

    if ($('ul.color_c').length) {
        $('ul.color_c input').each(function () {
            if ($(this).prop('disabled')) {
                $(this).closest('li').css('opacity', '0.2');
                $(this).closest('li').find('ins').css('border', '0');
                $(this).css('cursor', 'auto');
            }
        });
        $('ul.color_c a').on('click', function () {
            window.location.href = $(this).attr('href');
        });
    }
});
