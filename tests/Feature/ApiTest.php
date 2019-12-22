<?php

namespace Tests\Feature;

use App\DownloadRecord;
use App\Jobs\JobDownloading;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Tests\Unit\CurlServiceTest;

class ApiTest extends TestCase
{
    use RefreshDatabase;


    public function testResults()
    {
        $records = factory(DownloadRecord::class, 10)->create();
        $recordsIds = $records->pluck('id')->toArray();
        $response = $this->getJson('/api/download/results');

        $content = $response->content();

        $this->assertJson($content);

        $content = json_decode($content);
        $requestedRecordsIds = collect($content)->pluck('id');
        $this->assertTrue(count($recordsIds) === count($requestedRecordsIds));

        foreach ($requestedRecordsIds as $id) {
            $this->assertTrue(in_array($id, $recordsIds));
        }

        $response->assertStatus(200);
    }

    public function testAddToQueue()
    {
        Queue::fake();

        $response = $this->post('/api/download/add', ['url' => CurlServiceTest::URL]);
        $response->assertStatus(200);

        Queue::assertPushed(JobDownloading::class);
    }
}
