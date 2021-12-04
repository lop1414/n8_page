<?php

namespace App\Models;


use App\Common\Models\BaseModel;

class NormalPageModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'normal_pages';



    /**
     * 页面内容
     */
    public function page_content(){
        return $this->hasOne('App\Models\PageContentModel', 'n8_page_id', 'n8_page_id');
    }

}
