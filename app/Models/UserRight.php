<?php

namespace App\Models;

use App\Http\Traits\Observable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRight extends Model
{
    use HasFactory, Observable;

    protected $fillable = [
        'parent_id',
        'right_id',
        'parent_type',
    ];

    public function rights_name(){
        return $this->belongsTo(Right::class, 'right_id', 'id');
    }
}
