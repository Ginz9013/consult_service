<?php

namespace App\Http\Controllers;

use App\Http\Requests\Records\CreateDailyRequest;
use App\Http\Requests\Records\UpdateDailyRequest;
use App\Http\Requests\Records\SearchDailyRequest;
use App\Http\Requests\Records\CreateDietRequest;
use App\Http\Requests\Records\UpdateDietRequest;
use App\Http\Resources\Records\DailySearchCellection;
use App\Service\RecordService;

class RecordController extends Controller
{
    protected $recordService;

    public function __construct(RecordService $recordService) {
        $this->recordService = $recordService;
    }

    // Create Daily Record
    public function createDaily(CreateDailyRequest $request) {

        // Request Data
        $validatedData = $request->validated();
        
        $newDaily = $this->recordService->createDaily($validatedData);

        if(is_null($newDaily)) {
            return response()->json([
                'status' => 500,
                'message' => 'Create failed.'
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Successfully created.',
            'data' => [
                'daily' => $newDaily
            ]
        ]);
    }

    // Update Daily Record
    public function updateDaily(UpdateDailyRequest $request, $date) {

        // Request Data
        $validatedData = $request->validated();

        $result = $this->recordService->updateDaily($validatedData, $date);

        if(!$result) {
            return response()->json([
                'status' => 404,
                'message' => 'Daily record not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $validatedData,
        ]);
    }

    // Search Daily Record
    public function searchDaily(SearchDailyRequest $request) {
        
        // Request Query String
        $params = $request->validated();
        
        $start_date = $params['start_date'];
        $end_date = $params['end_date'];

        // Dailies
        $dailies = $this->recordService->searchDaily($start_date, $end_date);

        return new DailySearchCellection($dailies);
    }

    // Create Dietary Record
    public function createDiet(CreateDietRequest $request) {

        return response()->json([
            'status' => 200,
            'message' => 'Create successfully!',
            'data' => $this->recordService->createDiet($request)
        ]);
    }

    // Update Dietary Record
    public function updateDiet(UpdateDietRequest $request) {
        return $this->recordService->updateDiet($request);
    }
}
