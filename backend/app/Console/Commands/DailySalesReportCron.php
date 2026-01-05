<?php

namespace App\Console\Commands;

use App\Services\Notifications\DailySalesReportServiceInterface;
use Illuminate\Console\Command;

class DailySalesReportCron extends Command
{
    protected DailySalesReportServiceInterface $dailySalesReportService;

    public function __construct(
        DailySalesReportServiceInterface $dailySalesReportService,
    )
    {
        parent::__construct();
        $this->dailySalesReportService = $dailySalesReportService;
    }

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
        $this->dailySalesReportService->handle();
        return Command::SUCCESS;
    }
}
