<?php


namespace App\Enums;

/**
 * 队列枚举
 * Class QueueEnums
 * @package App\Enums
 */
class QueueEnums
{
    const PAGE_SHOW = 'PAGE_SHOW';




    /**
     * @var string
     * 名称
     */
    static public $name = '队列枚举';


    static public $list = [
        ['id' => self::PAGE_SHOW,        'name' => '页面展示'],
    ];


}
