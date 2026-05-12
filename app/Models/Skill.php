<?php

namespace App\Models;

use App\Http\Controllers\SkillRequestController;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    public function request(){
        return $this->hasMany(SkillRequest::class);
    }
}

