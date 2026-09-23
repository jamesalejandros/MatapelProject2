<?php

namespace App\Filament\Resources\ItRequests\Widgets;

use App\Models\ItRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ItRequestStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | MENUNGGU APPROVAL
            |--------------------------------------------------------------------------
            */

            Stat::make(
                'Menunggu Approval',
                ItRequest::query()
                    ->whereHas(
                        'approval',
                        fn ($query) =>
                            $query->where('status', 'pending')
                    )
                    ->count()
            )
                ->description(
                    'Request perlu persetujuan Kepala Bagian'
                )
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->url(
                    '/admin/it-requests?filters[approval_status][value]=pending&filters[Status][value]=diajukan'
                ),

            /*
            |--------------------------------------------------------------------------
            | PERLU DIPROSES
            |--------------------------------------------------------------------------
            */

            Stat::make(
                'Perlu Diproses',
                ItRequest::query()
                    ->where('Status', 'disetujui')
                    ->count()
            )
                ->description(
                    'Sudah disetujui dan belum diproses'
                )
                ->descriptionIcon('heroicon-m-play')
                ->color('info')
                ->url(
                    '/admin/it-requests?filters[approval_status][value]=approved&filters[Status][value]=disetujui'
                ),

            /*
            |--------------------------------------------------------------------------
            | SEDANG DIPROSES
            |--------------------------------------------------------------------------
            */

            Stat::make(
                'Sedang Diproses',
                ItRequest::query()
                    ->where('Status', 'diproses')
                    ->count()
            )
                ->description(
                    'Request sedang dikerjakan'
                )
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('primary')
                ->url(
                    '/admin/it-requests?filters[approval_status][value]=approved&filters[Status][value]=diproses'
                ),

            /*
            |--------------------------------------------------------------------------
            | MENUNGGU SERAH TERIMA
            |--------------------------------------------------------------------------
            */

            Stat::make(
                'Menunggu Serah Terima',
                ItRequest::query()
                    ->where('Status', 'selesai')
                    ->where(function ($query) {
                        $query
                            ->whereNull('SerahTerima')
                            ->orWhere(
                                'SerahTerima',
                                0
                            )
                            ->orWhere(
                                'SerahTerima',
                                ''
                            );
                    })
                    ->count()
            )
                ->description(
                    'Selesai tetapi belum diterima'
                )
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('danger')
                ->url(
                    '/admin/it-requests?filters[approval_status][value]=approved&filters[Status][value]=selesai&filters[SerahTerima][value]=0'
                ),

            /*
            |--------------------------------------------------------------------------
            | LEWAT RENCANA SELESAI
            |--------------------------------------------------------------------------
            */

            Stat::make(
                'Lewat Rencana Selesai',
                ItRequest::query()
                    ->whereNotNull('RencanaSelesai')
                    ->whereDate(
                        'RencanaSelesai',
                        '<',
                        now()
                    )
                    ->whereNotIn(
                        'Status',
                        [
                            'selesai',
                            'ditolak',
                            'dibatalkan',
                        ]
                    )
                    ->count()
            )
                ->description(
                    'Melewati target penyelesaian'
                )
                ->descriptionIcon(
                    'heroicon-m-exclamation-triangle'
                )
                ->color('danger')
                ->url(
                    '/admin/it-requests?filters[overdue][value]=1'
                ),

        ];
    }
}
