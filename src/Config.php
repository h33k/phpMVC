<?php

namespace App;

class Config
{
    public static function get(): array
    {
        return [
            'db_host' => 'localhost',
            'db_name' => 'php_mvc',
            'db_user' => 'root',
            'db_pass' => '',
            'db_port' => '3306',
            // add here
        ];
    }

    public static function getValue(string $key, $default = null)
    {
        $config = self::get();
        return $config[$key] ?? $default;
    }
}