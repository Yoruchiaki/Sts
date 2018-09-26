<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2018/8/11
 * Time: 23:39
 */

namespace Yoruchiaki\Sts\Facades;


use Illuminate\Support\Facades\Facade;

class Sts extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Sts';
    }
}