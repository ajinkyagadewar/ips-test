<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\CourseTag;
use App\Http\Helpers\InfusionsoftHelper;

class CourseTagsTest extends TestCase
{   
    /**
     * @var Array CourseTags
     */
    public $courseTags;
    
    public function setUp()
    {
        parent::setUp();
        $this->courseTags = factory(CourseTag::class, 3)->make();
    }
    
    /**
     * Test to ensure that the API endpoint for saving all the tags is working 
     * as expected.
     * Also, it checks whether the test database reflects appropriate entries
     */
    
    public function testSaveAllTags() {
        $infusionSoftHelper = $this->mock(InfusionsoftHelper::class);
        $infusionSoftHelper->shouldReceive('getAllTags')
                ->andReturn($this->courseTags);

        $response = $this->get('api/saveAllTags');
        
        // Simple test to verify working of API Endpoint
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => $this->courseTags->toArray(),
                'message' => 'Tags created successfully.'
            ]);
        
        
        // This assertion verifies the database entries vs factory creations
        $this->assertDatabaseHas('course_tags', [
            'name' => $this->courseTags[0]['name'],
            'name' => $this->courseTags[1]['name'],
            'name' => $this->courseTags[2]['name'],
        ]);
    }
}
