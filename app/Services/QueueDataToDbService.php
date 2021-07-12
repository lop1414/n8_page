<?php

namespace App\Services;

use App\Common\Enums\PlatformEnum;
use App\Common\Services\BaseService;
use App\Common\Tools\CustomQueue;
use App\Enums\QueueEnums;
use App\Models\ShowLogModel;
use Jenssegers\Agent\Agent;

class QueueDataToDbService extends BaseService
{


    public function pageShow(){

        $service = new CustomQueue(QueueEnums::PAGE_SHOW);
        $service->setConsumeHook(function ($data){
            $agent = new Agent();
            $agent->setUserAgent($data['ua']);
            $data['platform'] = $agent->isiOS() ? PlatformEnum::IOS : PlatformEnum::ANDROID;
            (new ShowLogModel())->setTableNameWithMonth($data['time'])->create($data);
        });

        $service->consume();

    }


}
