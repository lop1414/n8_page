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
        $this->mkdir($this->htmlPath);
        $fileName = $this->getHtmlFile($n8PageId);
        $html = str_replace('__N8_PAGE_ID__',$n8PageId,stripslashes(urldecode(base64_decode($html))));
        file_put_contents($fileName,$html);
        return true;
    }


    /**
     * @param $base64ImageContent
     * @return string
     */
    public function createReviewImg($n8PageId,$base64ImageContent){
        $this->mkdir($this->reviewImgPath);

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64ImageContent, $result)){
            $type = $result[2];

//            $new_file =  $this->reviewImgPath.'/'.$n8PageId.'.'.$type;
            $new_file =  $this->getPreviewImg($n8PageId);

            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64ImageContent)))){
                return '/'.$new_file;
            }else{
                return false;
            }
        }else {
            return false;
        }
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


    protected function mkdir($dir, $mode = 0777)
    {
        if(!file_exists($dir)){
            mkdir($dir,$mode,true);
        }
    }


    public function getUrl($n8PageId){
        return env('APP_STORAGE_URL').'/page/'.$n8PageId.'.html';
    }

    public function getPreviewImgUrl($n8PageId){
        return env('APP_STORAGE_URL').'/page_review/'.$n8PageId.'.png';
    }
}
