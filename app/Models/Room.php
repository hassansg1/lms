<?php

namespace App\Models;

use App\Http\Traits\Observable;
use App\Scopes\LocationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Room extends Model
{
    use HasFactory;
    use Observable;
    use NodeTrait;

    protected $table = 'locations';

    public static $type = 'rooms';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope(new LocationScope(self::$type));
    }

    public $rules =
        [
            'rec_id' => 'required | unique:locations,rec_id',
        ];

    protected $appends = ['show_name', 'parentable_type', 'parentable_id'];

    public function getShowNameAttribute()
    {
        return $this->name;
    }

    public function getParentableTypeAttribute()
    {
        return $this->name;
    }
    public function getParentableIdAttribute()
    {
        return '';
    }


    /**
     * @param $item
     * @param $request
     * @return mixed
     */
    public function saveFormData($item, $request, $saveNow = true)
    {
        if (isset($item->id)) $item = Location::find($item->id);
        else $item = new Location();

        if (isset($request->name)) $item->name = $request->name;
        if (isset($request->rec_id)) $item->rec_id = $request->rec_id;
        if (isset($request->parent_id)) $item->parent_id = $request->parent_id;

        if ($saveNow) {
            $item->save();
            $item->type = self::$type;
            $parent = Location::find($request->parent_id);
            $newItem = Location::find($item->id);
            $parent->appendNode($newItem);
            Location::fixtree();
        } else {
            $item->type = self::$type;
            return $item;
        }

        return $item;
    }
}
