<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AssetCompanyChart;
use App\Filament\Widgets\AssetDepartmentChart;
use App\Filament\Widgets\AssetJenisCompanyChart;
use App\Filament\Widgets\AssetLocationStatusChart;
use App\Filament\Widgets\AssetStats;
use App\Filament\Widgets\AssetStatusChart;
use App\Filament\Widgets\ServiceYearChart;
use App\Filament\Widgets\SoftwareAssignmentCompanyChart;
use App\Filament\Widgets\WarrantyExpiringAssets;
use App\Filament\Widgets\SoftwareLicenseExpirationReminder;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;


class Dashboard extends Page
{

    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $slug = 'dashboard';

    protected static string|\BackedEnum|null $navigationIcon =
        Heroicon::OutlinedHome;

    protected string $view =
        'filament.pages.dashboard';


    /*
    |--------------------------------------------------------------------------
    | ACTIVE ANALYTICS
    |--------------------------------------------------------------------------
    */

    public ?string $activeWidget = 'company';


    /*
    |--------------------------------------------------------------------------
    | OPEN ANALYTICS
    |--------------------------------------------------------------------------
    */

    public function openWidget(string $widget): void
    {

        $allowedWidgets = [

            'status',

            'company',

            'department',

            'jenis',

            'location',

            'service',

            'software',

            'warranty',

        ];


        if (! in_array(
            $widget,
            $allowedWidgets,
            true
        )) {

            return;

        }


        $this->activeWidget = $widget;

    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE ANALYTICS
    |--------------------------------------------------------------------------
    */

    public function closeWidget(): void
    {

        $this->activeWidget = null;

    }


    /*
    |--------------------------------------------------------------------------
    | GET ACTIVE WIDGET CLASS
    |--------------------------------------------------------------------------
    */

    public function getWidgetClass(): ?string
    {

        return match ($this->activeWidget) {

            'status' =>
                AssetStatusChart::class,

            'company' =>
                AssetCompanyChart::class,

            'department' =>
                AssetDepartmentChart::class,

            'jenis' =>
                AssetJenisCompanyChart::class,

            'location' =>
                AssetLocationStatusChart::class,

            'service' =>
                ServiceYearChart::class,

            'software' =>
                SoftwareAssignmentCompanyChart::class,

            'warranty' =>
                WarrantyExpiringAssets::class,

            default =>
                null,

        };

    }


    /*
    |--------------------------------------------------------------------------
    | GET ACTIVE WIDGET TITLE
    |--------------------------------------------------------------------------
    */

    public function getWidgetTitle(): string
    {

        return match ($this->activeWidget) {

            'status' =>
                'Status Asset',

            'company' =>
                'Asset per Company',

            'department' =>
                'Asset per Department',

            'jenis' =>
                'Jenis Asset per Company',

            'location' =>
                'Lokasi Asset',

            'service' =>
                'Service per Tahun',

            'software' =>
                'Software Assignment per Company',

            'warranty' =>
                'Warranty Expiring Assets',

            default =>
                'Dashboard Analytics',

        };

    }


    /*
    |--------------------------------------------------------------------------
    | STATISTICS WIDGET
    |--------------------------------------------------------------------------
    */

    public function getStatsWidget(): string
    {

        return AssetStats::class;

    }


    /*
    |--------------------------------------------------------------------------
    | SOFTWARE LICENSE REMINDER WIDGET
    |--------------------------------------------------------------------------
    */

    public function getSoftwareLicenseReminderWidget(): string
    {

        return SoftwareLicenseExpirationReminder::class;

    }

}
