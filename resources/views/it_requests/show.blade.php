@extends('layouts.layout')

@section('title', $itRequest->NoRequest)

@section('content')

@php
/*
|--------------------------------------------------------------------------
| DATA STATUS
|--------------------------------------------------------------------------
*/

$status = strtolower($itRequest->Status ?? 'pending');

$statusLabel = match ($status) {
    'pending' => 'Pending',
    'approved' => 'Approved',
    'rejected' => 'Rejected',

    'diproses',
    'process',
    'processing',
    'in_progress' => 'Diproses',

    'selesai',
    'completed',
    'done' => 'Selesai',

    'diajukan' => 'Diajukan',

    'ditolak',
    'cancelled' => 'Ditolak',

    default => ucfirst($itRequest->Status ?? 'Pending'),
};

$statusClasses = match ($status) {
    'selesai',
    'completed',
    'done',
    'approved' => [
        'bg' => 'bg-emerald-50',
        'text' => 'text-emerald-700',
        'dot' => 'bg-emerald-500',
    ],

    'diproses',
    'process',
    'processing',
    'in_progress' => [
        'bg' => 'bg-blue-50',
        'text' => 'text-blue-700',
        'dot' => 'bg-blue-500',
    ],

    'rejected',
    'ditolak',
    'cancelled' => [
        'bg' => 'bg-red-50',
        'text' => 'text-red-700',
        'dot' => 'bg-red-500',
    ],

    default => [
        'bg' => 'bg-amber-50',
        'text' => 'text-amber-700',
        'dot' => 'bg-amber-500',
    ],
};

$pemohonNama =
    $itRequest->pemohon?->karyawan?->Nama
    ?? $itRequest->pemohon?->name
    ?? '-';

/*
|--------------------------------------------------------------------------
| SERAH TERIMA
|--------------------------------------------------------------------------
*/

$isSelesai = in_array(
    $status,
    [
        'selesai',
        'completed',
        'done',
    ],
    true
);

$isSudahSerahTerima =
    $itRequest->SerahTerima === true;

$isPemohon =
    (int) $itRequest->UserPemohonID ===
    (int) auth()->id();

$canSerahTerima =
    $isSelesai
    && !$isSudahSerahTerima
    && $isPemohon;

@endphp

{{-- ============================================================
SERAH TERIMA
============================================================= --}}

@if ($isSelesai)

    <div class="mb-6 overflow-hidden rounded-2xl border
        {{ $isSudahSerahTerima
            ? 'border-emerald-200 bg-emerald-50'
            : 'border-amber-200 bg-amber-50'
        }}
        shadow-sm"
    >

        <div class="p-5 sm:p-6">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                {{-- ==================================================
                    ICON + INFORMASI
                =================================================== --}}

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                        {{
                            $isSudahSerahTerima
                                ? 'bg-emerald-100 text-emerald-600'
                                : 'bg-amber-100 text-amber-600'
                        }}"
                    >

                        @if ($isSudahSerahTerima)

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                        @else

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.007v.008H12V16.5z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.99 3.86a2 2 0 00-3.7 0z"
                                />
                            </svg>

                        @endif

                    </div>


                    <div>

                        @if ($isSudahSerahTerima)

                            <h2 class="font-semibold text-emerald-900">
                                Serah Terima Sudah Dikonfirmasi
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-emerald-700">
                                Permintaan IT ini telah dikonfirmasi sudah diterima oleh pemohon.
                            </p>

                        @else

                            <h2 class="font-semibold text-amber-900">
                                Konfirmasi Serah Terima
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-amber-700">
                                Permintaan IT ini sudah selesai.
                                Silakan konfirmasi apabila pekerjaan dan hasil permintaan
                                sudah Anda terima.
                            </p>

                        @endif

                    </div>

                </div>


                {{-- ==================================================
                    STATUS
                =================================================== --}}

                @if ($isSudahSerahTerima)

                    <span
                        class="inline-flex shrink-0 items-center gap-2 rounded-full bg-white px-3 py-1.5 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200"
                    >

                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                        Sudah Diterima

                    </span>

                @else

                    <span
                        class="inline-flex shrink-0 items-center gap-2 rounded-full bg-white px-3 py-1.5 text-sm font-semibold text-amber-700 ring-1 ring-inset ring-amber-200"
                    >

                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>

                        Menunggu Konfirmasi

                    </span>

                @endif

            </div>


            {{-- ==================================================
                FORM KONFIRMASI
            =================================================== --}}

            @if ($canSerahTerima)

                <div class="mt-5 border-t border-amber-200 pt-5">

                    <p class="text-sm font-medium text-amber-900">
                        Apakah Anda sudah menerima hasil penyelesaian
                        permintaan ini?
                    </p>

                    <p class="mt-1 text-xs leading-5 text-amber-700">
                        Dengan menekan tombol di bawah, sistem akan mencatat
                        tanggal dan waktu konfirmasi secara otomatis.
                    </p>


                    <form
                        method="POST"
                        action="{{ route('it-requests.serah-terima', $itRequest) }}"
                        class="mt-4"
                        onsubmit="return confirm('Apakah Anda yakin sudah menerima hasil penyelesaian permintaan {{ $itRequest->NoRequest }}? Tanggal serah terima akan dicatat otomatis saat Anda mengonfirmasi.');"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:w-auto"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            Ya, Saya Terima

                        </button>

                    </form>

                </div>

            @endif


            {{-- ==================================================
                TANGGAL SERAH TERIMA
            =================================================== --}}

            @if ($isSudahSerahTerima)

                <div class="mt-5 grid gap-4 border-t border-emerald-200 pt-5 sm:grid-cols-2">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                            Status Serah Terima
                        </p>

                        <p class="mt-1 font-semibold text-emerald-900">
                            Sudah Diterima
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                            Tanggal Serah Terima
                        </p>

                        <p class="mt-1 font-semibold text-emerald-900">
                            {{ $itRequest->TanggalSerahTerima?->format('d M Y, H:i') ?? '-' }}
                        </p>

                    </div>

                </div>

            @endif

        </div>

    </div>

