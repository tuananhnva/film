<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 14/01/17
 * Time: 01:16
 */

if (!function_exists('generate_sql_batch_insert'))
{
    /**
     * Created by : BillJanny
     * Date: 01:17 - 14/01/17
     * Function tao ra mot chuoi dung de insert
     * @param string $table : ten table can insert
     * @param array $arr_field : mang code can truyen vao
     * @param array $arr_row : mang du lieu can truyen vao
     * @param string  $ignore
     * @return string
     */
    function generate_sql_batch_insert($table, $arr_field, $arr_row, $ignore='')
    {
        $num_field  = count($arr_field);
        $num_row    = count($arr_row);

        $sql  = '';
        $sql .= "INSERT {$ignore} INTO $table (";
        for ($i=0; $i< $num_field; $i++)
        {
            $sql.= $arr_field[$i];
            if ($i != $num_field - 1)
            {
                $sql .= ', ';
            }
        }

        $sql .= ') VALUES ';

        for ($i = 0; $i < $num_row; $i ++)
        {
            $sql .= '(';
            for ($j =0; $j< $num_field; $j++)
            {
                // Lay thong tin cu the cua tung ban ghi de noi mang
                $sql .= "'{$arr_row[$i][$j]}'";
                if ($j != $num_field -1)
                {
                    $sql .= ', ';
                }
            }

            $sql .= ')';
            if ($i != $num_row - 1)
            {
                $sql .= ', ';
            }
        }

        return $sql;
    }
}


/**
 * Created by : BillJanny
 * Date: 10:44 PM - 1/21/2017
 * Find a content table to execute
 * @param int $newId : thứ tự bản ghi là bao nhiêu
 * @param int $recordsNewsContent : mặc định là 50k
 * @return
 */
if (!function_exists('get_table_of_content_new'))
{
    function get_table_of_content_new($newId, $recordsNewsContent=50000)
    {
        return 'news_content_' . (int)ceil($newId/$recordsNewsContent);
    }
}