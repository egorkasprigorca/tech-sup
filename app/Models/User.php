<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ticket_time'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'ticket_time' => 'datetime'
    ];

    protected $attributes = [
        'role' => 'user'
    ];

    public function isManager(): bool
    {
        return $this->getAttribute('role') === 'manager';
    }

    public function setTicketTime()
    {
        $this->ticket_time = Carbon::now()->toDateTimeString();
        $this->save();
    }

    public function isPassedDay(): bool
    {
        $currentTime = Carbon::now()->toDateTimeString();

        $diff = $this->ticket_time->diffInHours($currentTime);

        return $diff >= 24;
    }
}
