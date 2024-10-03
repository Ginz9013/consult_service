<?php

namespace App\Http\Resources\Record;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DailyRecordSearchCellection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'status' => 200,
            'data' => DailyRecordSearchResource::collection(
                $this->collection
            ),
        ];
    }
}
