<?php

namespace App\Filament\Resources\MstRuangans;

use App\Filament\Resources\BaseResource;

use App\Filament\Resources\MstRuangans\Pages\CreateMstRuangan;
use App\Filament\Resources\MstRuangans\Pages\EditMstRuangan;
use App\Filament\Resources\MstRuangans\Pages\ListMstRuangans;

use App\Filament\Resources\MstRuangans\Schemas\MstRuanganForm;
use App\Filament\Resources\MstRuangans\Tables\MstRuangansTable;

use App\Models\MstRuangan;

use BackedEnum;

use Filament\Schemas\Schema;
use Filament\Tables\Table;


class MstRuanganResource extends BaseResource
{
    protected static ?string $model =
        MstRuangan::class;


    /**
     * ==========================================================
     * PERMISSION
     * ==========================================================
     *
     * Permission:
     *
     * mstruangan.view
     * mstruangan.create
     * mstruangan.update
     * mstruangan.delete
     */
    protected static string $permissionPrefix =
        'mstruangan';


    /**
     * ==========================================================
     * NAVIGATION
     * ==========================================================
     */

    protected static bool $shouldRegisterNavigation =
        true;


    protected static ?string $navigationLabel =
        'Ruangan';


    protected static ?string $modelLabel =
        'Ruangan';


    protected static ?string $pluralModelLabel =
        'Ruangan';


    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-building-office-2';


    protected static string|\UnitEnum|null $navigationGroup =
        'Master Data';


    /**
     * ==========================================================
     * FORM
     * ==========================================================
     */

    public static function form(
        Schema $schema
    ): Schema {

        return MstRuanganForm::configure(
            $schema
        );
    }


    /**
     * ==========================================================
     * TABLE
     * ==========================================================
     */

    public static function table(
        Table $table
    ): Table {

        return MstRuangansTable::configure(
            $table
        );
    }


    /**
     * ==========================================================
     * RELATIONS
     * ==========================================================
     */

    public static function getRelations(): array
    {
        return [];
    }


    /**
     * ==========================================================
     * PAGES
     * ==========================================================
     */

    public static function getPages(): array
    {
        return [

            'index' =>
                ListMstRuangans::route('/'),

            'create' =>
                CreateMstRuangan::route('/create'),

            'edit' =>
                EditMstRuangan::route('/{record}/edit'),

        ];
    }
}
