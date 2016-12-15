/*init.js*/
/*
    init.js v2.0
    Wezom wTPL v4.0.0
*/
window.wHTML = (function($){

    /* Приватные переменные */

        var varSeoIframe = 'seoIframe',
            varSeoTxt = 'seoTxt',
            varSeoClone = 'cloneSeo',
            varSeoDelay = 200;

    /* Приватные функции */

        /* проверка типа данных на объект */
        var _isObject = function(data) {
            var flag = (typeof data == 'object') && (data+'' != 'null');
            return flag;
        },

        /* создание нового элемента элемента */
        _crtEl = function(tag, classes, attrs, jq) {
            var tagName = tag || 'div';
            var element = document.createElement(tagName);
            var jQueryElement = jq || true;
            // если классы объявлены - добавляем
            if (classes) {
                var tagClasses = classes.split(' ');
                for (var i = 0; i < tagClasses.length; i++) {
                    element.classList.add(tagClasses[i]);
                }
            }
            // если атрибуты объявлены - добавляем
            if (_isObject(attrs)) {
                for (var key in attrs) {
                    var val = attrs[key];
                    element[key] = val;
                }
            }
            // возвращаем созданый елемент
            if (jQueryElement) {
                return $(element);
            } else {
                return element;
            }
        },

        /* создаем iframe для сео текста */
        _seoBuild = function(wrapper) {
            var seoTimer;
            // создаем iframe, который будет следить за resize'm окна
            var iframe = _crtEl('iframe', false, {id: varSeoIframe, name: varSeoIframe});
            iframe.css({
                'position':'absolute',
                'left':'0',
                'top':'0',
                'width':'100%',
                'height':'100%',
                'z-index':'-1'
            });
            // добавляем его в родитель сео текста
            wrapper.prepend(iframe);
            // "прослушка" ресайза
            seoIframe.onresize = function() {
                clearTimeout(seoTimer);
                seoTimer = setTimeout(function() {
                    wHTML.seoSet();
                }, varSeoDelay);
            };
            // вызываем seoSet()
            wHTML.seoSet();
        };

    /* Публичные методы */

        function Methods(){}

        Methods.prototype = {

            /* установка cео текста на странице */
            seoSet: function() {
                if ($('#'+varSeoTxt).length) {
                    var seoText = $('#'+varSeoTxt);
                    var iframe = seoText.children('#'+varSeoIframe);
                    if (iframe.length) {
                        // если iframe сущствует устанавливаем на место сео текст
                        var seoClone = $('#'+varSeoClone);
                        if (seoClone.length) {
                            // клонеру задаем высоту
                            seoClone.height(seoText.outerHeight(true));
                            // тексту задаем позицию
                            seoText.css({
                                top: seoClone.offset().top
                            });
                        } else {
                            // клонера нету - бьем в колокола !!!
                            console.error('"'+varSeoClone+'" - не найден!');
                        }
                    } else {
                        // если iframe отсутствует, создаем его и устанавливаем на место сео текст
                        _seoBuild(seoText);
                    }
                }
            },

            /* magnificPopup inline */
            mfi: function() {
                $('.mfi').magnificPopup({
                    type: 'inline',
                    closeBtnInside: true,
                    removalDelay: 300,
                    mainClass: 'zoom-in'
                });
            },

            /* magnificPopup ajax */
            mfiAjax: function() {
                $('body').magnificPopup({
                    delegate: '.mfiA',
                    callbacks: {
                        elementParse: function(item) {
                            this.st.ajax.settings = {
                                url: item.el.data('url'),
                                type: 'POST',
                                data: (typeof item.el.data('param') !== 'undefined') ? item.el.data('param') : ''
                            };
                        },
                        ajaxContentAdded: function(el) {
                            wHTML.validation();
                        }
                    },
                    type: 'ajax',
                    removalDelay: 300,
                    mainClass: 'zoom-in'
                });
            },

            /* оборачивание iframe и video для адаптации */
            wTxtIFRAME: function() {
                var list = $('.wTxt').find('iframe').add($('.wTxt').find('video'));
                if (list.length) {
                    // в цикле для каждого
                    for (var i = 0; i < list.length; i++) {
                        var element = list[i];
                        var jqElement = $(element);
                        // если имеет класс ignoreHolder, пропускаем
                        if (jqElement.hasClass('ignoreHolder')) {
                            continue;
                        }
                        if (typeof jqElement.data('wraped') === 'undefined') {
                            // определяем соотношение сторон
                            var ratio = parseFloat((+element.offsetHeight / +element.offsetWidth * 100).toFixed(2));
                            if (isNaN(ratio)) {
                                // страховка 16:9
                                ratio = 56.25;
                            }
                            // назнчаем дату и обрачиваем блоком
                            jqElement.data('wraped', true).wrap('<div class="iframeHolder ratio_' + ratio.toFixed(0) + '" style="padding-top:'+ratio+'%;""></div>');
                        }
                    }
                    // фиксим сео текст
                    this.seoSet();
                }
            }
        };

    /* Объявление wHTML и базовые свойства */

    var wHTML = $.extend(true, Methods.prototype, {});

    return wHTML;

})(jQuery);




