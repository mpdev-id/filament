<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarStore;
use Filament\Forms\Form;
use App\Models\CarService;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CarStoreResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CarStoreResource\RelationManagers;

class CarStoreResource extends Resource
{
    protected static ?string $model = CarStore::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->maxLength(50)
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->maxLength(20)
                    ->required(),
                Forms\Components\TextInput::make('cs_name')
                    ->label('CS Name')
                    ->maxLength(50)
                    ->required(),

                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->directory('car-stores')
                    ->image()
                    ->required(),
                Forms\Components\Toggle::make('is_open')
                    ->label('Is Open')
                    ->default(true)
                    ->required(),
                Forms\Components\Toggle::make('is_full')
                    ->label('Is Full')
                    ->required(),

                Forms\Components\select::make('city_id')
                    ->label('Select City')
                    ->relationship('City', 'name')
                    // ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('address')
                    ->label('Address')
                    ->maxLength(200)
                    ->required(),

                // simpan di table storeservice juga many to many, jadi dia nyimpen juga ke table storeservice
                Forms\Components\Repeater::make('storeServices') // ini pake relasi hasmany di model
                ->label('Store Services')
                ->relationship('storeServices')
                ->schema([
                    Forms\Components\Select::make('car_service_id')
                            ->relationship('service', 'name')
                            ->label('Car Service')
                            ->multipleOf(1)
                            ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\ImageColumn::make('thumbnail')
            ->circular()
            ->width(80)
            ->height(80)
            ,
            Tables\Columns\ImageColumn::make('photos.photo')
            ->circular()
            ->width(30)
            ->height(30),
            Tables\Columns\TextColumn::make('cs_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('address')->searchable()->sortable()
            ->limit(20),
            Tables\Columns\TextColumn::make('city.name')->searchable()->sortable(),
            Tables\Columns\IconColumn::make('is_open')->label('Open/Close')->trueIcon('heroicon-s-check-circle')->falseIcon('heroicon-s-x-circle'),
            Tables\Columns\IconColumn::make('is_full')->label('Full/Not Full')->trueIcon('heroicon-s-check-circle')->falseIcon('heroicon-s-x-circle'),

            ])
            ->filters([

                SelectFilter::make('city_id')
                ->label('Filter by City')
                ->relationship('city', 'name'),

                // SelectFilter::make('car_service_id')
                // ->label('Filter By Car Service')
                // ->options(CarService::all()->pluck('name', 'id')),

                // filter berdasarkan car_service_id
                // jika filter diisi maka akan menampilkan store yang memiliki car_service_id yang sesuai
                // dengan menggunakan whereHas maka akan menampilkan store yang memiliki car_service_id yang sesuai
                // dengan menggunakan query builder maka akan menampilkan store yang memiliki car_service_id yang sesuai
                SelectFilter::make('car_service_id')
                ->label('Filter By Car Service')
                ->options(CarService::pluck('name', 'id'))
                ->query(function (Builder $query, array $data) {
                    if ($data['value']) {
                        $query->whereHas('storeServices', function (Builder $query) use ($data) {
                            $query->where('car_service_id', $data['value']);
                        });
                    }
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
// php artisan make:filament-relation-manager CarStoreResource photos photo
// php artisan make:filament-relation-manager CarStoreResource nama_relasi_di_model nama_fieldnya
             RelationManagers\PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarStores::route('/'),
            'create' => Pages\CreateCarStore::route('/create'),
            'edit' => Pages\EditCarStore::route('/{record}/edit'),
        ];
    }
}
