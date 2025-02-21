<?php

namespace App\Http\Controllers;

use App\Http\Requests\Records\CreateDailyRequest;
use App\Http\Requests\Records\UpdateDailyRequest;
use App\Http\Requests\Records\SearchDailyRequest;
use App\Http\Requests\Records\CreateDietRequest;
use App\Http\Requests\Records\UpdateDietRequest;
use App\Http\Resources\Records\DailySearchCellection;
use App\Service\RecordService;
use App\Http\Response\ApiResponse;

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
            return (new ApiResponse(
                404,
                '當日紀錄不存在'
            ))->toJson();
        }

        return (new ApiResponse(
            200,
            '更新成功!'
        ))->toJson();
    }

    // Search Daily Record
    public function searchDaily(SearchDailyRequest $date) {
        $formatted_date = data_get($date->validated(), 'date');

        // Dailies
        $dailies = $this->recordService->searchDaily($formatted_date);

        return new DailySearchCellection($dailies);
    }

    // Create Dietary Record
    public function createDiet(CreateDietRequest $request) {

        return (new ApiResponse(
            200,
            '新增成功!',
            $this->recordService->createDiet($request)
        ))->toJson();
    }

    // Update Dietary Record
    public function updateDiet(UpdateDietRequest $request, $id) {

        return $this->recordService->updateDiet($request, $id);
    }
}
