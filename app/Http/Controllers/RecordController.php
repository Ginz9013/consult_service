<?php

namespace App\Http\Controllers;

use App\Http\Requests\Records\CreateDailyRecordRequest;
use App\Http\Requests\Records\UpdateDailyRecordRequest;
use App\Http\Requests\Records\SearchDailyRecordRequest;
use App\Models\Daily;
// use Illuminate\Http\Request;

class RecordController extends Controller
{
    // Create Daily Record
    public function createDailyRecord(CreateDailyRecordRequest $request) {

        // Request Data
        $validatedData = $request->validated();
        
        // Create Daily
        $newDaily = new Daily($validatedData);

        // Save Daily to User
        $user = auth()->user();
        $user->dailies()->save($newDaily);

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

        $user = auth()->user();
        $dailyRecord = $user->dailies()->where('date', $date)->first();

        if($dailyRecord->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Daily record not found',
            ], 404);
        }

        // Update Daily Record
        $dailyRecord->update($validatedData);

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

        // User
        $user = auth()->user();

        // Dailies
        $dailies = $user->dailies()->whereBetween('date', [$start_date, $end_date])->get();

        if($dailies->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Daily record not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $dailies,
        ]);
    }
}
