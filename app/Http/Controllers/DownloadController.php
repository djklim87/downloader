<?php

namespace App\Http\Controllers;

use App\DownloadRecord;
use App\Http\Requests\AddToQueue;
use App\Jobs\JobDownloading;

class DownloadController extends Controller
{
    protected function getResults(){
        return DownloadRecord::select(['id','filename', 'url', 'status'])->get();
    }

    protected function addToQueue(AddToQueue $request){
        $record = new DownloadRecord();
        $record->status = DownloadRecord::STATUS_PENDING;
        $record->url = $request->get('url');
        $record->save();

        dispatch(new JobDownloading($record));
    }
}
