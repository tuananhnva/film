<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 27/01/17
 * Time: 16:56
 *  Tong hop cac ham ho tro ve session
 */


/**
 * Created by : BillJanny
 * Date: 17:34 - 27/01/17
 * Kiem tra su ton tai cua session flash
 * @param string $key : key cua session ton tai
 * @return mixed
 */
if (! function_exists('has_flash'))
{
    function has_flash($key)
    {
        return has_session($key);
    }
}

/**
 * Created by : BillJanny
 * Date: 17:34 - 27/01/17
 * Thiet lap session flash. Bi bien mat luon sau khi load trang
 * @param string $key : key cua session ton tai
 * @param string $value : gia tri cua session ton tai
 * @return void
 */
if (! function_exists('set_flash'))
{
    function set_flash($key, $value)
    {
        \Session::flash($key, $value);
    }
}

/**
 * Created by : BillJanny
 * Date: 17:36 - 27/01/17
 * Nhan thong tin session flash
 * @param string $key  : key cua session
 * @return void
 */
if (! function_exists('get_flash'))
{
    function get_flash($key)
    {
        return get_session($key);
    }
}

/**
 * Created by : BillJanny
 * Date: 17:30 - 27/01/17
 * Kiem tra su ton tai cua session
 * @param string $key : key trong mang session
 * @return mixed
 */
if (! function_exists('has_session'))
{
    function has_session($key)
    {
        return \Session::has($key);
    }
}

/**
 * Created by : BillJanny
 * Date: 17:32 - 27/01/17
 * Thiet lap session tuong ung voi key va value
 * @param string $key : key cua session ung voi gia tri
 * @param string $value : value cua session
 * @return void
 */
if (! function_exists('set_session'))
{
    function set_session($key, $value)
    {
        \Session::put($key, $value);
    }
}

/**
 * Created by : BillJanny
 * Date: 17:31 - 27/01/17
 * Lay mot session nao do trong mang session ton tai
 * @param string $key : key ton tai cua mang session
 * @return mixed
 */
if (! function_exists('get_session'))
{
    function get_session($key)
    {
        return \Session::get($key);
    }
}

/**
 * Created by : BillJanny
 * Date: 17:31 - 27/01/17
 * Xoa mot key session nao do
 * @param string $key key cua mang session
 * @return mixed
 */
if (! function_exists('delete_session'))
{
    function delete_session($key)
    {
        \Session::forget($key);
    }
}

/**
 * Created by : BillJanny
 * Date: 17:30 - 27/01/17
 * Xoa toan bo session
 * @param void
 * @return void
 */
if (! function_exists('delete_all_session'))
{
    function delete_all_session()
    {
        \Session::flush();
    }
}