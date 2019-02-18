<?php
namespace Lib\Common;


use Lib\Translate\T;

class Format
{
    /**
     * Generate array of split HTML (prefix, data, suffix) to represent a timestamp, optionally with the full date.
     *
     * @param int $timestamp Unix timestamp.
     * @param int $fullDateDays Number of days after which to show the full date.
     * @return array  The HTML.
     * @throws \Lib\Exception
     */
    public static function ilya_when_to_html($timestamp, $fullDateDays)
    {
        if (!$timestamp)
        {
            return ['data' => null];
        }

        $interval = time() - $timestamp;

        if ($interval < 0 || (isset($fullDateDays) && $interval > 86400 * $fullDateDays)) {
            // full style date
            $stampyear = date('Y', $timestamp);
            $thisyear = date('Y', time());

            if ($stampyear == $thisyear)
            {
                $dateFormat = T::_('date_format_this_year');
            }
            else
            {
                $dateFormat = T::_('date_format_other_years');
            }
            $replaceData = array(
                '^day' => date(T::_('date_day_min_digits') == 2 ? 'd' : 'j', $timestamp),
                '^month' => T::_('date_month_' . date('n', $timestamp)),
                '^year' => date(T::_('date_year_digits') == 2 ? 'y' : 'Y', $timestamp),
            );

            return array(
                'data' => Base::ilya_html(strtr($dateFormat, $replaceData)),
            );

        } else {
            // ago-style date
            return Base::ilya_lang_html_sub_split('x_ago', Base::ilya_html(self::ilya_time_to_string($interval)));
        }
    }

    /**
     * Return textual representation of $seconds
     * @param $seconds
     * @return mixed|string
     */
    public static function ilya_time_to_string($seconds)
    {
        $seconds = max($seconds, 1);
        $string = '';

        $scales = array(
            31557600 => array('1_year', 'x_years'),
            2629800 => array('1_month', 'x_months'),
            604800 => array('1_week', 'x_weeks'),
            86400 => array('1_day', 'x_days'),
            3600 => array('1_hour', 'x_hours'),
            60 => array('1_minute', 'x_minutes'),
            1 => array('1_second', 'x_seconds'),
        );

        foreach ($scales as $scale => $phrases) {
            if ($seconds >= $scale) {
                $count = floor($seconds / $scale);

                if ($count == 1)
                    $string = T::_($phrases[0]);
                else
                    $string = Base::ilya_lang_sub($phrases[1], $count);

                break;
            }
        }

        return $string;
    }
}