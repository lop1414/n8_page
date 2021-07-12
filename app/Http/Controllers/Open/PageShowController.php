<?php


namespace App\Http\Controllers\Open;


use App\Enums\PageTypeEnums;
use App\Enums\QueueEnums;
use App\Common\Services\DataToQueueService;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class PageShowController extends BaseController
{



    /**
     * @param Request $request
     * @return mixed
     */
    public function adPage(Request $request){
        $request->offsetSet('page_type',PageTypeEnums::AD);
        $this->pushData($request);
        return $this->success();
    }




    protected function pushData($request){
        $requestData = $request->all();

        // 必传参数
        $this->validRule($requestData,[
            'n8_page_id'   =>  'required'
        ]);
        $requestData['time'] = date('Y-m-d H:i:s',TIMESTAMP);
        $requestData['link'] = base64_decode($requestData['link']);
        $requestData['ip'] = $request->getClientIp();
        $requestData['ua'] = (new Agent())->getUserAgent();

        $service = new DataToQueueService(QueueEnums::PAGE_SHOW);
        $service->push($requestData);
    }

}
