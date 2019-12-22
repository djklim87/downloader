<?php

namespace Tests\Feature;

use App\DownloadRecord;
use App\Jobs\JobDownloading;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\CurlServiceTest;

class WebTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;


    public function testEnqueue()
    {
        Queue::fake();

        $response = $this->post('/enqueue', ['url' => CurlServiceTest::URL]);
        $response->assertStatus(302);

        Queue::assertPushed(JobDownloading::class);
    }

    public function testResponse()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testAdd()
    {
        $response = $this->get('/add');
        $response->assertStatus(200);
    }

    public function testDownload()
    {
        $record = factory(DownloadRecord::class)->create(['filename'=>'test.png']);
        $response = $this->get('/download/'.$record->id);
        $response->assertStatus(404);
    }
}
