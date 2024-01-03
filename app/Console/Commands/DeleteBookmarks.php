<?php

namespace App\Console\Commands;

use App\Models\Bookmark;
use Illuminate\Console\Command;

class DeleteBookmarks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-bookmarks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes expired bookmarks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Searching for expired bookmarks...');

        $expiredBookmarks = Bookmark::where('expiration_time', '<', now())->get();

        foreach ($expiredBookmarks as $bookmark) {
            $bookmark->delete();
        }

        $this->info('Expired bookmarks deleted successfully!');
    }
}
