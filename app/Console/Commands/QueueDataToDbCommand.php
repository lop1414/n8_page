<?php

namespace App\Console\Commands;

use App\Common\Console\BaseCommand;
use App\Common\Helpers\Functions;
use App\Enums\QueueEnums;
use App\Services\QueueDataToDbService;

class QueueDataToDbCommand extends BaseCommand
{
    /**
     * 命令行执行命令
     * @var string
     */
    protected $signature = 'queue_data_to_db   {--queue=}';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = '队列数据数据入库';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }



    public function handle(){
        $queue    = $this->option('queue');
        if(is_null($queue)){
            echo 'queue 参数必传';
            return ;
        }

        Functions::hasEnum(QueueEnums::class,$queue);

        $key = 'queue_data_to_db|'.$queue;
        $this->lockRun(function () use ($queue){
            $action = Functions::camelize($queue);
            (new QueueDataToDbService())->$action();
        },$key,60*60*2,['log' => true]);
    }


}
