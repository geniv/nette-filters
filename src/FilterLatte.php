<?php declare(strict_types=1);

namespace Filters;

use DateTime;
use Nette\Neon\Neon;
use Nette\SmartObject;
use Nette\Utils\Json;


/**
 * Class FilterLatte
 *
 * @author geniv
 * @package Filters
 */
class FilterLatte
{
    use SmartObject;


    /**
     * _loader.
     *
     * @param string $filter
     * @param        $value
     * @return mixed
     */
    public static function _loader(string $filter, $value)
    {
        if (method_exists(__CLASS__, $filter)) {
            $args = func_get_args();
            array_shift($args);
            return call_user_func_array([__CLASS__, $filter], $args);
        }
        return null;
    }


    /**
     * Add tag.
     *
     * @param string $string
     * @param string $tag
     * @return string
     */
    public static function addTag(string $string, string $tag): string
    {
        $lastPoint = strrpos($string, '.');
        return ($tag ? substr_replace($string, sprintf('.%s.', $tag), $lastPoint, 1) : $string);
    }


    /**
     * Mailto.
     *
     * @param string|null $string
     * @return string
     */
    public static function mailto(string $string = null): string
    {
        return ($string ? '<a href="mailto:' . str_replace('@', '%40', $string) . '">' . str_replace('@', '&#064;', $string) . '</a>' : '');
    }


    /**
     * Date diff.
     *
     * @param DateTime|null $from
     * @param DateTime|null $to
     * @param string        $format
     * @return string
     * @throws \Exception
     */
    public static function dateDiff(DateTime $from = null, DateTime $to = null, string $format = 'Y-m-d H:i:s'): string
    {
        if (!$from) {
            return '';
        }
        if (!$to) { // if not define to then to date is set today
            $to = new DateTime();
        }
        return $from->diff($to)->format($format);
    }


    /**
     * Google maps link.
     *
     * @see https://developers.google.com/maps/documentation/urls/guide
     * @param string $query
     * @return string
     */
    public static function googleMapsLink(string $query): string
    {
        $result = $query;
        if ($query) {
            $result = 'https://www.google.com/maps/search/?api=1&query=' . $query;
        }
        return $result;
    }


    /**
     * To url.
     *
     * @param string $url
     * @param string $scheme
     * @return string
     */
    public static function toUrl(string $url, string $scheme = 'http://'): string
    {
        $http = preg_match('/^http[s]?:\/\//', $url);
        return (!$http ? $scheme : '') . $url;
    }


    /**
     * Real url.
     *
     * @param string $value
     * @return string
     */
    public static function realUrl(string $value)
    {
        list($scheme, $url) = explode('//', $value);
        $reverse = explode('/', $url);
        $arr = [];
        foreach ($reverse as $item) {
            $arr[] = $item;
            if ($item == '..') {
                array_pop($arr);    // remove 2x from array stack
                array_pop($arr);
            }
        }
        return $scheme . '//' . implode('/', $arr);
    }


    /**
     * Neon.
     *
     * @see https://github.com/planette/nutella-project/blob/master/app/model/Latte/Filters.php
     * @param $value
     * @return string
     */
    public static function neon($value): string
    {
        return Neon::encode($value, Neon::BLOCK);
    }


    /**
     * Json.
     *
     * @param $value
     * @return string
     * @throws \Nette\Utils\JsonException
     */
    public static function json($value): string
    {
        return Json::encode($value);
    }
}
