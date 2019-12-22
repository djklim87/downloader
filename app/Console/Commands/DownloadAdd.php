<?php

namespace App\Console\Commands;

use App\DownloadRecord;
use App\Jobs\JobDownloading;
use Illuminate\Console\Command;

class DownloadAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:add {url}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add url to download queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $record = new DownloadRecord();
        $record->status = DownloadRecord::STATUS_PENDING;
        $record->url = $this->argument('url');
        $record->save();

        return dispatch(new JobDownloading($record));
    }
}
