<?php
    namespace Core;

    class General {

        public static function crop($type, $folder, $image, $uri = NULL) {
            $uri = $uri ?: $_SERVER['REQUEST_URI'];
            $array = array($type, $image, $uri, $folder);
            $json = json_encode($array);
            $hash = Encrypt::instance()->encode($json);
            return HTML::link('wezom/crop?hash='.urlencode($hash));
        }

    }