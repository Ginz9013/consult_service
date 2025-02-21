<?php

namespace App\Service;

use App\Models\Daily;
use App\Models\Diet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Records\CreateDietRequest;
use App\Http\Requests\Records\UpdateDietRequest;

use Illuminate\Support\Facades\Log;

class RecordService
{

  const IMAGE_KEYS = ['image1' => 'img_url_1', 'image2' => 'img_url_2', 'image3' => 'img_url_3'];

  public function createDaily(array $request) {
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

  public function updateDaily(array $request, string $date): bool {
    
    // Get User
    $user = auth()->user();

    // Get Exist Record
    $dailyRecord = $user->dailies()->where('date', $date)->first();

    if(is_null($dailyRecord)) return false;

    // Update Daily Record
    return $dailyRecord->update($request);
  }

  public function searchDaily(string $date) {
    // User
    $user = auth()->user();

    // Dailies
    return $user
      ->dailies()
      ->where('date', $date)
      ->with('diets')
      ->get();
  }

  public function createDiet(CreateDietRequest $request) {

    $dietary_data = $request->validated();

    $user = auth()->user();
    $user_id = $user->id;
    $user_name = $user->name;
    $date = Carbon::createFromFormat('Y-m-d H:i', data_get($dietary_data, 'date_time'))->toDateString();
    $time = Carbon::createFromFormat('Y-m-d H:i', data_get($dietary_data, 'date_time'))->format('H:i');

    $file_path = "user/{$user_id}_{$user_name}/{$date}/{$time}";

    foreach (self::IMAGE_KEYS as $key => $url_name) {

        if ($request->hasFile($key)) {
            $file = $request->file($key);
            $filename = "{$key}.jpg";

            $path = $file->storeAs($file_path, $filename, 's3');
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
      $daily->diets()->save($new_diet);
    });

    return $new_diet;
  }

  public function updateDiet(UpdateDietRequest $request, string $id) {
    $date = data_get($request->validated(), 'date');

    // Get User
    $user = auth()->user();

    // Get Exist Diet Record
    $diet = Diet::whereHas('daily', function ($q) use ($user, $date) {
        $q->where('date', $date)
          ->where('user_id', $user->id);
    })
    ->firstWhere('id', $id);

    if (is_null($diet)) {
      return false;
    }

    $upload_diet = $request->validated();
    $exist_time = Carbon::createFromFormat('H:i:s', $diet->time)->format('H:i');
    $update_time = data_get($upload_diet, 'time');
    $is_same_time = $exist_time === $update_time;
    if ($is_same_time) {
      return 'true';
    } else {
      return 'false';
    }
    return $is_same_time;
    // Update Image from S3
    $is_re_upload = filter_var($request->re_upload, FILTER_VALIDATE_BOOLEAN);

    if ($is_re_upload) {
        $time = Carbon::createFromFormat('H:i:s', $diet->time)->format('H:i');
        $file_path = "user/{$user_id}_{$user_name}/{$date}/{$time}";

        foreach (self::IMAGE_KEYS as $key => $url_name) {

            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $filename = "{$key}.jpg";

                $path = $file->storeAs($file_path, $filename, 's3');
                $url = Storage::url($path);

                $dietary_data[$url_name] = $url;
            } else {

            }
        }
    } else {
      return 'false';
    }
    



    return $diet->toArray();
  }
}