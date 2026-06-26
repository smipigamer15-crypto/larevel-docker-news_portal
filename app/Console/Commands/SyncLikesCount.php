<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;

class SyncLikesCount extends Command
{
    protected $signature = 'likes:sync';
    protected $description = 'Sync likes count for all news';

    public function handle()
    {
        $news = News::all();
        
        if ($news->isEmpty()) {
            $this->info('No news found.');
            return;
        }
        
        $bar = $this->output->createProgressBar($news->count());
        $bar->start();
        
        foreach ($news as $item) {
            $count = $item->usersWhoLiked()->count();
            $item->likes_count = $count;
            $item->save();
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('All likes counts synced successfully!');
    }
}