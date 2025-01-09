<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['original_url', 'short_url'];

    public static function generateShortUrl()
    {
        do {
            $shortUrl = Str::random(6);
        } while (self::where('short_url', $shortUrl)->exists());

        return $shortUrl;
    }
}
