<?php

namespace Config;

class Project
{
    public static string $path = '';
    public static string $name = 'Artifex';
}

Project::$path = dirname($_SERVER['PHP_SELF']) . '/';