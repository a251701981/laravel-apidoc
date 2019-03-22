<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/3/22
 * Time: 14:51
 */

namespace App\service;


class OtherService
{


    public function myfiter($str)
    {
        $str = addslashes($str);
        $str = str_replace(["\r","\n"],["\\r","\\n"],$str);
        return strip_tags($str);
    }


}