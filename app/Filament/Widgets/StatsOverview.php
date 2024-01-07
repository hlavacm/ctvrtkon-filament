<?php

namespace App\Filament\Widgets;

use App\Models\Attachment;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $stats = [];
        $models = [
            Post::class => __("Posts"),
            Category::class => __("Categories"),
            Tag::class => __("Tags"),
            Page::class => __("Pages"),
            Attachment::class => __("Attachments"),
            User::class => __("Users"),
        ];
        foreach ($models as $modelClass => $label) {
            $allCount = $modelClass::all()->count();
            $yearCount = $modelClass::where("created_at", ">=", Carbon::now()->startOfYear())->count();
            $yearPercentage = $yearCount > 0 ? round(($yearCount / $allCount) * 100) : 0;
            $stats[] = Stat::make(__($label), $allCount)
                ->description("+{$yearCount} ({$yearPercentage}%) / ")
                ->descriptionIcon("heroicon-o-calendar")
                ->color("primary");
        }

        return $stats;
    }
}
