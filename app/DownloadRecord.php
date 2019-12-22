<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadRecord extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_DOWNLOADING = 'downloading';
    const STATUS_COMPLETE = 'complete';
    const STATUS_CHECKING = 'checking';
    const STATUS_ERROR = 'error';

    protected $table = 'download_queues';

}
