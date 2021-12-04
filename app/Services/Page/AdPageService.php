<?php

namespace App\Services;

use App\Common\Tools\CustomException;
use App\Enums\PageTypeEnums;
use App\Models\AdPageModel;
use Illuminate\Support\Facades\DB;


class AdPageService extends PageService
{

    public function create($data){
        try{
            DB::beginTransaction();

            $page = $this->makeGlobalPage(PageTypeEnums::AD);
            $n8PageId = $page->n8_page_id;

            $this->saveHtmlFile($n8PageId,$data['html']);
            if(isset($data['review_img'])) {
                $this->createReviewImg($n8PageId, $data['review_img']);
            }

            // 创建ad page
            $adPage = new AdPageModel();
            $adPage->n8_page_id = $n8PageId;
            $adPage->name = $data['name'];
            $adPage->title = $data['title'];
            $adPage->android_channel_id = $data['android_channel_id'];
            $adPage->ios_channel_id = $data['ios_channel_id'];
            $adPage->multi_platform_channel_id = $data['multi_platform_channel_id'];
            $adPage->status = $data['status'];
            $adPage->admin_id = $data['admin_id'];
            $adPage->structure_version = $data['structure_version'];
            $adPage->save();

            $content = $data['content'] ?? '';
            $this->createPageContent($n8PageId,$content);

            DB::commit();

            return $adPage;
        }catch (CustomException $e){
            DB::rollBack();
            $this->delHtmlFileAndPreviewImg($n8PageId);
            throw $e;
        }catch (\Exception $e){
            DB::rollBack();
            $this->delHtmlFileAndPreviewImg($n8PageId);
            throw $e;
        }
    }


    public function update($id,$data){
        try{
            DB::beginTransaction();

            $adPage = (new AdPageModel())->where('id',$id)->first();
            $n8PageId = $adPage->n8_page_id;

            $this->saveHtmlFile($n8PageId,$data['html']);
            if(isset($data['review_img'])){
                $this->createReviewImg($adPage->n8_page_id,$data['review_img']);
            }

            $this->createReviewImg($n8PageId,$this->getHtmlFile($n8PageId));

            $adPage->name = $data['name'];
            $adPage->title = $data['title'];
            $adPage->android_channel_id = $data['android_channel_id'];
            $adPage->ios_channel_id = $data['ios_channel_id'];
            $adPage->multi_platform_channel_id = $data['multi_platform_channel_id'];
            $adPage->status = $data['status'];
            $adPage->structure_version = $data['structure_version'];
            if(isset($data['admin_id'])){
                $adPage->admin_id = $data['admin_id'];
            }
            $adPage->save();

            $content = $data['content'] ?? '';
            $this->updatePageContent($n8PageId,$content);

            DB::commit();

            return $adPage;
        }catch (CustomException $e){
            DB::rollBack();
            $this->delHtmlFileAndPreviewImg($n8PageId);
            throw $e;
        }catch (\Exception $e){
            DB::rollBack();
            $this->delHtmlFileAndPreviewImg($n8PageId);
            throw $e;
        }
    }
}
