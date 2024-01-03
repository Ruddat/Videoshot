<?php

use App\Models\Video;
use Illuminate\Http\Request;
use App\Livewire\Video\AllVideo;
use App\Livewire\Video\EditVideo;
use App\Livewire\Video\WatchVideo;
use App\Livewire\Video\CreateVideo;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GoogleTranslateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {

        $status = Auth::check() ? ['public', 'private', 'pending'] : ['public'];

$videos = \App\Models\Video::with('channel')
    ->whereIn('visibility', $status)
    ->orderBy('created_at', 'desc')
    ->paginate(12);



  //       $channels = Auth::user()->channel()->with('videos')->get();
 //       $videos = $channels->flatMap(function ($channel) {
 //           return $channel->videos;
 //       })->sortByDesc('created_at');
//dd($videos);
    } else {
        $status = Auth::check() ? ['public', 'private', 'pending'] : ['public' , 'private'];

$videos = \App\Models\Video::with('channel')
    ->whereIn('visibility', $status)
    ->orderBy('created_at', 'desc')
    ->paginate(12);
    }

    return view('welcome', compact('videos'));
});

Route::post('/update-views', function(Request $request) {
    $videoId = $request->input('video_id');
    $video = Video::find($videoId);

    if ($video) {
        $video->increment('views');
        return response()->json(['message' => 'Views updated']);
    }

    return response()->json(['error' => 'Video not found'], 404);
});

Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notification.read');
Route::get('/notifications/markAllAsRead', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/history', [App\Http\Controllers\HomeController::class, 'history'])->name('history');
Route::get('/remove/video/{id}', [HomeController::class, 'removeVideo'])->name('remove.video');
Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');
Route::get('/account', [App\Http\Controllers\HomeController::class, 'account'])->name('account');
Route::get('lang/change', [GoogleTranslateController::class, 'change'])->name('change.lang');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/channel/{channel}/edit', [ChannelController::class, 'edit'])->name('channel.edit');
        Route::put('/channel/{channel}/update', [ChannelController::class, 'update'])->name('channel.update');
    });

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/videos/{channel}/create', CreateVideo::class)->name('video.create');
        Route::get('/videos/{channel}/{video}/edit', EditVideo::class)->name('video.edit');
        Route::get('/all-your-videos/{channel}', AllVideo::class)->name('video.all');
    });

Route::get('/watch/{video}', WatchVideo::class)->name('watch.video');
Route::get('/channels/{channel}', [ChannelController::class, 'index'])->name('channel.index');
Route::get('/search/', [SearchController::class, 'search'])->name('search');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