jQuery(document).ready(function($) {

    // поддержка cssanimations
    transitFlag = Modernizr.cssanimations;

    // очитска localStorage
    localStorage.clear();

    // сео текст
    wHTML.seoSet();

    // magnificPopup inline
    wHTML.mfi();

    // magnificPopup ajax
    wHTML.mfiAjax();

    // валидация форм
    wHTML.validation();

    function anchor(item) {
        var anchor = item.data('anchor');
        var top = $('.js-'+anchor).offset().top;
        $('body, html').stop().animate({
            scrollTop: top - 90
        }, 500);
    }

    $(window).scroll(function() {
        ($(this).scrollTop() > 100) ? $('.wHeader').addClass('scroll') : $('.wHeader').removeClass('scroll');
        if($(window).width() < 540) {
            ($(this).scrollTop() > 50) ? $('.wHeaderFix').addClass('scroll') : $('.wHeaderFix').removeClass('scroll');
        }
        else {
            ($(this).scrollTop() > 50) ? $('.wHeaderFix').removeClass('scroll') : $('.wHeaderFix').removeClass('scroll');
        }
    });

    $('.js-anchor').on('click', function(){
        anchor($(this));
    });

    $('.js-couter input').on('focus', function(){
        $(this).val($(this).data('count'));
    }).on('blur', function(){
        if($(this).data('count') <= 1) {
            $(this).data('count',1);
        }
        $(this).val($(this).data('count') + ' шт');
    }).on('keyup', function(){
        $(this).data('count',$(this).val());
    });
    $('.spiner').on('click', function(){
        var counter = $(this).closest('.counter_block').find('.js-couter input');
        var count = $(this).closest('.counter_block').find('.js-couter input').data('count');
        if($(this).hasClass('js-plus')){
            count = count + 1;
            $(this).closest('.counter_block').find('.js-couter input').data('count', count);
            counter.val(count + ' шт');
        }
        if($(this).hasClass('js-minus') && count > 1){
            count = count - 1;
            $(this).closest('.counter_block').find('.js-couter input').data('count', count);
            counter.val(count + ' шт');
        }
    });

    $('.touch input, textarea').on('focus', function(){
        $('.wHeader, .wHeaderFix').hide(100);
    });
    $('.touch input, textarea').on('blur', function(){
        $('.wHeader, .wHeaderFix').show(100);
    });

    $(window).load(function() {
        // оборачивание iframe и video для адаптации
        wHTML.wTxtIFRAME();

        ($(this).scrollTop() > 100) ? $('.wHeader').addClass('scroll') : $('.wHeader').removeClass('scroll');

        if($(window).width() < 540) {
            ($(this).scrollTop() > 50) ? $('.wHeaderFix').addClass('scroll') : $('.wHeaderFix').removeClass('scroll');
        }
        else {
            ($(this).scrollTop() > 50) ? $('.wHeaderFix').removeClass('scroll') : $('.wHeaderFix').removeClass('scroll');
        }

        $('.js-inputmask').inputmask({"mask": "+38 (099) 99 99 999"});

        $('.js-select2').each(function() {
            $(this).select2({
                minimumResultsForSearch: -1,
                placeholder: ''
            }); 
        });

        var dateString = $('.js-timer').data('finish');
        if(Modernizr.safari) {
            dateString = dateString.replace(/-/g, '/');
        }

        var diff = new Date(dateString).getTime() - new Date().getTime();
        var showtime = Math.floor(diff/1000);

        var clock = $('.js-timer').FlipClock(new Date(dateString), {
            countdown: true,
            clockFace: 'DailyCounter',
            language: 'ru-ru'
        });
        clock.setTime(showtime);
        clock.start();

        $('.reviews_slider').find('ul').carouFredSel({
            responsive: true,
            auto: false,
            scroll: {
                items: 1,
                duration: 1000,
                timeoutDuration: 3000,
                fx: 'crossfade'
            },
            pagination: {
                container: $('.pagg')
            },
            swipe: true
        }, {
            transition: transitFlag
        });

    });

});
//# sourceMappingURL=maps/inits.js.map
