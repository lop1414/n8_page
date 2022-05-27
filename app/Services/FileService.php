<?php

namespace App\Services;

use App\Common\Helpers\Functions;
use App\Common\Services\BaseService;
use App\Common\Tools\CustomException;
use App\Models\FileModel;

class FileService extends BaseService
{
    /**
     * FileService constructor.
     */
    public function __construct(){
        parent::__construct();

        $this->model = new FileModel();
    }

    /**
     * @return array
     * 获取允许图片文件后缀
     */
    public function getAccessFileSuffix(){
        return [
            'jpg', 'jpeg', 'gif', 'bmp', 'png',
            'mp4', 'avi', 'mov', 'rmvb', 'rm', 'flv',
            'doc', 'docx', 'xls', 'xlsx',
            'ppt', 'pptx', 'pdf',
        ];
    }

    /**
     * @param $filename
     * @return bool
     * 是否为合法文件
     */
    public function isAccessFile($filename){
        $tmp = explode(".", $filename);
        $suffix = end($tmp);
        return in_array($suffix, $this->getAccessFileSuffix());
    }

    /**
     * @param $file
     * @return mixed
     * @throws CustomException
     * 上传
     */
    public function upload($file){
        if(is_null($file)){
            throw new CustomException([
                'code' => 'NOT_FOUND_UPLOAD_FILE',
                'message' => '未找到上传文件',
            ]);
        }

        if(!$file->isValid()){
            throw new CustomException([
                'code' => 'UPLOAD_FILE_FAIL',
                'message' => '上传文件失败',
            ]);
        }

        if(!$this->isAccessFile($file->getClientOriginalName())){
            $accessFileSuffix = implode(",", $this->getAccessFileSuffix());
            throw new CustomException([
                'code' => 'FILE_SUFFIX_IS_NOT_ACCESS',
                'message' => '非合法文件类型, 仅可以上传'. $accessFileSuffix,
            ]);
        }

        // 文件类型
        $mimeType = $file->getClientMimeType();
        $tmp = explode("/", $mimeType);
        $type = $tmp[0] ?? '';

        $size = $file->getSize();
        $maxFilesize = $file->getMaxFilesize();
        if($size > $maxFilesize){
            throw new CustomException([
                'code' => 'UPLOAD_FILE_TO_BIG',
                'message' => '上传文件超过上限',
            ]);
        }

        // storage目录
        $storageDir = storage_path('app/public');

        // 生成md5文件名
        $md5 = md5(uniqid());
        $saveFilename = $md5 .'.'. $file->getClientOriginalExtension();

        // md5前缀目录
        $prefixDir = substr($saveFilename, 0, 2);

        // 创建存放目录
        $fileDir = "{$storageDir}/file/{$type}/{$prefixDir}";
        if(!is_dir($fileDir)){
            mkdir($fileDir, 0755, true);
        }

        // 移动文件
        $file->move($fileDir, $saveFilename);

        // 路径
        $path = "file/{$type}/{$prefixDir}/{$saveFilename}";

        // 名称
        $tmp = explode(".", $file->getClientOriginalName());
        array_pop($tmp);
        $name = implode(".", $tmp);

        // 获取管理员信息
        $adminUserInfo = Functions::getGlobalData('admin_user_info');

        $this->model->name = $name;
        $this->model->type = $type;
        $this->model->path = $path;
        $this->model->admin_id = $adminUserInfo['admin_user']['id'];
        $ret = $this->model->save();

        return $ret;
    }
}
