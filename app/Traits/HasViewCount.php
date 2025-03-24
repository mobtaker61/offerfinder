<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasViewCount
{
    public function incrementViewCount()
    {
        $this->increment('view_count');
        
        // Cache the daily view count
        $cacheKey = "daily_views_{$this->getTable()}_{$this->id}_" . now()->format('Y-m-d');
        $currentCount = Cache::get($cacheKey, 0);
        Cache::put($cacheKey, $currentCount + 1, now()->addDays(30));
    }

    public function getDailyViewCount()
    {
        $cacheKey = "daily_views_{$this->getTable()}_{$this->id}_" . now()->format('Y-m-d');
        return Cache::get($cacheKey, 0);
    }

    public function getWeeklyViewCount()
    {
        $count = 0;
        for ($i = 0; $i < 7; $i++) {
            $date = now()->subDays($i)->format('Y-m-d');
            $cacheKey = "daily_views_{$this->getTable()}_{$this->id}_{$date}";
            $count += Cache::get($cacheKey, 0);
        }
        return $count;
    }
} 