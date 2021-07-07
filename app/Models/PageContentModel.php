<?php

namespace App\Models;


use App\Common\Models\BaseModel;

class PageContentModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'page_contents';




    /**
     * 禁用默认更新时间
     *
     * @var bool
     */
    public $timestamps = false;



    /**
     * @param $value
     * @return array
     * 属性访问器
     */
    public function getContentAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * @param $value
     * 属性修饰器
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }

}
