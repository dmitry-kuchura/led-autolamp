<?php use Core\Config; ?>
<header class="wHeader">
	<!-- GA -->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-87147415-1', 'auto');
		ga('send', 'pageview');
	</script>
	<!-- /GA -->
	<!-- YM -->	
	<script type="text/javascript">
		(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40835434 = new Ya.Metrika({ id:40835434, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); 
	</script> 
	<noscript>
		<div>
			<img src="https://mc.yandex.ru/watch/40835434" style="position:absolute; left:-9999px;" alt="" />
		</div>
	</noscript>
	<!-- /YM -->
    <div class="wSize">
        <div class="logo_block w_fll">
            <span data-anchor="top" class="logo js-anchor">
                <img src="<?php echo Core\HTML::media('pic/logo.png'); ?>" alt="">
            </span>
        </div>
        <div class="phone_graf_top w_flr">
            <a href="tel:<?php echo preg_replace('/[^0-9]/', '', Config::get('static.phone_1')); ?>?call" class="phone_top">
                <svg>
                    <use xlink:href="#icon_phone"/>
                </svg>
                <span><?php echo Config::get('static.phone_1') ?></span>
            </a>
            <?php if (Config::get('static.phone_2')): ?>
                <a href="tel:<?php echo preg_replace('/[^0-9]/', '', Config::get('static.phone_2')); ?>?call" class="phone_top">
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