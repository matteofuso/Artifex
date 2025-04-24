<?php

namespace Functions;
require_once 'Config/Project.php';

use Config\Project as Config;

class Panic
{
    public static function panic(string $location, string $code, string $referer = ''): void
    {
        if ($referer) {
            $referer = '&ref=' . urlencode($referer);
        }
        header("Location: " . Config::$path . "$location?err={$code}{$referer}");
        die();
    }
}