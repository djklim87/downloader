<?php

namespace App\Interfaces;


interface Downloader
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    /*
     * By priority we'll use for downloading wget, cause it's more quickly solution.
     * But if we don't have ability for use that, we can use curl by extending this interface
     */
    public function download($url, $pathToSave);

    public function getFilename();
}
