<!DOCTYPE html>
<html lang="ru-ru" dir="ltr">
<!-- (c) студия Wezom | www.wezom.com.ua -->
<head>
    <?php echo Core\Widgets::get('Head', $_seo); ?>
    <?php foreach ( $_seo['scripts']['head'] as $script ): ?>
        <?php echo $script; ?>
    <?php endforeach ?>
    <?php echo $GLOBAL_MESSAGE; ?>
</head>
<body>
    <?php foreach ( $_seo['scripts']['body'] as $script ): ?>
        <?php echo $script; ?>
    <?php endforeach ?>
    <div class="seoTxt" id="seoTxt">
        <div class="wSize wTxt">
            <?php echo $_content; ?>
        </div>
    </div>
    <div class="wWrapper">
        <?php echo Core\Widgets::get('Header', array('config' => $_config)); ?>
        <div class="wConteiner">
            <div class="wSize">
                <?php echo Core\Widgets::get('Index_Slider'); ?>
                <?php echo Core\Widgets::get('Index_Banners'); ?>
                <?php echo Core\Widgets::get('Index_ItemsNew'); ?>
                <?php echo Core\Widgets::get('VK'); ?>
                <?php echo Core\Widgets::get('News'); ?>
                <?php echo Core\Widgets::get('Articles'); ?>
                <div class="clear"></div>
                <?php echo Core\Widgets::get('Index_ItemsPopular'); ?>
                <div id="clonSeo"></div>
            </div>
        </div>
    </div>
    <?php echo Core\Widgets::get('HiddenData'); ?>
    <?php echo Core\Widgets::get('Footer', array('counters' => Core\Arr::get($_seo, 'counters'), 'config' => $_config)); ?>
</body>
</html>