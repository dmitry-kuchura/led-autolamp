<?php use Core\Config; ?>
<header class="wHeader">
    <div class="wSize">
        <div class="logo_block w_fll">
            <span data-anchor="top" class="logo js-anchor">
                <img src="<?php echo Core\HTML::media('pic/logo.png'); ?>" alt="">
            </span>
        </div>
        <div class="phone_graf_top w_flr">
            <a href="tel:380990902856?call" class="phone_top">
                <svg>
                    <use xlink:href="#icon_phone"/>
                </svg>
                <span><?php echo Config::get('static.phone_1') ?></span>
            </a>
            <?php if (Config::get('static.phone_2')): ?>
                <a href="tel:380990902856?call" class="phone_top">
                    <svg>
                        <use xlink:href="#icon_phone"/>
                    </svg>
                    <span><?php echo Config::get('static.phone_2') ?></span>
                </a>
            <?php endif; ?>
            <span class="graf_top">
                <svg>
                    <use xlink:href="#icon_clock"/>
                </svg>
                <div class="graf_info">
                    <span><?php echo Config::get('static.week') ?></span>
                    <span><?php echo Config::get('static.weekend') ?></span>
                </div>
            </span>
        </div>
        <div class="menu w_ovh">
            <span data-anchor="advantages" class="js-anchor">Преимущества</span>
            <span data-anchor="compare" class="js-anchor">Сравнение</span>
            <span data-anchor="reviews" class="js-anchor">Отзывы</span>
            <span data-anchor="buy" class="js-anchor">Покупайте у нас</span>
        </div>
    </div>
</header>