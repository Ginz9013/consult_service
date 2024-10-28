<?php

namespace App\Http\Controllers;

use App\Http\Requests\Records\CreateDailyRecordRequest;
use App\Http\Requests\Records\UpdateDailyRecordRequest;
use App\Http\Requests\Records\SearchDailyRecordRequest;
use App\Http\Requests\Records\CreateDietaryRecordRequest;
use App\Http\Resources\Record\DailyRecordSearchCellection;
use App\Service\RecordService;

// use Illuminate\Http\Request;

class RecordController extends Controller
{
    protected $recordService;

    public function __construct(RecordService $recordService) {
        $this->recordService = $recordService;
    }

    // Create Daily Record
    public function createDailyRecord(CreateDailyRecordRequest $request) {

        // Request Data
        $validatedData = $request->validated();
        
        $newDaily = $this->recordService->createDailyRecord($validatedData);

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
    public function updateDailyRecord(UpdateDailyRecordRequest $request, $date) {

        // Request Data
        $validatedData = $request->validated();

        $result = $this->recordService->updateDailyRecord($validatedData, $date);

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
    public function SearchDailyRecords (SearchDailyRecordRequest $request) {
        
        // Request Query String
        $params = $request->validated();
        
        $start_date = $params['start_date'];
        $end_date = $params['end_date'];

        // Dailies
        $dailies = $this->recordService->searchDailyRecord($start_date, $end_date);

        return new DailyRecordSearchCellection($dailies);
    }

    // Create Dietary Record
    public function CreateDietaryRecord(CreateDietaryRecordRequest $request) {

        return response()->json([
            'status' => 200,
            'message' => 'Create successfully!',
            'data' => $this->recordService->createDietaryRecord($request)
        ]);
    }
}