@endif

{{-- ============================================================
HEADER ACTION
============================================================= --}}

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
{{-- ========================================================
    BACK BUTTON
========================================================= --}}

<a
    href="{{ route('it-requests.index') }}"
    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600"
>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
        />
    </svg>

    Kembali ke Permintaan
</a>


{{-- ========================================================
    ACTION BUTTONS
========================================================= --}}

@if ($canModify)

    <div class="flex items-center gap-2">

        {{-- ==================================================
            EDIT
        =================================================== --}}

        <a
            href="{{ route('it-requests.edit', $itRequest) }}"
            title="Edit permintaan"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-700 shadow-sm transition hover:bg-amber-100 hover:text-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 7.125L16.875 4.5"
                />
            </svg>

            Edit
        </a>


        {{-- ==================================================
            DELETE
        =================================================== --}}

        <form
            method="POST"
            action="{{ route('it-requests.destroy', $itRequest) }}"
            onsubmit="return confirm('Yakin ingin menghapus permintaan {{ $itRequest->NoRequest }}? Data yang sudah dihapus tidak dapat dikembalikan.');"
        >
            @csrf

            @method('DELETE')

            <button
                type="submit"
                title="Hapus permintaan"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-100 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0115.916 21H8.084a2.25 2.25 0 01-2.244-1.327L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.59 0c-.34.059-.68.114-1.022.165m1.022-.165a48.11 48.11 0 013.478-.397m0 0V4.5A2.25 2.25 0 0114.879 4.5v.893m-9.12 0a48.66 48.66 0 0110.24 0"
                    />
                </svg>

                Hapus
            </button>
        </form>

    </div>

@endif

</div>
{{-- ============================================================
HEADER
============================================================= --}}

<div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
<div class="bg-gradient-to-r from-slate-900 to-slate-800 px-5 py-6 text-white sm:px-7">

    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

        <div class="min-w-0">

            <div class="mb-2 flex items-center gap-2 text-sm text-slate-300">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                    />
                </svg>

                Detail Permintaan IT

            </div>

            <h1 class="truncate text-2xl font-bold tracking-tight sm:text-3xl">
                {{ $itRequest->NoRequest }}
            </h1>

            <p class="mt-2 text-sm text-slate-300">
                Dibuat pada
                {{ $itRequest->created_at?->format('d F Y, H:i') ?? '-' }}
            </p>

        </div>

        {{-- Status --}}

        <span
            class="inline-flex shrink-0 items-center rounded-full bg-white/10 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-inset ring-white/20"
        >
            <span class="mr-2 h-2 w-2 rounded-full {{ $statusClasses['dot'] }}"></span>

            {{ $statusLabel }}
        </span>

    </div>

