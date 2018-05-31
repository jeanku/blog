<?php namespace App\Util;

class ArrayFn
{

    /**
     * 检验数组中多个元素是否（不为空）
     *
     * 如果数组 @arr 中 $fields 这些元素全部都不为空，则返回 true , 否则返回false
     *
     * @param array $arr
     * @param array $fields
     *
     * @return bool
     */
    public static function fieldsNotEmpty($arr, $fields = array())
    {
        if (empty($arr) || !is_array($arr)) {
            return false;
        }

        foreach ($fields as $key) {
            if (empty($arr[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * 二维数组排序
     *
     * @param array $array 待排序的二维数组
     * @param string $key 排序的键值
     * @param string $sort ASC：升序 DESC 降序
     *
     * @return array
     */
    public static function multiSort($array, $key, $sort = 'ASC')
    {
        if (!is_array($array) || !is_array(current($array))) {
            return array();
        }

        $tmpArr = array();
        foreach ($array as $k => $v) {
            $tmpArr[$k] = $v[$key];
        }

        $sortOrder = $sort == 'ASC' ? SORT_ASC : SORT_DESC;

        array_multisort($tmpArr, $sortOrder, $array);

        return $array;
    }

    /**
     * 挑选数组一维key中指定的某些字段
     *
     * @param array $item
     * @param array|string $fields
     *
     * @return array
     */
    /**
     * 挑选数组一维key中指定的某些字段 [ 支持 'a as b' 格式 ]
     *
     * @param array $item
     * @param array|string $fields
     *
     * @return array
     */
    public static function select($item, $fields = array())
    {
        if (empty($fields)) {
            return $item;
        }

        // 逗号分隔的字段名转化为数组
        if (is_string($fields)) {
            $fields = array_map('trim', explode(',', $fields));
        }

        $formatFields = [];
        foreach ($fields as $column) {
            $column = trim($column);
            if (stripos($column, ' ') > 0) {
                $column = str_ireplace(' as ', ' ', $column);
                $keywords = preg_split('/[\s]+/', $column);
                $formatFields[$keywords[0]] = $keywords[1];
            } else {
                $formatFields[$column] = $column;
            }
        }

        $format = array();
        if (!empty($item)) {
            foreach ($item as $key => $value) {
                if (isset($formatFields[$key])) {
                    $format[$formatFields[$key]] = $value;
                }
            }
        }

        return $format;
    }

    /**
     * 挑选二维数组各元素的[指定的某些]字段
     * select2($arr, array('field_1', 'f_2', 'f_3'));
     * 类似 sql: [select field_1, f_2, f_3 from table_name]的功能
     *
     * @param array $array 二维数组
     * @param array|string $fields 指定的字段list or 逗号分隔的字段名字符串
     * @param boolean $assoc 是否保持原关联
     *
     * @return array
     */
    public static function select2($array, $fields = array(), $assoc = true)
    {
        if (empty($array)) {
            return array();
        }

        // 逗号分隔的字段名转化为数组
        if (is_string($fields)) {
            $fields = array_map('trim', explode(',', $fields));
        }

        $format = array();
        foreach ($array as $idx => $item) {
            $formatItem = array();
            foreach ($item as $key => $value) {
                if (in_array($key, $fields)) {
                    $formatItem[$key] = $value;
                }
            }
            $format[$idx] = $formatItem;
        }

        return $assoc ? $format : array_values($format);
    }

    /**
     * 挑选二维数组中各个元素的[指定字段] 组成一个数组返回
     *
     * @param array $array 二维数组
     * @param string|int $fieldName 指定的字段名
     * @param boolean $assoc 是否保持原关联
     *
     * @return array
     */
    public static function getFieldValues($array, $fieldName, $assoc = true)
    {
        if (empty($array) || !is_scalar($fieldName)) {
            return array();
        }

        $format = array();
        foreach ($array as $key => $value) {
            $format[$key] = isset($value[$fieldName]) ? $value[$fieldName] : NULL;
        }

        return $assoc ? $format : array_values($format);
    }

    /**
     * 根据数组第二维的字段值 查找数组元素，类似数据库按字段查找记录
     *
     * @param array $array 待查找的数组
     * @param array $fields array( 'name'=>'xiaowen', 'village'=>'xxxxx')  同时满足
     * @param integer $limit 限制返回记录个数
     *
     * @return array
     */
    public static function searchByFields($array, $fields = array(), $limit = 0)
    {
        if (empty($fields) || empty($array)) {
            return array();
        }

        if (!$limit) {
            $limit = count($array);
        }

        $result = array();
        $count = 0;
        foreach ($array as $key => $value) {
            $find = true;
            foreach ($fields as $fkey => $fvalue) {
                if ($value[$fkey] !== $fvalue) {
                    $find = false;
                    break;
                }
            }

            if ($find) {
                $count++;
                $result[] = $value;

                if ($limit == $count) {
                    return $result;
                }
            }
        }

        return $result;
    }

    /**
     * 类似sql的 group by ，每条记录的值也需要保证跟数据库记录一样，为标量(非数组、对象等)类型
     *
     * @param string $array 待操作的数组
     * @param string $field 按这个字段 group by
     *
     * @return array|bool
     */
    public static function groupByField($array, $field = '')
    {
        if (empty($array) || empty($field)) {
            return $array;
        }

        $result = array();
        foreach ($array as $key => $value) {
            $fvalue = empty($value[$field]) ? '' : $value[$field];
            if (!is_scalar($fvalue)) {
                // 确保记录里的字段值都是跟string兼容的类型
                return false;
            }

            $result[$fvalue][] = $value;
        }

        return $result;
    }

    /**
     * 将一维数组的key-value 链接起来
     *
     * @param array $array 一维数组
     * @param string $assign_symbol key 和 value之前的连接符
     * @param string $join_symbol 不同元素之间的连接符
     *
     * @return string
     */
    public static function kvJoin($array, $assign_symbol = '=', $join_symbol = '&')
    {
        $str = '';
        foreach ($array as $key => $value) {
            $str .= $key . $assign_symbol . $value . $join_symbol;
        }

        // 去掉最后多余的 $join_symbol
        return substr($str, 0, -1);
    }

    /**
     * 将二维数组返回为 按元素的某个字段索引 （譬如以id 索引返回）
     *
     * @param $array
     * @param $idxField
     * @return array
     */
    public static function indexBy($array, $idxField)
    {
        if (empty($array) || empty($idxField)) {
            return array();
        }

        $format = array();
        foreach ($array as $idx => $item) {
            if (!isset($item[$idxField])) {
                continue;
            }

            $format[$item[$idxField]] = $item;
        }

        return $format;
    }

    /**
     * 二维数组某个字段sum
     *
     * @param $array
     * @param $field
     * @return    integer
     */
    public static function sumOf($array, $field)
    {
        $sum = 0;
        foreach ($array as $item) {
            if (!empty($item[$field])) {
                $sum += $item[$field];
            }
        }

        return $sum;
    }


    /**
     * 数组返回指定的keys
     * @param array $arr required 数组数据
     * @param array $keys required 指定keys
     * @return array
     */
    public static function selectKeys($arr, $keys)
    {
        return array_filter($arr, function($val, $key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_BOTH);
    }


    /**
     * 数组返回指定的keys
     * @param array $arr required 数组数据
     * @param string $key required 指定column
     * @return array
     */
    public static function setColumnAsKey($arr, $key)
    {
        $returnData = [];
        foreach ($arr as $val) {
            $returnData[$val[$key]] = $val;
        }
        return $returnData;
    }
}
