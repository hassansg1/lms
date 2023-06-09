<?php

namespace App\Models;

use App\Http\Traits\Observable;
use App\Http\Traits\ParentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory;
    use Observable;

    protected $guarded = [];

    public $rules =
        [
        ];

    /**
     * @param $item
     * @param $request
     * @return mixed
     */
    public function saveFormData($item, $request)
    {
        if (isset($request->name)) $item->name = $request->name;
        $applicable = isset($request->applicable) && $request->applicable == 'on' ? 1 : 0;
        $item->applicable = 1;

        $item->save();
        if (isset($request->gap_rating) && is_array($request->gap_rating)) {
            foreach ($request->gap_rating as $value => $label) {
                GapRating::updateOrCreate(
                    [
                        "standard_id" => $item->id,
                        "value" => $value,
                    ],
                    [
                        "name" => $label
                    ]
                );
            }
        }
        return $item;
    }
}
