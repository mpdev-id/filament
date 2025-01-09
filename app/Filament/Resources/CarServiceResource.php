<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\CarService;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CarServiceResource\Pages;
use App\Filament\Resources\CarServiceResource\RelationManagers;

class CarServiceResource extends Resource
{
    protected static ?string $model = CarService::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([

        FileUpload::make('icon')
        ->image()
        ->imageEditor()
        ->required(),


        //
        TextInput::make('name')
        ->maxLength(255)
        ->required(),

        TextInput::make('price')
        ->numeric()
        ->mask(RawJs::make('$money($input)'))
        ->stripCharacters(',')
        ->prefix('Rp.')
        ->suffix('.00')
        ->required(),

        TextInput::make('duration in hour')
        ->numeric()
        ->minValue(1)
        ->maxValue(3)
        ->placeholder('Berapa Jam?')
        ->required(),

        Textarea::make('about')
        ->rows(10)
        ->cols(20)
        ->required(),

        FileUpload::make('photo')
        ->image()
        ->imageEditor()
        ->required(),

        ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCarServices::route('/'),
            'create' => Pages\CreateCarService::route('/create'),
            'edit' => Pages\EditCarService::route('/{record}/edit'),
        ];
    }
}
