<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Swap extends Model
{
    protected $guarded = [];

    public function  sender(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class,'receiver_id');
    }
    public function senderSkill(){
        return $this->belongsTo(Skill::class,'sender_skill_id');
    }
    public function receiverSkill(){
        return $this->belongsTo(Skill::class,'receiver_skill_id');
    }


    // Public function sender1(){
    //     return $this->belongsTo(User::class,'sender_id');
    // }
    // public function reciver1(){
    //     return $this->belongsTo(User::class,'reciver_id');

    // }

    //  public function senderskill1(){
    //     return $this->belongsTo(User::class,'sender_skill_id');
    //  }
    //  public function reciverSkill(){
    //     return $this->belongsTo(User::class,'revicer_skills_id');

    //  }

}

