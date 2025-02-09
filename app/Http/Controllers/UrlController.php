<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortUrl = Url::generateShortUrl();

        $url = Url::create([
            'original_url' => $request->original_url,
            'short_url' => $shortUrl,
        ]);

        return response()->json([
            'short_url' => url($url->short_url),
            'original_url' => $url->original_url,
        ]);
    }

    public function show($shortUrl)
    {
        $url = Url::where('short_url', $shortUrl)->firstOrFail();

        return redirect($url->original_url);
    }
}
