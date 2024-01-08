<?php

namespace Config;

class Config
{
    private const ENV_PATH =  '.env';

    public static function env(string $pair): string
    {
        $config = parse_ini_file(dirname(__FILE__, 2) . '/config/' . self::ENV_PATH);
        if ($config === false) {
            throw new \Exception("ERROR: .env not found");
        }
        return $config[$pair];
    }
}
