<?php

namespace Tests\Feature;

use App\Models\Widget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WidgetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 'Index' test
     * [GET] /api/widgets
     *
     * @return void
     */
    public function test_index()
    {
        $totalMocks = 4; // Create this many mock objects
        Widget::factory()->count($totalMocks)->create();

        $response = $this->get('/api/widgets');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                ]
            ],
        ]);
        $response->assertJsonCount($totalMocks, 'data');
    }

    /**
     * 'Show' test
     * [GET] /api/widgets/$id
     *
     * @return void
     */
    public function test_show()
    {
        $widgetMock = Widget::factory()->create();

        $response = $this->get('/api/widgets/' . $widgetMock->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description'
            ]
        ]);

        // Test that model data persisted is correctly retrieved by the API
        $responseData = \json_decode($response->getContent());
        $this->assertSame($widgetMock->name, $responseData->data->name);
    }

    /**
     * 'Show' test in an intentional failure state
     * [GET] /api/widgets/$id
     *
     * @return void
     */
    public function test_show_with_failure()
    {
        $response = $this->get('/api/widgets/123456789'); // Test non-existing record

        $response->assertStatus(404);
    }

    /**
     * 'Store' test
     * [POST] /api/widgets
     *
     * @return void
     */
    public function test_store()
    {
        $mock = Widget::factory()->make();

        $response = $this->post('/api/widgets',[
            'name' => $mock->name,
            'description' => $mock->description,
        ]);
        $responseData = \json_decode($response->getContent());

        $this->assertSame($mock->name, $responseData->data->name);

        $response->assertStatus(201);
    }

    /**
     * 'Store' test
     * [POST] /api/widgets
     *
     * @return void
     */
    public function test_store_with_validation_failure()
    {
        $response = $this->post('/api/widgets',[
            'name' => 'Test Widget 1',
            'description' => random_bytes(200),
        ]);

        $response->assertStatus(400); // Test description validation for max length
    }

    /**
     * 'Store' test
     * [PUT] /api/widgets
     *
     * @return void
     */
    public function test_update()
    {
        $widgetMock = Widget::factory()->create();

        $newName = 'newnametest';
        $response = $this->patch('/api/widgets/' . $widgetMock->id, ['name' => $newName]);

        $response->assertStatus(200);

        // After the PATCH, fetch data from the 'show' endpoint to verify the update was successful
        $response = $this->get('/api/widgets/' . $widgetMock->id);
        $responseData = \json_decode($response->getContent());

        $this->assertSame($newName, $responseData->data->name);
    }

}
