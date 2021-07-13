<?php
namespace App\Http\Controllers\Admin;


use App\Common\Enums\StatusEnum;
use App\Common\Helpers\Functions;
use App\Common\Services\SystemApi\UnionApiService;
use App\Models\AdPageModel;
use App\Services\AdPageService;
use App\Services\PageService;
use Illuminate\Http\Request;

class AdPageController extends BaseController
{

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->model = new AdPageModel();

        parent::__construct();
    }



    /**
     * 过滤
     */
    public function dataFilter(){

        $this->curdService->customBuilder(function ($builder){

            if(!empty($req['admin_id'])){
                $builder->where('admin_id',$req['admin_id']);
            }

            if(!$this->isDataAuth()){
                $builder->where('admin_id',$this->adminUser['admin_user']['id']);
            }

        });
    }



    /**
     * 分页列表预处理
     */
    public function selectPrepare(){

        $this->curdService->selectQueryBefore(function (){
            $this->dataFilter();
        });

        $this->curdService->selectQueryAfter(function(){
            $map = $this->getAdminUserMap();
            $unionService = new UnionApiService();
            $pageService = new PageService();
            foreach ($this->curdService->responseData['list'] as $item){
                $item->admin_name = $item->admin_id ? $map[$item->admin_id]['name'] : '';
                $item->android_channel = $unionService->apiReadChannel(['id'=>$item->android_channel_id]);
                $item->ios_channel = $item->android_channel;
                if($item->android_channel_id != $item->ios_channel_id){
                    $item->ios_channel = $unionService->apiReadChannel(['id'=>$item->ios_channel_id]);
                }
                $item->url = $pageService->getUrl($item->n8_page_id);
                $item->preview_img = $pageService->getPreviewImgUrl($item->n8_page_id);
            }
        });
    }




    /**
     * 详情预处理
     */
    public function readPrepare(){

        $this->curdService->findAfter(function(){
            $this->curdService->responseData->page_content;
            $unionService = new UnionApiService();
            $pageService = new PageService();
            $this->curdService->responseData->android_channel = $unionService->apiReadChannel(['id'=>$this->curdService->responseData->android_channel_id]);
            $this->curdService->responseData->ios_channel = $this->curdService->responseData->android_channel;
            if($this->curdService->responseData->android_channel_id != $this->curdService->responseData->ios_channel_id){
                $this->curdService->responseData->ios_channel = $unionService->apiReadChannel(['id'=>$this->curdService->responseData->ios_channel_id]);
            }
            $this->curdService->responseData->multi_platform_channel = [];
            if(!empty($this->curdService->responseData->multi_platform_channel_id)){
                $this->curdService->responseData->multi_platform_channel = $unionService->apiReadMultiPlatChannelById($this->curdService->responseData->multi_platform_channel_id);

            }

            $this->curdService->responseData->url = $pageService->getUrl($this->curdService->responseData->n8_page_id);
            $this->curdService->responseData->preview_img = $pageService->getPreviewImgUrl($this->curdService->responseData->n8_page_id);
        });
    }




    /**
     * 保存验证规则
     */
    public function saveValidRule($req){

        $this->validRule($req,[
            'name'    =>  'required',
            'title'   =>  'required',
            'android_channel_id' =>  'required',
            'ios_channel_id' =>  'required',
            'multi_platform_channel_id' =>  'present',
            'html'     =>  'required',
            'status'   =>  'required',
        ]);
        Functions::hasEnum(StatusEnum::class,$req['status']);

    }



    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * 创建
     */
    public function create(Request $request){
        $requestData = $request->all();
        $this->saveValidRule($requestData);

        $requestData['admin_id'] = $this->adminUser['admin_user']['id'];
        $adPage = (new AdPageService())->create($requestData);

        return $this->ret($adPage, $adPage);
    }





    /**
     * @param Request $request
     * @return mixed
     * @throws \App\Common\Tools\CustomException
     * 更新
     */
    public function update(Request $request){
        $requestData = $request->all();
        $this->validRule($requestData,[
            'id'    =>  'required'
        ]);
        $this->saveValidRule($requestData);

        if(!$this->isAdmin()){
            unset($requestData['admin_id']);
        }

        $adPage = (new AdPageService())->update($requestData['id'],$requestData);
        return $this->ret($adPage, $adPage);

    }

}
