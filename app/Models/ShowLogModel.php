<?php

namespace App\Models;


use App\Common\Models\BaseModel;

class ShowLogModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'show_logs';



    /**
     * 禁用默认更新时间
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'n8_page_id',
        'time',
        'page_type',
        'link',
        'ip',
        'ua',
        'platform',
        'created_at',
    ];


    public function setTableNameWithMonth($dateTime){

        $name =  'show_logs_'. date('Ym',strtotime($dateTime));
        $this->table = $name;
        return $this;
    }


    /**
     * 广告落地页
     */
    public function ad_page(){
        return $this->hasOne('App\Models\AdPageModel', 'n8_page_id', 'n8_page_id');
    }


    /**
     * 页面内容
     */
    public function page_content(){
        return $this->hasOne('App\Models\PageContentModel', 'n8_page_id', 'n8_page_id');
    }




}
