<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Country;
use App\Models\State;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;
    protected static ?string $modelLabel = 'Time';
    protected static ?string $pluralModelLabel = 'Times';


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('country_id')->label('País')
                    ->relationship('country', 'name')
                     ->required()
                    ->id('country_id')
                    ->live()
                    ->afterStateUpdated(function (Get $get) {
                        return $get('country_id') ? $get('country_id') : null;
                    }),
                Forms\Components\Select::make('state_id')->label('Estado')
                    ->relationship(
                        name: 'state',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query, callable $get) {
                            $countryId = $get('country_id');
                            if ($countryId) {
                                $query->where('country_id', $countryId);
                            }
                        }
                    )
                    ->hidden(fn (Get $get) => !$get('country_id'))
                    ->id('state_id')
                    ->required(),
                Forms\Components\TextInput::make('name')->name('name')->label('Nome')
                    ->required()
                    ->maxLength(255),
                 Forms\Components\FileUpload::make('logo')->label('Logo')
                    ->image()
                    ->maxSize(1024)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->disk('public')
                    ->label('Logo'),
                Tables\Columns\TextColumn::make('country.name')->label('País')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state.name')->label('Estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
