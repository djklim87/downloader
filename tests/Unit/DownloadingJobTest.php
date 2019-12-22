<?php

namespace Tests\Unit;

use App\DownloadRecord;
use App\Jobs\JobDownloading;
use App\Services\CurlService;
use App\Services\DownloaderService;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownloadingJobTest extends TestCase
{
    use RefreshDatabase;

    public function testJob()
    {
        $records = factory(DownloadRecord::class)->create();
        $job = new JobDownloading($records);
        $curl = new CurlService();
        $downloaderService = new DownloaderService($curl);
        $job->handle($downloaderService);
        $this->assertTrue($records->status == DownloadRecord::STATUS_COMPLETE);

        $job->failed(new \Exception());
        $this->assertTrue($records->status == DownloadRecord::STATUS_ERROR);
    }
}
