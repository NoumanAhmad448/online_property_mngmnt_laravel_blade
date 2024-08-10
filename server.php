<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @author   Taylor Otwell <taylor@laravel.com>
 */
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

$is_root = '';
// if you move this file in public folder uncomment the below line
// $is_root = "public/";

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.

// if you move this file in public folder uncomment the below line
// if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
if ($uri !== '/' && file_exists(__DIR__.$uri)) {
    return false;
}

require_once __DIR__.'/'.$is_root.'index.php';
