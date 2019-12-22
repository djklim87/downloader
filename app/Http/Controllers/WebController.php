<?php

namespace App\Http\Controllers;

use App\DownloadRecord;
use App\Http\Requests\AddToQueue;
use App\Services\DownloaderService;
use Illuminate\Support\Facades\Storage;

class WebController extends DownloadController
{
    public function results()
    {
        return view('results')->with(['downloads' => $this->getResults()]);
    }

    public function add()
    {
        return view('add');
    }

    public function enqueue(AddToQueue $request)
    {
        $this->addToQueue($request);
        return redirect('/');
    }

    public function download($id)
    {
        $record = DownloadRecord::findOrFail($id);
        $filePath = storage_path(DownloaderService::DOWNLOAD_STORAGE . DIRECTORY_SEPARATOR . $record->filename);
        if (Storage::disk(DownloaderService::DOWNLOAD_STORAGE)->exists($record->filename)){
            return response()->download($filePath);
        }
        return abort(404);
    }
}
