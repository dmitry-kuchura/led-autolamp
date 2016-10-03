<?php
    // Settings of images on the site
    return array(
        // Watermark path
        'watermark' => 'pic/logo.png',
        // Image types
        'types' => array(
            'jpg', 'jpeg', 'png', 'gif',
        ),
        // Banners images
        'banners' => array(
            array(
                'path' => '',
                'width' => 483,
                'height' => 160,
                'resize' => 1,
                'crop' => 1,
            ),
        ),
        // Slider images
        'slider' => array(
            array(
                'path' => 'small',
                'width' => 200,
                'height' => 70,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'big',
                'width' => 1460,
                'height' => 500,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'original',
                'resize' => 0,
                'crop' => 0,
            ),
        ),
        // Blog images
        'blog' => array(
            array(
                'path' => 'small',
                'width' => 200,
                'height' => 160,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'big',
                'width' => 600,
                'height' => 400,
                'resize' => 1,
                'crop' => 0,
            ),
            array(
                'path' => 'original',
                'resize' => 0,
                'crop' => 0,
            ),
        ),
        // News images
        'news' => array(
            array(
                'path' => 'small',
                'width' => 200,
                'height' => 160,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'big',
                'width' => 600,
                'height' => NULL,
                'resize' => 1,
                'crop' => 0,
            ),
            array(
                'path' => 'original',
                'resize' => 0,
                'crop' => 0,
            ),
        ),
        // Articles images
        'articles' => array(
            array(
                'path' => 'small',
                'width' => 200,
                'height' => 160,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'big',
                'width' => 600,
                'height' => NULL,
                'resize' => 1,
                'crop' => 0,
            ),
            array(
                'path' => 'original',
                'resize' => 0,
                'crop' => 0,
            ),
        ),
        // Catalog groups images
        'catalog_tree' => array(
            array(
                'path' => '',
                'width' => 240,
                'height' => 240,
                'resize' => 1,
                'crop' => 1,
            ),
        ),
        // Products images
        'catalog' => array(
            array(
                'path' => 'small',
                'width' => 60,
                'height' => 60,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'medium',
                'width' => 232,
                'height' => 195,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'big',
                'width' => 678,
                'height' => 520,
                'resize' => 1,
                'crop' => 0,
            ),
            array(
                'path' => 'original',
                'resize' => 0,
                'crop' => 0,
            ),
        ),
        'gallery' => array(
            array(
                'path' => '',
                'width' => 200,
                'height' => 200,
                'resize' => 1,
                'crop' => 1,
            ),
        ),
        'gallery_images' => array(
            array(
                'path' => 'small',
                'width' => 200,
                'height' => 200,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'medium',
                'width' => 350,
                'height' => 350,
                'resize' => 1,
                'crop' => 1,
            ),
            array(
                'path' => 'big',
                'width' => 1280,
                'height' => 1024,
                'resize' => 1,
                'crop' => 0,
            ),
            array(
                'path' => 'original',
                'resize' => 0,
                'crop' => 0,
            ),
        ),
    );