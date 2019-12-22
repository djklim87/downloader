<?php

use App\DownloadRecord;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_queues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', [
                DownloadRecord::STATUS_PENDING,
                DownloadRecord::STATUS_DOWNLOADING,
                DownloadRecord::STATUS_COMPLETE,
                DownloadRecord::STATUS_CHECKING,
                DownloadRecord::STATUS_ERROR
            ])->default('pending');
            $table->text('filename')->nullable();
            $table->text('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('download_queues');
    }
}
