<?php

namespace App\Models;


use App\Common\Helpers\Emoji;
use App\Common\Models\BaseModel;

class AdPageModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'ad_pages';



    /**
     * 页面内容
     */
    public function page_content(){
        return $this->hasOne('App\Models\PageContentModel', 'n8_page_id', 'n8_page_id');
    }


    /**
     * 属性访问器
     * @param $value
     * @return mixed
     */
    public function getNameAttribute($value){
        return Emoji::encode($value);
    }

    /**
     * 属性修饰器
     * @param $value
     */
    public function setExtendsAttribute($value){
        $this->attributes['name'] = Emoji::decode($value);
    }


    /**
     * 属性访问器
     * @param $value
     * @return mixed
     */
    public function getTitleAttribute($value){
        return Emoji::encode($value);
    }

    /**
     * 属性修饰器
     * @param $value
     */
    public function setTitleAttribute($value){
        $this->attributes['title'] = Emoji::decode($value);
    }

}
