<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\DownloadController;
use App\Http\Requests\AddToQueue;
use App\Interfaces\Downloader;

class ApiController extends DownloadController
{
    public function __construct()
    {
        $this->middleware('api');
    }

    public function results()
    {
        return response()->json($this->getResults(), 200);
    }

    public function addToQueue(AddToQueue $request)
    {
        $this->addToQueue($request);

        return response()->json([
            'status' => Downloader::STATUS_SUCCESS,
            'message' => 'Url was successfully added to queue'
        ], 422);
    }
}
