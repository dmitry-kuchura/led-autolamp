<?php
return [
    'watermark' => 'pic/logo.png',
    'types' => [
        'jpg', 'jpeg', 'png', 'gif',
    ],
    'reviews' => [
        [
            'path' => 'small',
            'width' => 124,
            'height' => 124,
            'resize' => 1,
            'crop' => 1,
        ],
        [
            'path' => 'original',
            'resize' => 0,
            'crop' => 0,
        ],
    ],
];