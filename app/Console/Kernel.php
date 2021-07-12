<?php

namespace App\Console;

use App\Console\Commands\CreateTableCommand;
use App\Console\Commands\QueueDataToDbCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateTableCommand::class,
        QueueDataToDbCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //创建分表
        $schedule->command('create_table')->cron('0 0 1,15 * *');

        //队列数据数据入库
        $schedule->command("queue_data_to_db --enum=PAGE_SHOW ")->cron('* * * * *');

    }
}
