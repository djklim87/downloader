<?php

namespace App\Jobs;

use App\DownloadRecord;
use App\Services\DownloaderService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class JobDownloading implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    protected $record;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DownloadRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Execute the job.
     *
     * @param DownloaderService $service
     * @return void
     */
    public function handle(DownloaderService $service)
    {
        $service->process($this->record);
    }

    /**
     * The job failed to process.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        $this->record->status = DownloadRecord::STATUS_ERROR;
        $this->record->save();
    }
}
