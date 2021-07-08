<?php

namespace App\Services;

use App\Common\Services\BaseService;


class PageService extends BaseService
{

    protected $htmlPath;

    protected $reviewImgPath;

    public function __construct(){
        parent::__construct();
        $this->htmlPath = storage_path('app/public/page');
        $this->reviewImgPath = storage_path('app/public/page_review');
    }


    protected function saveHtmlFile($n8PageId,$html){
        $fileName = $this->getHtmlFile($n8PageId);
        $html = stripslashes(base64_decode($html));
        file_put_contents($fileName,$html);
        return true;
    }


    /**
     * @param $htmlFileName
     * @return string
     * todo
     */
    protected function createReviewImg($n8PageId,$htmlFileName){
        return '';
    }


    protected function getHtmlFile($n8PageId){
        return $this->htmlPath.'/'.$n8PageId.'.html';
    }

    protected function getPreviewImg($n8PageId){
        return $this->reviewImgPath.'/'.$n8PageId.'.png';
    }


    protected function delHtmlFileAndPreviewImg($n8PageId){
        $fileName = $this->getHtmlFile($n8PageId);
        $imgName = $this->getPreviewImg($n8PageId);
        if(file_exists($fileName))   unlink($fileName);
        if(file_exists($imgName))   unlink($imgName);
    }
}
