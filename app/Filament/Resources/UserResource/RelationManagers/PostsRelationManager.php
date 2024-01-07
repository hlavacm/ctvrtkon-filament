<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = "posts";

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute("title")
            ->columns([
                Tables\Columns\TextColumn::make("title"),
                Tables\Columns\TextColumn::make("published_at")
                    ->dateTime(),
                Tables\Columns\TextColumn::make("category.title"),
            ])
            ->defaultSort("title")
            ->filters([])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
