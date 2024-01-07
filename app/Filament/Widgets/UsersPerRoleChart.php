<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\User;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;

class UsersPerRoleChart extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getColumns(): int|string|array
    {
        return 4;
    }

    protected function getData(): array
    {
        $colors = array_reverse(array_values(Color::all()));
        $data = [];
        $labels = [];
        $backgroundColors = [];
        foreach (RoleEnum::keys() as $index => $role) {
            $data[] = User::whereRole($role)->count();
            $labels[] = $role;
            $color = $colors[$index][600];
            $backgroundColors[] = "rgb({$color})";
        }
        return [
            "labels" => $labels,
            "datasets" => [
                [
                    "data" => $data,
                    "backgroundColor" => $backgroundColors,
                    "hoverOffset" => 4,
                ],
            ],
        ];
    }

    protected static ?array $options = [
        "responsive" => true,
        "maintainAspectRatio" => false,
        "scales" => [
            "x" => [
                "ticks" => [
                    "display" => false,
                ],
                "grid" => [
                    "display" => false,
                ],
            ],
            "y" => [
                "ticks" => [
                    "display" => false,
                ],
                "grid" => [
                    "display" => false,
                ],
            ],
        ],
    ];

    protected function getType(): string
    {
        return "doughnut";
    }
}
