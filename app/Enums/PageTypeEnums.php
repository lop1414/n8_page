<?php


namespace App\Enums;


class PageTypeEnums
{
    const AD = 'AD';
    const NORMAL = 'NORMAL';

    /**
     * @var string
     * 名称
     */
    static public $name = '页面类型';

    /**
     * @var array
     * 列表
     */
    static public $list = [
        ['id' => self::AD, 'name' => '推广页面'],
        ['id' => self::NORMAL, 'name' => '普通页面'],
    ];

}
