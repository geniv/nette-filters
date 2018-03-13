<?php declare(strict_types=1);

namespace Filters;

use DateTime;
use Nette\SmartObject;


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
     */
    public static function dateDiff(DateTime $from = null, DateTime $to = null, string $format): string
    {
        if (!$from) {
            return '';
        }
        if (!$to) { // if not define to then to date is set today
            $to = new DateTime();
        }
        return $from->diff($to)->format($format);
    }
}
