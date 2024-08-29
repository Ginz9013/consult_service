<?php

namespace App\Http\Controllers;

use App\Http\Requests\Records\CreateDailyRecordRequest;
use App\Models\User;
use App\Models\Daily;
use App\Models\Dietary;

class RecordController extends Controller
{
    // Create Daily Record
    public function createDailyRecord(CreateDailyRecordRequest $request) {

        // User ID
        $user = auth()->user();

        $data = $request->all();
        $daily = data_get($data, 'data.daily');

        // Save Daily
        $newDaily = new Daily($daily);
        $user->dailies()->save($newDaily);

        // Save Dietary
        $dietaries = data_get($data, 'data.dietaries');

        if($dietaries) {
            foreach($dietaries as $dietary) {

                if(data_get($dietary, 'images')) unset($dietary['images']);
                
                $newDietary = new Dietary($dietary);
                $newDaily->dietaries()->save($newDietary);
            }
        };

        return response()->json([
            'status' => 200,
            'message' => 'Successfully created.',
            'data' => [
                'daily' => $newDaily,
                'dietaries' => $newDaily->dietaries()->get()
            ]
        ]);
    }
}
