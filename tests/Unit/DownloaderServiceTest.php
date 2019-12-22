<?php

namespace Tests\Unit;

use App\DownloadRecord;
use App\Services\CurlService;
use App\Services\DownloaderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DownloaderServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @param DownloaderService $downloaderService
     * @return void
     * @throws \Exception
     */
    public function testDownloader()
    {
        $curl = new CurlService();
        $downloaderService = new DownloaderService($curl);
        $record = new DownloadRecord();
        $record->url = CurlServiceTest::URL;
        $record->save();

        $downloaderService->process($record);

        $this->assertEquals(DownloadRecord::STATUS_COMPLETE, $record->status);


        $record = new DownloadRecord();
        $record->url = CurlServiceTest::WRONG_URL;
        $record->save();

        $this->expectException(\Exception::class);

        $downloaderService->process($record);
        $this->assertEquals(DownloadRecord::STATUS_DOWNLOADING, $record->status);
    }
}
