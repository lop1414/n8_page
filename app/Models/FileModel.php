<?php

namespace App\Models;

use App\Common\Models\BaseModel;

class FileModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * 关联到模型数据表的主键
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param $value
     * @return string
     * 属性访问器
     */
    public function getPathAttribute($value)
    {
        return env('APP_STORAGE_URL') .'/'. $value;
    }

    /**
     * @param $value
     * 属性修饰器
     */
    public function setPathAttribute($value)
    {
        $path = str_replace(env('APP_STORAGE_URL'), '', $value);
        $this->attributes['path'] = trim($path, '/');
    }
}
