<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

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
                Forms\Components\DateTimePicker::make("published_at")
                    ->nullable(),
                Forms\Components\Select::make("author_id")
                    ->required()
                    ->relationship(name: "author", titleAttribute: "name"),
                Forms\Components\Select::make("category_id")
                    ->required()
                    ->relationship(name: "category", titleAttribute: "title"),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("published_at")
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make("author.name")
                    ->sortable(),
                Tables\Columns\TextColumn::make("category.title")
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
                Tables\Filters\Filter::make("published_at")
                    ->form([
                        Forms\Components\DatePicker::make("published_at_from"),
                        Forms\Components\DatePicker::make("published_at_to"),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data["published_at_from"],
                                fn(Builder $query, $date): Builder => $query->whereDate("published_at", ">=", $date),
                            )
                            ->when(
                                $data["published_at_to"],
                                fn(Builder $query, $date): Builder => $query->whereDate("published_at", "<=", $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data["published_at_from"] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make("Published From " . Carbon::parse($data["published_at_from"])->toFormattedDateString())
                                ->removeField("published_at_from");
                        }
                        if ($data["published_at_to"] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make("Published To " . Carbon::parse($data["published_at_to"])->toFormattedDateString())
                                ->removeField("published_at_to");
                        }

                        return $indicators;
                    }),
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
            RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListPosts::route("/"),
            "create" => Pages\CreatePost::route("/create"),
            "edit" => Pages\EditPost::route("/{record}/edit"),
        ];
    }
}
