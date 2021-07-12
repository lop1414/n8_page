<?php


namespace App\Http\Controllers\Open;


use App\Common\Tools\CustomException;
use App\Enums\PageTypeEnums;
use App\Enums\QueueEnums;
use App\Common\Services\DataToQueueService;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class PageShowController extends BaseController
{


    /**
     *
     * @param Request $request
     * @return mixed
     * @throws CustomException
     */
    public function adPage(Request $request){
        $requestData = $request->all();
        // 必传参数
        $this->validRule($requestData,[
            'n8_page_id'   =>  'required'
        ]);
        $requestData['time'] = date('Y-m-d H:i:s',TIMESTAMP);
        $requestData['ip'] = $request->getClientIp();
        $requestData['ua'] = (new Agent())->getUserAgent();
        $requestData['link'] = base64_decode($request['link']);
        $requestData['page_type'] = PageTypeEnums::AD;
        $service = new DataToQueueService(QueueEnums::PAGE_SHOW);
        $service->push($requestData);
        return $this->success();
    }

}
