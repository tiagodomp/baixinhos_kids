<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// use App\Jobs\CrunchReports;
// use App\Jobs\BaixaEstoque;
// use App\Jobs\SyncPedidoML;
use App\Jobs\SyncPedidoS7;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    // protected $commands = [
    //     Commands\RedisSubscribe::class
    // ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('php artisan route:list');
        // $schedule->call(function(){
        //     dispatch(new BaixaEstoque);
        // })->everyFiveMinutes();

        // $schedule->call(function(){
        //     dispatch(new SyncPedidoML);
        // })->everyFiveMinutes();

        $schedule->call(function(){
            dispatch(new SyncPedidoS7);
        });
        // ->everyFiveMinutes();

        // $schedule->call(function(){
        //     dispatch(new SyncPedidoB2W);
        // })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
