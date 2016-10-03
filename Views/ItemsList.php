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
            <?php echo trim(strip_tags(Core\Config::get('seo_text'))) ? Core\Config::get('seo_text') : ''; ?>
        </div>
    </div>
    <div class="wWrapper">
        <?php echo Core\Widgets::get('Header'); ?>
        <div class="wConteiner">
            <div class="wSize">
                <?php echo $_breadcrumbs; ?>
                <div class="folt_cat_block clearFix">
                    <div class="fll">
                        <?php echo Core\Widgets::get('CatalogFilter'); ?>
                    </div>
                    <div class="flr">
                        <div class="title"><?php echo Core\Config::get('h1'); ?></div>
                        <?php echo Core\Widgets::get('CatalogSort'); ?>
                        <?php echo $_content; ?>
                    </div>
                </div>
                <?php echo Core\Widgets::get('ItemsViewed'); ?>
                <div id="clonSeo"></div>
            </div>
        </div>
    </div>
    <?php echo Core\Widgets::get('HiddenData'); ?>
    <?php echo Core\Widgets::get('Footer', array('counters' => Core\Arr::get($_seo, 'counters'), 'config' => $_config)); ?>
</body>
</html>