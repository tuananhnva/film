<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 27/01/17
 * Time: 17:38
 *  File nay gom cac function ho tro ve form
 */


/**
 * Created by : BillJanny
 * Date: 17:50 - 27/01/17
 * Kiem tra co loi khong xuat ra mot chuoi de cho form-group hien mau do neu co loi
 * @param string $key : key loi cua form
 * @return string
 */
if (! function_exists('has_error'))
{
    function has_error($key)
    {
        return $errors->has($key) ? 'has-error' : '';
    }
}

/**
 * Created by : BillJanny
 * Date: 18:17 - 27/01/17
 * Lay thong tin loi duoc thiet lap
 * @param string $key key cua loi
 * @return string
 */
if (! function_exists('get_error'))
{
    function get_error($key)
    {
        return $errors->first($key);
    }
}

/**
 * Created by : BillJanny
 * Date: 18:17 - 27/01/17
 * giu data trong form
 * @param  string $field : truong du lieu
 * @param  array $dataform : mang du lieu
 * @return string
 */
if (! function_exists('get_value_field'))
{
    function get_value_field($field, $dataform)
    {
        return old($field, isset($dataform) ? $dataform->$field : '');
    }
}






