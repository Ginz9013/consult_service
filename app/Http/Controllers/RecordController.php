<?php

namespace App\Http\Controllers;

use App\Http\Requests\Records\CreateDailyRecordRequest;
use App\Models\Daily;

class RecordController extends Controller
{
    // Create Daily Record
    public function createDailyRecord(CreateDailyRecordRequest $request) {

        
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
}
