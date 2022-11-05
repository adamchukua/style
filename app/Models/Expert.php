<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($expert) {
            $expert->reviews->each->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
