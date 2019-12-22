<?php

namespace Tests\Feature;

use App\DownloadRecord;
use App\Jobs\JobDownloading;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Tests\Unit\CurlServiceTest;

class CliTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdd()
    {
        Queue::fake();
        Artisan::call('download:add', ['url' => CurlServiceTest::URL]);
        Queue::assertPushed(JobDownloading::class);
    }

    public function testResponse()
    {
        factory(DownloadRecord::class)->create();
        $this->artisan('download:results')
            ->assertExitCode(0);
    }
}
