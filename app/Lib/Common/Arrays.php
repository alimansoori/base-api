<?php
namespace Lib\Common;

class Arrays
{
    /**
     * @param array $array
     * @return null|string
     * @example
     *    Desc
     *    <code>
     * ```php
     * $array = [
     *    'id' => 'id-elem',
     *    'class' => 'class-elem'
     * ];
     * Lib\Common\Arrays::arrayToStringTags( $array )
     * ```
     *    </code>
     */
    public static function arrayToStringTags(array $array )
    {
        $attrs = '';
        if(is_array($array) && !empty($array))
        {
            $count = count($array);
            $i = 1;

            foreach($array as $key => $value)
            {
                $attrs .= " $key='$value'";

                if($i !== $count)
                {
                    $attrs .= ' ';
                }
                $i++;
            }
        }

        return $attrs;
    }

    /**
     * compare 2 arrays and returns an array contains differences
     * in this example, compares translate cache and translate model,
     * and returns an array that does not exist in the database  *
     */
    public static function compareArrays(array $array1 ,array $array2)
    {
        $diff =[];

        foreach ($array1 as $lang => $value)
        {
            if ( isset($array2[$lang])  )
            {
                foreach ($value as $phrase => $translate)
                {
                    if (!array_key_exists($phrase,$array2[$lang]))
                    {
                        $diff[$lang][$phrase] = $translate;
                    }
                }
            }
            else
            {
                $diff[$lang];
            }
        }
        return $diff;
    }

    public static function treeFlat(array $elements, $parentId = null, $level = 0, $parent = 'parent_id') {

        $branch = [];
        foreach ($elements as $element) {
            if ($element[$parent] == $parentId) {
                $element['DT_RowId'] = $element['id'];
                $element['child'] = 0;
                $element['level'] = $level;
                $row = [];

                $children = self::treeFlat($elements, $element['id'], $level+1);

                if (is_array($children))
                {
                    $ch = [];
                    foreach ($children as $child)
                    {
                        if ($child[$parent] == $element['id'])
                        {
                            $ch[] = $child;
                        }
                    }
//                    $element['child'] = count($children);
                    $element['child'] = count($ch);
                    $row = array_merge([$element], $children);
                }
                else
                {
                    $branch[] = $element;
                }
                $branch = array_merge($branch, $row);
            }
        }

        return $branch;
    }

    public static function tree(array $elements, $parentId = null,  $parent = 'parent_id') {

        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $row = [];

                $children = self::tree($elements, $element['id']);

                $element['children'] = $children;

                $branch[] = $element;
            }

        }

        return $branch;
    }
}