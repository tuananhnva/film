<?php

namespace Modules\Crawl\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Crawl\CoreCrawl\Crawl;

class CrawlAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'crawl:alldata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Begin crawl data from list domain';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Xu ly thong tin crawl bat dau tu day
     */
    public function handle()
    {
        Crawl::getDomainLinkDetail();
        Crawl::getContentLinkDetail();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            // ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
