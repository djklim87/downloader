<?php

namespace Tests\Unit;

use App\Services\CurlService;
use App\Services\DownloaderService;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CurlServiceTest extends TestCase
{
    const URL = 'https://vk.com/images/login/ru/reg_iphone_ru.png';
    const WRONG_URL = 'https://vk.com';
    const FILENAME = 'reg_iphone_ru.png';

    /**
     * A basic unit test example.
     *
     * @return void
     * @throws \Exception
     */
    public function testDownload()
    {
        $curlService = new CurlService();
        $download = $curlService->download(self::URL,
            storage_path(DownloaderService::DOWNLOAD_STORAGE . DIRECTORY_SEPARATOR));
        $this->assertEquals(CurlService::STATUS_SUCCESS, $download);
        $fileName = $curlService->getFileName();

        $this->assertEquals(self::FILENAME,  $fileName);
    }

    public function testStoring(){
        $exists = Storage::disk(DownloaderService::DOWNLOAD_STORAGE)->exists(self::FILENAME);
        self::assertTrue($exists);
        Storage::disk(DownloaderService::DOWNLOAD_STORAGE)->delete(self::FILENAME);
    }

    public function testUnreadableFilename(){
        $this->expectException(\Exception::class);

        $curlService = new CurlService();
        $curlService->download(self::WRONG_URL,
            storage_path(DownloaderService::DOWNLOAD_STORAGE . DIRECTORY_SEPARATOR));
    }
}
