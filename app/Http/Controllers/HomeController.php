<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\View;
use App\Models\Video;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Retrieve recently viewed videos for the authenticated user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRecentlyViewedVideos()
    {
        $recentlyViewedVideos = auth()->user()->views()
            ->with('video')
            ->latest()
            ->get();

        $viewedVideoIds = [];

        $uniqueVideos = $recentlyViewedVideos->filter(function ($view) use (&$viewedVideoIds) {
            if (!isset($viewedVideoIds[$view->video->id])) {
                $viewedVideoIds[$view->video->id] = true;
                return true;
            }
            return false;
        });

        return $uniqueVideos;
    }

    /**
     * Display the user's history of viewed videos.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function history()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $recentlyViewedVideos = $this->getRecentlyViewedVideos();

            $paginatedVideos = $user->views()
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('pages.history', compact('recentlyViewedVideos', 'paginatedVideos'));
        } else {
            // Logic if the user is not logged in
        }
    }

    /**
     * Remove a specific video from the user's history.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeVideo($id)
    {
        $videoId = $id;
        View::where('video_id', $videoId)->delete();
        return redirect()->back()->with('success', 'Video removed successfully');
    }

    /**
     * Display the user's account page with video and channel information.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function account()
    {
        $videoCount = Video::count();
        $channelCount = auth()->user()->channel()->count();
        $channels = Auth::user()->channel()->with('videos')->get();

        $videos = $channels->flatMap(function ($channel) {
            return $channel->videos;
        })->sortByDesc('created_at');

        // Pagination variables
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 8;
        $currentItems = $videos->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Paginator instance
        $videos = new LengthAwarePaginator($currentItems, $videos->count(), $perPage, $currentPage);
        $videos->withPath('/account');
        $videos->withQueryString();

        // Get the date three days ago to consider videos as "new"
        $thresholdDate = now()->subDays(3);

        // Count the number of new videos for the user
        $newVideoCount = auth()->user()->views()
            ->whereHas('video', function ($query) use ($thresholdDate) {
                $query->where('created_at', '>', $thresholdDate);
            })
            ->count();

        return view('pages.account', compact('channelCount', 'videoCount', 'videos', 'newVideoCount'));
    }

    /**
     * Display the user's settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        return view('pages.settings');
    }
}
