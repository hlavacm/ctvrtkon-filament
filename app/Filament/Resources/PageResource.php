<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationGroup = "Data";

    protected static ?string $navigationIcon = "heroicon-o-document";

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
                Forms\Components\MarkdownEditor::make("content")
                    ->required()
                    ->maxLength(50000),
                Forms\Components\Toggle::make("is_active")
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make("is_active")
                    ->boolean()
                    ->sortable(),
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
                Tables\Filters\TernaryFilter::make("is_active"),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make("enable")
                    ->icon("heroicon-m-check")
                    ->color("warning")
                    ->action(fn (Page $record) => $record->enable()),
                Tables\Actions\Action::make("disable")
                    ->icon("heroicon-m-x-mark")
                    ->color("warning")
                    ->action(fn (Page $record) => $record->disable()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make("enable-bulk")
                        ->icon("heroicon-m-check")
                        ->color("warning")
                        ->action(fn (Collection $records) => $records->each->enable()),
                    Tables\Actions\BulkAction::make("disable-bulk")
                        ->icon("heroicon-m-x-mark")
                        ->color("warning")
                        ->action(fn (Collection $records) => $records->each->disable()),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListPages::route("/"),
            "create" => Pages\CreatePage::route("/create"),
            "edit" => Pages\EditPage::route("/{record}/edit"),
        ];
    }
}
