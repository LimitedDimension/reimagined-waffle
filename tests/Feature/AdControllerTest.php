<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdControllerTest extends TestCase
{
    public function testListApiResponse()
    {
        $response = $this->get('/api/v1/ad-list/items');

        $response->assertOk()->assertJsonStructure([
            'success',
            'data',
            'timestamp',
        ]);

        $responseData = json_decode($response->getContent());

        $this->assertIsArray($responseData->data);
        $this->assertIsBool($responseData->success);
    }
}
