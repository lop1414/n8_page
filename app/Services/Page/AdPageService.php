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
            // 创建ad page
            $adPage = new AdPageModel();
            $adPage->n8_page_id = $page->n8_page_id;
            $adPage->name = $data['name'];
            $adPage->title = $data['title'];
            $adPage->preview_url = '';
            $adPage->android_channel_id = $data['android_channel_id'];
            $adPage->ios_channel_id = $data['ios_channel_id'];
            $adPage->status = $data['status'];
            $adPage->admin_id = $data['admin_id'];
            $adPage->save();

            // 创建page content
            $pageContent = new PageContentModel();
            $pageContent->n8_page_id = $page->n8_page_id;
            $pageContent->content = $data['content'];
            $pageContent->save();

            $this->saveHtmlFile($page->n8_page_id,$data['content']);

            DB::commit();

            return $adPage;
        }catch (CustomException $e){
            DB::rollBack();
            throw $e;
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
