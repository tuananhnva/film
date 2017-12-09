<?php

namespace Modules\Crawl\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Crawl\CoreCrawl\Crawl;

class CrawlDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'crawl:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl cac bai viet trong bang crawl_domain_link';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // lấy dữ liệu hàng ngày thông qua 2 method lấy link bài viết và lấy nội dung của từng bài viết đó
        Crawl::getDomainLinkDetail();
        Crawl::getContentLinkDetail(500);
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
