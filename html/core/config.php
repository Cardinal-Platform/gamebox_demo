<?php

class Config
{
    private static $config = array(
        'DB_HOST' => 'localhost',
        'DB_USER' => 'root',
        'DB_PASSWORD' => 'DatabaseTestPassw0rd',
        'DB_NAME' => 'cardinal_game',
    );

    public static function Get(string $key)
    {
        return self::$config[$key];
    }
}