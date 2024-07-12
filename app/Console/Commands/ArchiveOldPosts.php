<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class ArchiveOldPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:archive-old-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archives posts from previous months that are not published';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Post::query()
            ->where('status', 'draft')
            ->where('created_at', '<', now()->firstOfMonth())
            ->chunk(100, function (Collection $posts) {
                $posts->toQuery()->update([
                    'status' => 'archived'
                ]);
            });
    }
}
