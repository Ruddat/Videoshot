<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->input('query')) {
            $searchTerm = $request->input('query');

            $videos = Video::query()
                ->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('description', 'LIKE', "%{$searchTerm}%");
                })
                ->orWhereHas('channel', function ($channelQuery) use ($searchTerm) {
                    $channelQuery->where('name', 'LIKE', "%{$searchTerm}%");
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return view('search', compact('videos'));
        } else {
            $videos = [];
        }

        return view('search', compact('videos'));
    }
}