</div>


{{-- ========================================================
    SUMMARY
========================================================= --}}

<div class="grid divide-y divide-slate-200 sm:grid-cols-2 sm:divide-x sm:divide-y-0">

    {{-- Jenis Permintaan --}}

    <div class="p-5 sm:p-6">

        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
            Jenis Permintaan
        </p>

        <div class="mt-2 flex flex-wrap gap-2">

            @forelse ($itRequest->jenisPermintaan ?? [] as $jenis)

                <span
                    class="inline-flex items-center rounded-lg bg-violet-50 px-2.5 py-1.5 text-sm font-semibold text-violet-700 ring-1 ring-inset ring-violet-200"
                >
                    {{ $jenis->Nama ?? $jenis->name ?? $jenis->JenisPermintaan ?? '-' }}
                </span>

            @empty

                <span class="font-semibold text-slate-500">
                    -
                </span>

            @endforelse

        </div>

    </div>


    {{-- Asset IT --}}

    <div class="p-5 sm:p-6">

        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
            Asset IT
        </p>

        <div class="mt-2 flex flex-wrap gap-2">

            @forelse ($itRequest->assets ?? [] as $asset)

                <span
                    class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1.5 text-sm font-semibold text-blue-700 ring-1 ring-inset ring-blue-200"
                    title="{{ $asset->Nama ?? '' }}"
                >
                    {{ $asset->NoAssetIT }}
                </span>

            @empty

                <span class="font-semibold text-slate-500">
                    -
                </span>

            @endforelse

        </div>

    </div>

</div>

</div>
{{-- ============================================================
MAIN GRID
============================================================= --}}

<div class="grid gap-6 lg:grid-cols-3">
{{-- ========================================================
    LEFT / MAIN CONTENT
========================================================= --}}

