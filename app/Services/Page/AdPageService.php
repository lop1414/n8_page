<?php

namespace App\Services;

use App\Common\Tools\CustomException;
use App\Enums\PageTypeEnums;
use App\Models\AdPageModel;
use App\Models\PageContentModel;
use App\Models\PageModel;
use Illuminate\Support\Facades\DB;


class AdPageService extends PageService
{

    public function create($data){
        try{
            DB::beginTransaction();

            // 创建全局page id
            $page = new PageModel();
            $page->type = PageTypeEnums::AD;
            $page->save();


            $this->saveHtmlFile($page->n8_page_id,$data['html']);
            if(isset($data['review_img'])) {
                $this->createReviewImg($page->n8_page_id, $data['review_img']);
            }

            // 创建ad page
            $adPage = new AdPageModel();
            $adPage->n8_page_id = $page->n8_page_id;
            $adPage->name = $data['name'];
            $adPage->title = $data['title'];
            $adPage->android_channel_id = $data['android_channel_id'];
            $adPage->ios_channel_id = $data['ios_channel_id'];
            $adPage->multi_platform_channel_id = $data['multi_platform_channel_id'];
            $adPage->status = $data['status'];
            $adPage->admin_id = $data['admin_id'];
            $adPage->save();

            // 创建page content
            $pageContent = new PageContentModel();
            $pageContent->n8_page_id = $page->n8_page_id;
            $pageContent->content = $data['content'] ?? '';
            $pageContent->save();


            DB::commit();

            return $adPage;
        }catch (CustomException $e){
            DB::rollBack();
            $this->delHtmlFileAndPreviewImg($page->n8_page_id);
            throw $e;
        }catch (\Exception $e){
            DB::rollBack();
            $this->delHtmlFileAndPreviewImg($page->n8_page_id);
            throw $e;
        }
    }


    public function update($id,$data){
        try{
            DB::beginTransaction();

            // ad page
            $adPage = (new AdPageModel())->where('id',$id)->first();

            $this->saveHtmlFile($adPage->n8_page_id,$data['html']);
            if(isset($data['review_img'])){
                $this->createReviewImg($adPage->n8_page_id,$data['review_img']);
            }

            $this->createReviewImg($adPage->n8_page_id,$this->getHtmlFile($adPage->n8_page_id));

            $adPage->name = $data['name'];
            $adPage->title = $data['title'];
            $adPage->android_channel_id = $data['android_channel_id'];
            $adPage->ios_channel_id = $data['ios_channel_id'];
            $adPage->multi_platform_channel_id = $data['multi_platform_channel_id'];
            $adPage->status = $data['status'];
            if(isset($data['admin_id'])){
                $adPage->admin_id = $data['admin_id'];
            }
            $adPage->save();

            //page content
            $pageContent = (new PageContentModel())->where('n8_page_id',$adPage->n8_page_id)->first();
            $pageContent->content = $data['content'] ?? '';
            $pageContent->save();


            DB::commit();

            return $adPage;
        }catch (CustomException $e){
            DB::rollBack();
            $this->delHtmlFileAndPreviewImg($adPage->n8_page_id);
            throw $e;
        }catch (\Exception $e){
            DB::rollBack();
            $this->delHtmlFileAndPreviewImg($adPage->n8_page_id);
            throw $e;
        }
    }
}
