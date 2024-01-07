<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = "Data";

    protected static ?string $navigationIcon = "heroicon-o-tag";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("title")
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set("slug", Str::slug($state)))
                    ->maxLength(100),
                Forms\Components\TextInput::make("slug")
                    ->required()
                    ->disabledOn("edit")
                    ->maxLength(100),
                Forms\Components\Textarea::make("description")
                    ->nullable()
                    ->maxLength(250),
                Forms\Components\Select::make("parent_id")
                    ->nullable()
                    ->relationship(
                        name: "parent",
                        titleAttribute: "title",
                        modifyQueryUsing: fn(Builder $query, $record) => $query->whereNull("parent_id")
                    ),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make("has_parent")
                    ->boolean(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCategories::route("/"),
            "create" => Pages\CreateCategory::route("/create"),
            "edit" => Pages\EditCategory::route("/{record}/edit"),
        ];
    }
}