<div class="space-y-6 lg:col-span-2">


    {{-- ====================================================
        INFORMASI PEMOHON
    ===================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

            <h2 class="font-semibold text-slate-900">
                Informasi Pemohon
            </h2>

        </div>

        <div class="grid gap-5 p-5 sm:grid-cols-3 sm:p-6">

            {{-- Nama --}}

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Nama
                </p>

                <p class="mt-1 font-medium text-slate-800">
                    {{ $pemohonNama }}
                </p>

            </div>


            {{-- NIK --}}

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    NIK
                </p>

                <p class="mt-1 font-medium text-slate-800">
                    {{ $itRequest->pemohon?->NIK ?? '-' }}
                </p>

            </div>


            {{-- Email --}}

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Email
                </p>

                <p class="mt-1 break-all font-medium text-slate-800">
                    {{ $itRequest->pemohon?->email ?? '-' }}
                </p>

            </div>

        </div>

    </div>


    {{-- ====================================================
        DETAIL PERMINTAAN
    ===================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

            <h2 class="font-semibold text-slate-900">
                Detail Permintaan
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Informasi dan keterangan yang diajukan oleh pemohon.
            </p>

        </div>

        <div class="space-y-6 p-5 sm:p-6">

            {{-- Permintaan --}}

            <div>

                <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Permintaan
                </p>

                <div class="rounded-xl bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                    {!! nl2br(e($itRequest->Permintaan ?? '-')) !!}
                </div>

            </div>


            {{-- Keterangan --}}

            <div>

                <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Keterangan
                </p>

                <div class="rounded-xl bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                    {!! nl2br(e($itRequest->Keterangan ?? '-')) !!}
                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================
        STATUS PERSETUJUAN KEPALA BAGIAN
    ===================================================== --}}

    @php
        $approval = $itRequest->approval;

        $approvalStatus = strtolower(
            $approval?->status ?? 'pending'
        );

        $approvalStatusLabel = match ($approvalStatus) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'pending' => 'Menunggu Persetujuan',
            default => ucfirst($approval?->status ?? 'Pending'),
        };

        $approvalStatusClasses = match ($approvalStatus) {
            'approved' => [
                'bg' => 'bg-emerald-50',
                'text' => 'text-emerald-700',
                'border' => 'border-emerald-200',
                'icon' => 'bg-emerald-100 text-emerald-600',
            ],

            'rejected' => [
                'bg' => 'bg-red-50',
                'text' => 'text-red-700',
                'border' => 'border-red-200',
                'icon' => 'bg-red-100 text-red-600',
            ],

            default => [
                'bg' => 'bg-amber-50',
                'text' => 'text-amber-700',
                'border' => 'border-amber-200',
                'icon' => 'bg-amber-100 text-amber-600',
            ],
        };
    @endphp


    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                        {{ $approvalStatusClasses['icon'] }}"
                >

                    @if ($approvalStatus === 'rejected')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>

                    @elseif ($approvalStatus === 'approved')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                    @else

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6l4 2"
                            />
                        </svg>

                    @endif

                </div>

                <div>

                    <h2 class="font-semibold text-slate-900">
                        Persetujuan Kepala Bagian
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Status persetujuan dan catatan dari Kepala Bagian.
                    </p>

                </div>

            </div>

        </div>


        <div class="space-y-5 p-5 sm:p-6">

            @if ($approval)

                {{-- STATUS --}}

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Status Persetujuan
                    </p>

                    <div class="mt-2">

                        <span
                            class="inline-flex items-center rounded-full px-3 py-1.5 text-sm font-semibold
                                {{ $approvalStatusClasses['bg'] }}
                                {{ $approvalStatusClasses['text'] }}
                                ring-1 ring-inset
                                {{ $approvalStatusClasses['border'] }}"
                        >
                            {{ $approvalStatusLabel }}
                        </span>

                    </div>

                </div>


                <div class="grid gap-5 sm:grid-cols-2">

                    {{-- KEPALA BAGIAN --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Kepala Bagian
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ $approval->kepalaBagian?->name ?? '-' }}
                        </p>

                    </div>


                    {{-- WAKTU --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Waktu Diproses
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ $approval->approved_at?->format('d M Y, H:i') ?? '-' }}
                        </p>

                    </div>

                </div>


                {{-- CATATAN APPROVAL --}}

                @if (
                    $approvalStatus === 'approved'
                    && filled($approval->catatan)
                )

                    <div>

                        <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Catatan Kepala Bagian
                        </p>

                        <div class="rounded-xl bg-emerald-50 p-4 text-sm leading-7 text-emerald-800 ring-1 ring-inset ring-emerald-200">
                            {!! nl2br(e($approval->catatan)) !!}
                        </div>

                    </div>

                @endif


                {{-- PENOLAKAN --}}

                @if ($approvalStatus === 'rejected')

                    <div class="rounded-xl border border-red-200 bg-red-50 p-4">

                        <div class="flex items-start gap-3">

                            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m0 3.75h.007v.008H12V16.5z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.99 3.86a2 2 0 00-3.7 0z"
                                    />
                                </svg>

                            </div>

                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-red-800">
                                    Permintaan Ditolak
                                </p>

                                <p class="mt-1 text-xs text-red-700">
                                    Permintaan ini ditolak oleh
                                    <span class="font-semibold">
                                        {{ $approval->kepalaBagian?->name ?? '-' }}
                                    </span>.
                                </p>

                            </div>

                        </div>


                        <div class="mt-4">

                            <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-red-600">
                                Catatan Penolakan
                            </p>

                            <div class="rounded-lg bg-white p-4 text-sm leading-7 text-slate-700 ring-1 ring-inset ring-red-200">
                                {!! nl2br(
                                    e(
                                        $approval->catatan
                                        ?? 'Tidak ada catatan penolakan.'
                                    )
                                ) !!}
                            </div>

                        </div>

                    </div>

                @endif

            @else

                <div class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500">
                    Belum ada data persetujuan Kepala Bagian.
                </div>

            @endif

        </div>

    </div>


    {{-- ====================================================
        INFORMASI PENYELESAIAN
    ===================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75"
                        />
                    </svg>

                </div>

                <div>

                    <h2 class="font-semibold text-slate-900">
                        Informasi Penyelesaian
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Informasi terkait proses dan hasil penyelesaian request.
                    </p>

                </div>

            </div>

        </div>


        <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">

            {{-- Yang Menyelesaikan --}}

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Yang Menyelesaikan
                </p>

                <p class="mt-1 font-medium text-slate-800">
                    {{ $itRequest->penyelesai?->karyawan?->Nama
                        ?? $itRequest->penyelesai?->name
                        ?? '-' }}
                </p>

            </div>


            {{-- Rencana Selesai --}}

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Rencana Selesai
                </p>

                <p class="mt-1 font-medium text-slate-800">
                    {{ $itRequest->RencanaSelesai?->format('d M Y') ?? '-' }}
                </p>

            </div>


            {{-- Tanggal Selesai --}}

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Tanggal Selesai
                </p>

                <p class="mt-1 font-medium text-slate-800">
                    {{ $itRequest->TanggalSelesai?->format('d M Y, H:i') ?? '-' }}
                </p>

            </div>


            {{-- Catatan Penyelesaian --}}

            <div class="sm:col-span-2">

                <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Catatan Penyelesaian
                </p>

                <div class="rounded-xl bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                    {!! nl2br(e($itRequest->CatatanPenyelesaian ?? '-')) !!}
                </div>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================
    RIGHT SIDEBAR
========================================================= --}}

<div class="space-y-6">


    {{-- ====================================================
        BAGIAN TERKAIT
    ===================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4">

            <h2 class="font-semibold text-slate-900">
                Bagian Terkait
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Pengguna atau pihak lain yang terkait dengan request ini.
            </p>

        </div>


        <div class="p-5">

            @forelse ($itRequest->relatedUsers ?? [] as $user)

                @php
                    $relatedUserNama =
                        $user->karyawan?->Nama
                        ?? $user->name
                        ?? '-';

                    $initial = strtoupper(
                        substr($relatedUserNama, 0, 1)
                    );
                @endphp

                <div class="mb-3 flex items-start gap-3 rounded-xl bg-slate-50 p-3 last:mb-0">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">
                        {{ $initial }}
                    </div>

                    <div class="min-w-0">

                        <p class="truncate text-sm font-semibold text-slate-800">
                            {{ $relatedUserNama }}
                        </p>

                        <p class="mt-0.5 text-xs text-slate-500">
                            NIK: {{ $user->NIK ?? '-' }}
                        </p>

                        <p class="mt-0.5 text-xs text-slate-500">
                            {{ $user->karyawan?->departemen?->NamaDept ?? '-' }}
                        </p>

                    </div>

                </div>

            @empty

                <div class="py-3 text-center">

                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198l-.94-3.198m0 0a5.25 5.25 0 00-9.25 0m9.25 0a5.25 5.25 0 01-9.25 0m0 0l-.94 3.198m.94-3.198a3 3 0 00-4.682 2.72A9.094 9.094 0 007 18.72m4.5-13.5a3 3 0 11-6 0 3 3 0 016 0zm9 0a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>

                    </div>

                    <p class="mt-3 text-sm text-slate-500">
                        Tidak ada bagian terkait.
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- ====================================================
        ACTION
    ===================================================== --}}

    <div class="space-y-2">

        {{-- EDIT --}}

        @if ($canModify)

            <a
                href="{{ route('it-requests.edit', $itRequest) }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm font-semibold text-amber-700 shadow-sm transition hover:bg-amber-100 hover:text-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 7.125L16.875 4.5"
                    />
                </svg>

                Edit Permintaan

            </a>


            {{-- DELETE --}}

            <form
                method="POST"
                action="{{ route('it-requests.destroy', $itRequest) }}"
                onsubmit="return confirm('Yakin ingin menghapus permintaan {{ $itRequest->NoRequest }}? Data yang sudah dihapus tidak dapat dikembalikan.');"
            >
                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-100 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0115.916 21H8.084a2.25 2.25 0 01-2.244-1.327L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.59 0c-.34.059-.68.114-1.022.165m1.022-.165a48.11 48.11 0 013.478-.397m0 0V4.5A2.25 2.25 0 0114.879 4.5v.893m-9.12 0a48.66 48.66 0 0110.24 0"
                        />
                    </svg>

                    Hapus Permintaan

                </button>

            </form>

        @endif


        {{-- KEMBALI --}}

        <a
            href="{{ route('it-requests.index') }}"
            class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
                />
            </svg>

            Kembali ke Permintaan

        </a>

    </div>

</div>

</div>
@endsection