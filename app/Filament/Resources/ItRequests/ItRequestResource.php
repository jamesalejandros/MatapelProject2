<?php

namespace App\Filament\Resources\ItRequests;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\ItRequests\Pages\CreateItRequest;
use App\Filament\Resources\ItRequests\Pages\EditItRequest;
use App\Filament\Resources\ItRequests\Pages\ListItRequests;
use App\Filament\Resources\ItRequests\Schemas\ItRequestForm;
use App\Filament\Resources\ItRequests\Tables\ItRequestsTable;
use App\Models\ItRequest;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ItRequestResource extends BaseResource
{
    protected static ?string $model = ItRequest::class;

    protected static string $permissionPrefix = 'itrequest';

    protected static ?string $navigationLabel = 'Permintaan IT';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-clipboard-document-list';

    protected static ?string $modelLabel = 'Permintaan IT';

    protected static ?string $pluralModelLabel = 'Permintaan IT';

    protected static string|\UnitEnum|null $navigationGroup = 'IT';

    public static function form(Schema $schema): Schema
    {
        return ItRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItRequests::route('/'),
            'create' => CreateItRequest::route('/create'),
            'edit' => EditItRequest::route('/{record}/edit'),
        ];
    }
}
