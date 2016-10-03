<!DOCTYPE html>
<html lang="ru-RU" dir="ltr" class="no-js">
<head>
    <?php echo Core\Widgets::get('Error_Head', $_seo); ?>
</head>
<body class="errorPage">
<div class="errorWrapper">
    <div class="errorHolder">
        <div class="errorContent">
            <div class="errorHeader">404</div>
            <div class="wTxt">
                <h3>Страница не найдена</h3>
                <p>
                    <em>К сожалению, страница, которую Вы запросили, не была найдена.</em>
                    <br>
                    Вы можете перейти на <a href="<?php echo Core\HTML::link(); ?>">главную страницу</a>
                </p>
            </div>
        </div>
    </div>
</div>
    <?php echo Core\Widgets::get('Error_Footer'); ?>
</body>
</html>