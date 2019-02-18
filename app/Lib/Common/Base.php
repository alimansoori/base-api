<?php
namespace Lib\Common;

use Lib\Exception;
use Lib\Translate\T;

class Base
{
    /**
     * Return HTML representation of $string, work well with blocks of text if $multiline is true
     * @param $string
     * @param bool $multiline
     * @return mixed|string
     */
    public static function ilya_html($string, $multiline = false)
    {
        $html = htmlspecialchars((string)$string);

        if ($multiline) {
            $html = preg_replace('/\r\n?/', "\n", $html);
            $html = preg_replace('/(?<=\s) /', '&nbsp;', $html);
            $html = str_replace("\t", '&nbsp; &nbsp; ', $html);
            $html = nl2br($html);
        }

        return $html;
    }

    /**
     * Return the translated string for $identifier, with $symbol substituted for $textparam
     * @param $identifier
     * @param $textparam
     * @param string $symbol
     * @return mixed
     */
    public static function ilya_lang_sub($identifier, $textparam, $symbol = '^')
    {
        return str_replace($symbol, $textparam, T::_($identifier));
    }

    /**
     * Return an array containing the translated string for $identifier converted to HTML, then split into three,
     * with $symbol substituted for $htmlparam in the 'data' element, and obvious 'prefix' and 'suffix' elements
     * @param $identifier
     * @param $htmlParam
     * @param string $symbol
     * @return array
     * @throws Exception
     */
    public static function ilya_lang_html_sub_split($identifier, $htmlParam, $symbol = '^')
    {
        $html = Base::ilya_html(T::_($identifier));

        $symbolPos = strpos($html, $symbol);
        if (!is_numeric($symbolPos))
        {
            throw new Exception('Missing ' . $symbol . ' in language string ' . $identifier);
        }

        return array(
            'prefix' => substr($html, 0, $symbolPos),
            'data' => $htmlParam,
            'suffix' => substr($html, $symbolPos + 1),
        );
    }
}