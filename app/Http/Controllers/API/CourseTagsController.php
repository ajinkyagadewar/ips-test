<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CourseTagsRepositoryInterface;

class CourseTagsController extends Controller
{
    /**
     * @var App\Repositories\CourseTagsRepository
     */
    public $courseTagsRepository;
    
    public function __construct(CourseTagsRepositoryInterface $courseTagsRespoitory)
    {
        $this->courseTagsRepository = $courseTagsRespoitory;
    }

    /**
     * This function will create the course tags once and store in the database.
     * Can be accessed using HOST_URL/api/saveAllTags
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAllTags(){
        try {
            $courseTags = $this->courseTagsRepository->createOrUpdateTags();
            return response()->json([
                'success' => true,
                'message' => 'Tags have been created successfully.',
                'data' => $courseTags
            ],200);
        } catch (\Exception $e) {
            Log::error((string) $e);
            return response()->json([
               'success' => false,
               'message' => 'Tags creation has halted due to an error.'
            ],500);
        }
    }
}