<?php

namespace App\Http\Controllers\Admin;

use App\Common\Controllers\Admin\AdminController;
use App\Models\FileModel;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends AdminController
{
    /**
     * constructor.
     */
    public function __construct(){
        $this->model = new FileModel();

        parent::__construct();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \App\Common\Tools\CustomException
     * 上传
     */
    public function upload(Request $request){
        $file = $request->file('file');

        $fileService = new FileService();
        $ret = $fileService->upload($file);

        return $this->ret($ret, $fileService->getModel());
    }
}
