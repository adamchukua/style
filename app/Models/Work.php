<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'type',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($work) {
            $work->comments->each->delete();
            $work->reviews->each->delete();

            foreach ($work->attachments as $attachment) {
                $attachment->delete();

                Storage::disk('public')->delete($attachment->path);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageMark($work)
    {
        $complexity_sum = $work->reviews->sum('complexity');
        $creativity_sum = $work->reviews->sum('creativity');
        $innovativeness_sum = $work->reviews->sum('innovativeness');

        return round(($complexity_sum + $creativity_sum + $innovativeness_sum) / 3, 1);
    }
}
