<?php

namespace App\Http\Resources\Records;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DailySearchCellection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'status' => 200,
            'data' => DailySearchResource::collection(
                $this->collection
            ),
        ];
    }
}
