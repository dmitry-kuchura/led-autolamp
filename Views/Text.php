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
    <?php if (trim(strip_tags(Core\Arr::get($_seo, 'seo_text')))): ?>
        <div class="seoTxt" id="seoTxt">
            <div class="wSize wTxt">
                <?php echo Core\Arr::get($_seo, 'seo_text'); ?>
            </div>
        </div>
    <?php endif ?>
    <div class="wWrapper">
        <?php echo Core\Widgets::get('Header', array('config' => $_config)); ?>
        <div class="wConteiner">
            <div class="wSize">
                <?php echo $_breadcrumbs; ?>
                <div class="<?php echo Core\Config::get('content_class'); ?>">
                    <h1 class="title"><?php echo Core\Arr::get($_seo, 'h1'); ?></h1>
                    <?php echo $_content; ?>
                </div>
                <div id="clonSeo"></div>
            </div>
        </div>
    </div>
    <?php echo Core\Widgets::get('HiddenData'); ?>
    <?php echo Core\Widgets::get('Footer', array('counters' => Core\Arr::get($_seo, 'counters'), 'config' => $_config)); ?>
</body>
</html>