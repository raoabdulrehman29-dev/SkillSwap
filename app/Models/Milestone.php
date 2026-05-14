<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Milestone extends Model
{
  protected $guarded = [];

  protected function casts(): array
  {
    return [
      'is_completed' => 'boolean',
      'completed_at' => 'datetime',
    ];
  }

  public function booking(): BelongsTo
  {
    return $this->belongsTo(Booking::class);
  }
}
