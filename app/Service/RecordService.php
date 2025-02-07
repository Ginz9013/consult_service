<?php

namespace App\Service;

use App\Models\Daily;
use App\Models\Diet;
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
    $date = Carbon::createFromFormat('Y-m-d H:i', data_get($dietary_data, 'date_time'))->toDateString();
    $file_path = 'user/' . $user_id . '_' . $user_name . '/' . $date;

    $imageKeys = ['image1' => 'img_url_1', 'image2' => 'img_url_2', 'image3' => 'img_url_3'];

    foreach ($imageKeys as $key => $url_name) {

        if ($request->hasFile($key)) {
            $file = $request->file($key);

            $path = $file->store($file_path , 's3');

            $url = Storage::url($path);

            $dietary_data[$url_name] = $url;
        }
    }

    // 刪除 date_time 並且加入 time 欄位
    $dietary_data['time'] = Carbon::createFromFormat('Y-m-d H:i', data_get($dietary_data, 'date_time'))->format('H:i');
    unset($dietary_data['date_time']);

    $new_diet = new Diet($dietary_data);

    DB::transaction(function() use ($user, $new_diet, $date) {
      $daily = $user->dailies()->firstOrCreate(['date' => $date]);
      $daily->diet()->save($new_diet);
    });

    return $new_diet;
  }

  public function updateDietaryRecord($request) {
    $date = Carbon::createFromFormat('Y-m-d H:i', $request->date_time);

    // Get User
    $user = auth()->user();

    // Get Exist Record
    $dietaryRecord = $user->dailies()->where('date', $date->format('Y-m-d'))->first()
      ?->dietaries()->where('time', $date->format('H:i'))->first();

    if(is_null($dietaryRecord)) {
      echo 'no';
      return false;
    }

    return $dietaryRecord->toArray();
  }
}