<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

 
   public function mentor():BelongsTo
   {
    return $this->belongsTo(User::class, 'mentor_id');
   }

   public function student():BelongsTo
   {
    return $this->belongsTo(User::class, 'student_id');
   }
   public function skill():BelongsTo
   {
    return $this->belongsTo(Skill::class);
   }

   public function milestones(): HasMany
   {
    return $this->hasMany(Milestone::class);
   }
}
