<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestUsers extends BaseWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->take(5)->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->label(__("Name"))
                    ->url(fn(User $record): string => route("filament.admin.resources.users.edit", $record)),
                Tables\Columns\TextColumn::make("email")
                    ->label(__("E-mail"))
                    ->url(fn(User $record): string => route("filament.admin.resources.users.edit", $record)),
                Tables\Columns\TextColumn::make("role")
                    ->label("Role"),
                Tables\Columns\TextColumn::make("created_at")
                    ->label(__("Created At"))
                    ->dateTime(),
            ])
            ->paginated(false);
    }
}
