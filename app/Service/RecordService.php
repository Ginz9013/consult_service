<?php

namespace App\Service;

use App\Models\Daily;
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
}