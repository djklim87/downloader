<?php

namespace App\Console\Commands;

use App\DownloadRecord;
use Illuminate\Console\Command;

class DownloadResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:results';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show download results';

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
        $downloads = DownloadRecord::all();

        $result = "Name \t url \t status \t\n";
        foreach ($downloads as $download) {
            $result .= !empty($download->filename) ? $download->filename : '-' .
                "\t$download->url\t$download->status\n";
        }

        $this->info($result);
    }
}
