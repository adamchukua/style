<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'birthdate',
        'gender',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->works->each->delete();
            $user->reviews->each->delete();
            $user->comments->each->delete();
            $user->expert->delete();
        });
    }

    public function getRoleName($user)
    {
        switch ($user->role)
        {
            case Role::AUTHOR:
                return 'author';
            case Role::EXPERT:
                return 'expert';
            case Role::ADMIN:
                return 'admin';
        }
    }

    public function lastnameFirstLetter($user)
    {
        return substr($user->lastname, 0, 1) . '.';
    }

    public function getFullname($user)
    {
        return $user->firstname . ' ' . $user->lastname;
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function expert()
    {
        return $this->hasOne(Expert::class);
    }
}
