<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = "children";

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
            ])
            ->defaultSort("title")
            ->filters([])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
