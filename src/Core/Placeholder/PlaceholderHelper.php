<?php
namespace Pars\Core\Placeholder;

class PlaceholderHelper
{
    /**
     * @param string $str
     * @return array
     */
    public static function findPlaceholderResolved(string $str): array
    {
        $result = [];
        $placeholders = self::findPlaceholder($str);
        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($placeholders));
        foreach ($it as $value) {
            $result[$value] = self::removeDelimiter($value);
        }
        return $result;
    }

    public static function removeDelimiter(string $placeholder): string
    {
        $replace['{'] = '';
        $replace[urlencode('{')] = '';
        $replace[urlencode(urlencode('{'))] = '';
        $replace['}'] = '';
        $replace[urlencode('}')] = '';
        $replace[urlencode(urlencode('}'))] = '';
        return str_replace(array_keys($replace), array_values($replace), $placeholder);
    }

    /**
     * @param string $str
     * @return array
     */
    public static function findPlaceholder(string $str): array
    {
        $matches = [];
        preg_match_all('/\{.*?\}|%7B.*?%7D|%257B.*?%257D/', $str, $matches);
        return $matches;
    }

    public static function replacePlaceholder(string $str, array $data)
    {
        $placeholder = self::findPlaceholderResolved($str);
        foreach ($placeholder as $pl => $key) {
            $str = str_replace($pl, $data[$key] ?? '', $str);
        }
        return $str;
    }
}
