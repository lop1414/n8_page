<?php
namespace App\Http\Controllers\Admin;


use App\Common\Enums\StatusEnum;
use App\Common\Services\SystemApi\UnionApiService;
use App\Models\AdPageModel;
use App\Services\AdPageService;
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
            foreach ($this->curdService->responseData['list'] as $item){
                $item->admin_name = $item->admin_id ? $map[$item->admin_id]['name'] : '';
                $item->android_channel = $unionService->apiReadChannel(['id'=>$item->android_channel_id]);
                $item->ios_channel = $item->android_channel;
                if($item->android_channel_id != $item->ios_channel_id){
                    $item->ios_channel = $unionService->apiReadChannel(['id'=>$item->ios_channel_id]);
                }
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
            $this->curdService->responseData->android_channel = $unionService->apiReadChannel(['id'=>$this->curdService->responseData->android_channel_id]);
            $this->curdService->responseData->ios_channel = $this->curdService->responseData->android_channel;
            if($this->curdService->responseData->android_channel_id != $this->curdService->responseData->ios_channel_id){
                $this->curdService->responseData->ios_channel = $unionService->apiReadChannel(['id'=>$this->curdService->responseData->ios_channel_id]);
            }
        });
    }




    /**
     * 保存验证规则
     */
    public function saveValidRule(){
        $this->curdService->addField('name')->addValidRule('required');
        $this->curdService->addField('title')->addValidRule('required');
        $this->curdService->addField('android_channel_id')->addValidRule('required');
        $this->curdService->addField('ios_channel_id')->addValidRule('required');
        $this->curdService->addField('html')->addValidRule('required');
        $this->curdService->addField('status')
            ->addValidEnum(StatusEnum::class)
            ->addDefaultValue(StatusEnum::ENABLE);

    }



    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * 创建
     */
    public function create(Request $request){
        $requestData = $request->all();
        $this->curdService->setRequestData($requestData);
        $this->saveValidRule();
        $requestData['admin_id'] = $this->adminUser['admin_user']['id'];

        $adPage = (new AdPageService())->create($requestData);

        return $this->ret($adPage, $adPage);
    }





    /**
     * 更新预处理
     */
    public function updatePrepare(){
        $this->saveValidRule();
        $this->curdService->saveBefore(function(){

            if(!$this->isAdmin()){
                unset($this->curdService->handleData['admin_id']);
            }
        });
    }

}
