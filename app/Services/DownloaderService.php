<?php

namespace App\Services;


use App\DownloadRecord;
use App\Interfaces\Downloader;
use Illuminate\Support\Facades\Storage;

class DownloaderService
{
    const DOWNLOAD_STORAGE = 'storage';

    private $downloader;
    private $storagePath;

    public function __construct(Downloader $downloader)
    {
        $this->storagePath = storage_path(self::DOWNLOAD_STORAGE . DIRECTORY_SEPARATOR);
        $this->downloader = $downloader;
    }

    public function process(DownloadRecord $downloadRecord)
    {
        if (!empty($downloadRecord)) {

            $downloadRecord->status = DownloadRecord::STATUS_DOWNLOADING;
            $downloadRecord->save();

            $this->downloader->download($downloadRecord->url, $this->storagePath);
            $downloadRecord->filename = $this->downloader->getFilename();

            if (Storage::disk(self::DOWNLOAD_STORAGE)->exists($downloadRecord->filename)) {
                $downloadRecord->status = DownloadRecord::STATUS_COMPLETE;
                $downloadRecord->save();
            } else {
                $downloadRecord->status = DownloadRecord::STATUS_ERROR;
                $downloadRecord->save();
            }

        }
    }
}
