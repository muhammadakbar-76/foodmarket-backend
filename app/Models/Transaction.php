<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "food_id", "user_id", "quantity", "total", "status", "payment_url"
    ];

    public function getCreatedAtAttribute($value){ //accesor, pengkonvert timestamp ke unix timestamp
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function food(){
        return $this->belongsTo(Food::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
