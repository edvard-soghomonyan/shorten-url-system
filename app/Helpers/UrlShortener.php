<?php
namespace App\Helpers;

class UrlShortener {

    /**
     * The base.
     *
     * @var string
     */
    private static $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Convert a from a given base to base 10.
     *
     * @param  string  $value
     * @param  int     $base
     * @return int
     */
    public static function toBase10($value, $base = 62)
    {
        $limit = strlen($value);
        $result = strpos(static::$base, $value[0]);

        for($i = 1; $i < $limit; $i++)
        {
            $result = $base * $result + strpos(static::$base, $value[$i]);
        }

        return $result;
    }

    /**
     * Convert from base 10 to another base.
     *
     * @param  int     $value
     * @param  int     $base
     * @return string
     */
    public static function toBase($value, $base = 62)
    {
        $r = $value  % $base;
        $result = static::$base[$r];
        $q = floor($value / $base);

        while ($q)
        {
            $r = $q % $base;
            $q = floor($q / $base);
            $result = static::$base[$r].$result;
        }

        return $result;
    }

}