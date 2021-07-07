<?php

namespace App\Services;

use App\Common\Services\BaseService;


class PageService extends BaseService
{

    protected $savePath;

    public function __construct(){
        parent::__construct();
        $this->setPath();
    }


    public function setPath($path = ''){
        $this->savePath = $path ? :storage_path('app/public');
    }


    protected function saveHtmlFile($n8PageId,$html){
        $fileName = $this->savePath.'/'.$n8PageId.'.html';
        file_put_contents($fileName,$html);
        return true;
    }
}
