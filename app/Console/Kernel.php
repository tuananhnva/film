<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Modules\Crawl\Console\CrawlAllData;
use Modules\Crawl\Console\CrawlDaily;
use Modules\Crawl\Console\CrawlReset;
use Modules\Crawl\Console\CrawlLink;
use Modules\Crawl\Console\CrawlContent;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CrawlReset::class,
        CrawlAllData::class,
        CrawlDaily::class,
        CrawlLink::class,
        CrawlContent::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
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
