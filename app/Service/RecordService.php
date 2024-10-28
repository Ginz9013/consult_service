<?php

namespace App\Service;

use App\Models\Daily;
use App\Models\Dietary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Records\CreateDietaryRecordRequest;

use Illuminate\Support\Facades\Log;

class RecordService
{
  public function createDailyRecord(array $request) {
    // Create Daily
    $newDaily = new Daily($request);

    // Save Daily to User
    $user = auth()->user();

    try {
      $user->dailies()->save($newDaily);
      return $newDaily;

    } catch(\Exception $e) {
      Log::error('Failed to save daily record', [
        'error' => $e->getMessage(),      // 異常的簡要信息
        'trace' => $e->getTraceAsString(), // 異常的詳細堆棧追蹤
        'user_id' => $user->id,           // 相關的使用者ID
      ]);

      return null;
    }
  }

  public function updateDailyRecord(array $request, string $date): bool {
    
    // Get User
    $user = auth()->user();

    // Get Exist Record
    $dailyRecord = $user->dailies()->where('date', $date)->first();

    if(is_null($dailyRecord)) return false;

    // Update Daily Record
    return $dailyRecord->update($request);
  }

  public function searchDailyRecord(string $start_date, string $end_date) {
    // User
    $user = auth()->user();

    // Dailies
    return $user->dailies()->whereBetween('date', [$start_date, $end_date])->get();
  }

  public function createDietaryRecord(CreateDietaryRecordRequest $request) {

    $dietary_data = $request->validated();

    $user = auth()->user();
    $user_id = $user->id;
    $user_name = $user->name;
    $today = Carbon::now()->format('Y-m-d');
    $file_path = 'user/' . $user_id . '_' . $user_name . '/' . $today;

    $imageKeys = ['image1' => 'img_url_1', 'image2' => 'img_url_2', 'image3' => 'img_url_3'];

    foreach ($imageKeys as $key => $url_name) {

        if ($request->hasFile($key)) {
            $file = $request->file($key);

            $path = $file->store($file_path , 's3'); 

            $url = Storage::url($path);

            $dietary_data[$url_name] = $url;
        }
    }

    $new_dietary = new Dietary($dietary_data);

    DB::transaction(function() use ($user, $new_dietary, $today) {
      $daily = $user->dailies()->firstOrCreate(['date' => $today]);
      $daily->dietaries()->save($new_dietary);
    });

    return $new_dietary;
  }
}