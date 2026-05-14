<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use App\Http\Controllers\SkillRequestController;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Booking;


#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
  
    use HasFactory, Notifiable;
    
protected $guarded = [];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

  public function skills()
{
    return $this->hasMany(Skill::class);
}
public function SkillRequests(){
    return $this->hasMany(SkillRequest::class);
}

public function gainrepotation(int $amount){
    $this->increment('repotation', $amount);
}

public function loserepotation(int $amount){
    $this->repotation=max(0, $this->repotation-$amount);
    $this->save();

}

public function mentorBookings(): HasMany
{
    return $this->hasMany(Booking::class, 'mentor_id');
}

public function studentBookings(): HasMany
{
    return $this->hasMany(Booking::class, 'student_id');
}
}
