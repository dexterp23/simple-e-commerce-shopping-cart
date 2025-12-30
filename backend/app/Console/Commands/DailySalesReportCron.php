<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DailySalesReportCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-sales-report-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app('DailySalesReportService')->handle();
        return Command::SUCCESS;
    }
}
