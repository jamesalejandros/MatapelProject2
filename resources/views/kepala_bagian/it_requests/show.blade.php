<!DOCTYPE html> <html lang="id"> <head>
<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Detail Permintaan IT — {{ $itRequest->NoRequest }}
</title>

<script src="https://cdn.tailwindcss.com"></script>

</head> <body class="min-h-screen bg-slate-100 text-slate-800">
@php

/*
|--------------------------------------------------------------------------
| STATUS REQUEST
|--------------------------------------------------------------------------
*/

$requestStatus = strtolower(
    $itRequest->Status ?? 'pending'
);

$requestStatusLabel = match ($requestStatus) {

    'diajukan',
    'pending' =>
        'Menunggu Persetujuan',

    'disetujui',
    'approved' =>
        'Disetujui',

    'ditolak',
    'rejected',
    'cancelled' =>
        'Ditolak',

    'diproses',
    'process',
    'processing',
    'in_progress' =>
        'Sedang Diproses',

    'selesai',
    'completed',
    'done' =>
        'Selesai',

    default =>
        ucfirst(
            $itRequest->Status ?? 'Pending'
        ),

};

$requestStatusClasses = match ($requestStatus) {

    'disetujui',
    'approved',
    'selesai',
    'completed',
    'done' => [
        'wrapper' =>
            'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'dot' =>
            'bg-emerald-500',
    ],

    'ditolak',
    'rejected',
    'cancelled' => [
        'wrapper' =>
            'bg-red-50 text-red-700 ring-red-200',
        'dot' =>
            'bg-red-500',
    ],

    'diproses',
    'process',
    'processing',
    'in_progress' => [
        'wrapper' =>
            'bg-blue-50 text-blue-700 ring-blue-200',
        'dot' =>
            'bg-blue-500',
    ],

    default => [
        'wrapper' =>
            'bg-amber-50 text-amber-700 ring-amber-200',
        'dot' =>
            'bg-amber-500',
    ],

};

/*
|--------------------------------------------------------------------------
| STATUS APPROVAL
|--------------------------------------------------------------------------
*/

$approvalStatus =
    strtolower(
        $itRequest->approval?->status ?? 'pending'
    );

$approvalStatusLabel = match ($approvalStatus) {

    'approved',
    'disetujui' =>
        'Disetujui',

    'rejected',
    'ditolak' =>
        'Ditolak',

    'pending' =>
        'Menunggu Persetujuan',

    default =>
        ucfirst(
            $itRequest->approval?->status ?? '-'
        ),

};

$approvalStatusClasses = match ($approvalStatus) {

    'approved',
    'disetujui' => [
        'wrapper' =>
            'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'dot' =>
            'bg-emerald-500',
    ],

    'rejected',
    'ditolak' => [
        'wrapper' =>
            'bg-red-50 text-red-700 ring-red-200',
        'dot' =>
            'bg-red-500',
    ],

    default => [
        'wrapper' =>
            'bg-amber-50 text-amber-700 ring-amber-200',
        'dot' =>
            'bg-amber-500',
    ],

};

/*
|--------------------------------------------------------------------------
| PEMOHON
|--------------------------------------------------------------------------
*/

$pemohonNama =
    $itRequest->pemohon?->karyawan?->Nama
    ?? $itRequest->pemohon?->name
    ?? '-';

$pemohonInitial =
    strtoupper(
        substr(
            $pemohonNama,
            0,
            1
        )
    );

/*
|--------------------------------------------------------------------------
| APPROVAL PENDING
|--------------------------------------------------------------------------
*/

$isPending =
    $itRequest->approval
    &&
    $itRequest->approval->status === 'pending';

@endphp

{{-- ============================================================
TOP NAVIGATION
============================================================= --}}

<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
<div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">

    <div class="flex min-w-0 items-center gap-3">

        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-white shadow-sm">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                />
            </svg>

        </div>

        <div class="min-w-0">

            <p class="truncate text-sm font-bold text-slate-900">
                Persetujuan Permintaan IT
            </p>

            <p class="truncate text-xs text-slate-500">
                Panel Kepala Bagian
            </p>

        </div>

    </div>

    <div class="flex items-center gap-2 sm:gap-4">

        <div class="hidden text-right sm:block">

            <p class="text-sm font-semibold text-slate-800">
                {{ auth('kepala_bagian')->user()->name }}
            </p>

            <p class="text-xs text-slate-500">
                Kepala Bagian
            </p>

        </div>

        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">

            {{
                strtoupper(
                    substr(
                        auth('kepala_bagian')->user()->name,
                        0,
                        1
                    )
                )
            }}

        </div>

    </div>

</div>

</header>
{{-- ============================================================
MAIN
============================================================= --}}

<main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
{{-- ========================================================
    BACK
========================================================= --}}

<div class="mb-5">

    <a
        href="{{ route('kepala-bagian.it-requests.index') }}"
        class="inline-flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm font-medium text-slate-500 transition hover:bg-white hover:text-slate-900"
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
                d="M15 19l-7-7 7-7"
            />
        </svg>

        Kembali ke daftar permintaan

    </a>

</div>

{{-- ========================================================
    ALERT
========================================================= --}}

@if (session('success'))

    <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">

        <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-emerald-100">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 text-emerald-600"
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

        </div>

        <div>

            <p class="text-sm font-semibold">
                Berhasil
            </p>

            <p class="mt-0.5 text-sm">
                {{ session('success') }}
            </p>

        </div>

    </div>

@endif

@if (session('error'))

    <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">

        <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-red-100">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 text-red-600"
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

        </div>

        <div>

            <p class="text-sm font-semibold">
                Tidak dapat diproses
            </p>

            <p class="mt-0.5 text-sm">
                {{ session('error') }}
            </p>

        </div>

    </div>

@endif

@if ($errors->any())

    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">

        <div class="flex items-center gap-2">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-red-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3.75h.008M10.29 3.86l-7.1 12.28A1.875 1.875 0 004.815 19h14.37a1.875 1.875 0 001.624-2.86L13.71 3.86a1.875 1.875 0 00-3.42 0z"
                />
            </svg>

            <p class="font-semibold">
                Periksa kembali data
            </p>

        </div>

        <ul class="mt-2 list-disc space-y-1 pl-7 text-sm">

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif

{{-- ========================================================
    HERO
========================================================= --}}

<section class="mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 shadow-lg">

    <div class="p-5 sm:p-7">

        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="min-w-0">

                <div class="mb-3 flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400">

                    <span>
                        Detail Permintaan IT
                    </span>

                    <span class="text-slate-600">
                        /
                    </span>

                    <span>
                        {{ $itRequest->NoRequest }}
                    </span>

                </div>

                <h1 class="break-all text-2xl font-bold tracking-tight text-white sm:text-3xl">
                    {{ $itRequest->NoRequest }}
                </h1>

                <p class="mt-2 text-sm text-slate-400">
                    Diajukan pada
                    <span class="font-medium text-slate-300">
                        {{ $itRequest->created_at?->format('d F Y, H:i') ?? '-' }}
                    </span>
                </p>

            </div>

            <div class="flex flex-wrap items-center gap-2">

                <span
                    class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs font-semibold ring-1 ring-inset {{ $requestStatusClasses['wrapper'] }}"
                >

                    <span class="h-2 w-2 rounded-full {{ $requestStatusClasses['dot'] }}"></span>

                    {{ $requestStatusLabel }}

                </span>

                <span
                    class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs font-semibold ring-1 ring-inset {{ $approvalStatusClasses['wrapper'] }}"
                >

                    <span class="h-2 w-2 rounded-full {{ $approvalStatusClasses['dot'] }}"></span>

                    Approval:
                    {{ $approvalStatusLabel }}

                </span>

            </div>

        </div>

    </div>

    {{-- SUMMARY STRIP --}}

    <div class="grid border-t border-white/10 bg-white/5 sm:grid-cols-3">

        <div class="border-b border-white/10 px-5 py-4 sm:border-b-0 sm:border-r sm:px-6">

            <p class="text-xs font-medium text-slate-400">
                Pemohon
            </p>

            <p class="mt-1 truncate text-sm font-semibold text-white">
                {{ $pemohonNama }}
            </p>

        </div>

        <div class="border-b border-white/10 px-5 py-4 sm:border-b-0 sm:border-r sm:px-6">

            <p class="text-xs font-medium text-slate-400">
                Departemen
            </p>

            <p class="mt-1 truncate text-sm font-semibold text-white">
                {{
                    $itRequest
                        ->pemohon
                        ?->karyawan
                        ?->departemen
                        ?->NamaDept
                    ?? '-'
                }}
            </p>

        </div>

        <div class="px-5 py-4 sm:px-6">

            <p class="text-xs font-medium text-slate-400">
                Jenis Permintaan
            </p>

            <p class="mt-1 text-sm font-semibold text-white">

                {{ $itRequest->jenisPermintaan?->count() ?? 0 }}

                jenis

            </p>

        </div>

    </div>

</section>

{{-- ========================================================
    CONTENT GRID
========================================================= --}}

<div class="grid gap-6 lg:grid-cols-3">

    {{-- ====================================================
        LEFT
    ===================================================== --}}

    <div class="space-y-6 lg:col-span-2">

        {{-- =================================================
            INFORMASI PEMOHON
        ================================================== --}}

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Informasi Pemohon
                        </h2>

                        <p class="text-xs text-slate-500">
                            Identitas pengguna yang mengajukan permintaan.
                        </p>

                    </div>

                </div>

            </div>

            <div class="p-5 sm:p-6">

                <div class="flex flex-col gap-5 sm:flex-row">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-xl font-bold text-white shadow-sm">

                        {{ $pemohonInitial }}

                    </div>

                    <div class="grid flex-1 gap-5 sm:grid-cols-2">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Nama
                            </p>

                            <p class="mt-1 font-semibold text-slate-800">
                                {{ $pemohonNama }}
                            </p>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                NIK
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ $itRequest->pemohon?->NIK ?? '-' }}
                            </p>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Email
                            </p>

                            <p class="mt-1 break-all font-medium text-slate-700">
                                {{ $itRequest->pemohon?->email ?? '-' }}
                            </p>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Departemen
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{
                                    $itRequest
                                        ->pemohon
                                        ?->karyawan
                                        ?->departemen
                                        ?->NamaDept
                                    ?? '-'
                                }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        {{-- =================================================
            DETAIL PERMINTAAN
        ================================================== --}}

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                <h2 class="font-semibold text-slate-900">
                    Detail Permintaan
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Informasi yang disampaikan oleh pemohon.
                </p>

            </div>

            <div class="space-y-6 p-5 sm:p-6">

                <div>

                    <div class="mb-2 flex items-center justify-between">

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Permintaan
                        </p>

                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">

                        @if ($itRequest->Permintaan)

                            {!! nl2br(e($itRequest->Permintaan)) !!}

                        @else

                            <span class="text-slate-400">
                                Tidak ada detail permintaan.
                            </span>

                        @endif

                    </div>

                </div>

                <div>

                    <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Keterangan
                    </p>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">

                        @if ($itRequest->Keterangan)

                            {!! nl2br(e($itRequest->Keterangan)) !!}

                        @else

                            <span class="text-slate-400">
                                Tidak ada keterangan tambahan.
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </section>

        {{-- =================================================
            JENIS PERMINTAAN
        ================================================== --}}

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                <h2 class="font-semibold text-slate-900">
                    Jenis Permintaan
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Kategori kebutuhan IT yang diajukan.
                </p>

            </div>

            <div class="p-5 sm:p-6">

                @if (
                    $itRequest->jenisPermintaan
                    &&
                    $itRequest->jenisPermintaan->count()
                )

                    <div class="flex flex-wrap gap-2">

                        @foreach ($itRequest->jenisPermintaan as $jenis)

                            <span class="inline-flex items-center gap-2 rounded-xl bg-violet-50 px-3 py-2 text-sm font-semibold text-violet-700 ring-1 ring-inset ring-violet-200">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75"
                                    />
                                </svg>

                                {{ $jenis->name ?? '-' }}

                            </span>

                        @endforeach

                    </div>

                @else

                    <p class="text-sm text-slate-400">
                        Tidak ada jenis permintaan.
                    </p>

                @endif

            </div>

        </section>

        {{-- =================================================
            ASSET IT
        ================================================== --}}

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Asset IT
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Asset yang berkaitan dengan permintaan.
                        </p>

                    </div>

                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                        {{ $itRequest->assets?->count() ?? 0 }} Asset
                    </span>

                </div>

            </div>

            <div class="overflow-x-auto">

                @if (
                    $itRequest->assets
                    &&
                    $itRequest->assets->count()
                )

                    <table class="min-w-full text-left text-sm">

                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

                            <tr>

                                <th class="px-5 py-3 font-semibold">
                                    No Asset
                                </th>

                                <th class="px-5 py-3 font-semibold">
                                    Nama
                                </th>

                                <th class="px-5 py-3 font-semibold">
                                    Jenis
                                </th>

                                <th class="px-5 py-3 font-semibold">
                                    Serial Number
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($itRequest->assets as $asset)

                                <tr class="transition hover:bg-slate-50">

                                    <td class="whitespace-nowrap px-5 py-4 font-semibold text-blue-700">

                                        {{ $asset->NoAssetIT ?? '-' }}

                                    </td>

                                    <td class="px-5 py-4 font-medium text-slate-800">

                                        {{ $asset->Nama ?? '-' }}

                                    </td>

                                    <td class="px-5 py-4 text-slate-600">

                                        {{ $asset->Jenis ?? '-' }}

                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 font-mono text-xs text-slate-600">

                                        {{ $asset->SN ?? '-' }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="p-8 text-center">

                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-400">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M20.25 7.5l-8.25-4.5L3.75 7.5m16.5 0v9l-8.25 4.5m8.25-13.5l-8.25 4.5m0 0L3.75 7.5m8.25 4.5v9"
                                />
                            </svg>

                        </div>

                        <p class="mt-3 text-sm font-medium text-slate-500">
                            Tidak ada asset yang dipilih.
                        </p>

                    </div>

                @endif

            </div>

        </section>

        {{-- =================================================
            USER TERKAIT
        ================================================== --}}

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            User Terkait
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Pengguna lain yang terkait dengan request ini.
                        </p>

                    </div>

                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                        {{ $itRequest->relatedUsers?->count() ?? 0 }} User
                    </span>

                </div>

            </div>

            <div class="p-5 sm:p-6">

                @if (
                    $itRequest->relatedUsers
                    &&
                    $itRequest->relatedUsers->count()
                )

                    <div class="grid gap-3 sm:grid-cols-2">

                        @foreach ($itRequest->relatedUsers as $relatedUser)

                            @php

                                $relatedUserNama =
                                    $relatedUser->karyawan?->Nama
                                    ?? $relatedUser->name
                                    ?? '-';

                                $initial =
                                    strtoupper(
                                        substr(
                                            $relatedUserNama,
                                            0,
                                            1
                                        )
                                    );

                            @endphp

                            <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">

                                    {{ $initial }}

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-slate-800">
                                        {{ $relatedUserNama }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        NIK: {{ $relatedUser->NIK ?? '-' }}
                                    </p>

                                    <p class="mt-0.5 truncate text-xs text-slate-500">
                                        {{
                                            $relatedUser
                                                ->karyawan
                                                ?->departemen
                                                ?->NamaDept
                                            ?? '-'
                                        }}
                                    </p>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="py-5 text-center">

                        <p class="text-sm text-slate-400">
                            Tidak ada user terkait.
                        </p>

                    </div>

                @endif

            </div>

        </section>

    </div>

    {{-- ====================================================
        RIGHT SIDEBAR
    ===================================================== --}}

    <aside class="space-y-6">

        {{-- =================================================
            APPROVAL
        ================================================== --}}

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4">

                <h2 class="font-semibold text-slate-900">
                    Approval Kepala Bagian
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Riwayat keputusan terhadap permintaan ini.
                </p>

            </div>

            @if ($itRequest->approval)

                <div class="space-y-5 p-5">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Status Approval
                        </p>

                        <div class="mt-2">

                            <span
                                class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $approvalStatusClasses['wrapper'] }}"
                            >

                                <span class="h-2 w-2 rounded-full {{ $approvalStatusClasses['dot'] }}"></span>

                                {{ $approvalStatusLabel }}

                            </span>

                        </div>

                    </div>

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Kepala Bagian
                        </p>

                        <p class="mt-1 font-medium text-slate-800">

                            {{
                                $itRequest
                                    ->approval
                                    ?->kepalaBagian
                                    ?->name
                                ?? '-'
                            }}

                        </p>

                    </div>

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Waktu Keputusan
                        </p>

                        <p class="mt-1 text-sm font-medium text-slate-700">

                            {{
                                $itRequest
                                    ->approval
                                    ->approved_at
                                    ?->format('d F Y, H:i')
                                ?? '-'
                            }}

                        </p>

                    </div>

                    @if ($itRequest->approval->catatan)

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Catatan
                            </p>

                            <div class="mt-2 rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm leading-6 text-slate-700">

                                {!! nl2br(
                                    e(
                                        $itRequest
                                            ->approval
                                            ->catatan
                                    )
                                ) !!}

                            </div>

                        </div>

                    @endif

                </div>

            @else

                <div class="p-6 text-center">

                    <p class="text-sm text-slate-500">
                        Data approval belum tersedia.
                    </p>

                </div>

            @endif

        </section>

        {{-- =================================================
            ACTION CARD
        ================================================== --}}

        @if ($isPending)

            <section class="overflow-hidden rounded-2xl border border-amber-200 bg-white shadow-sm">

                <div class="border-b border-amber-100 bg-amber-50 px-5 py-4">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6l4 2"
                                />
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />
                            </svg>

                        </div>

                        <div>

                            <h2 class="font-semibold text-amber-900">
                                Menunggu Keputusan
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-amber-700">
                                Silakan periksa detail permintaan sebelum memberikan keputusan.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="space-y-6 p-5">

                    {{-- =====================================
                        APPROVE
                    ====================================== --}}

                    <div>

                        <div class="mb-3">

                            <h3 class="text-sm font-semibold text-slate-900">
                                Setujui Permintaan
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Permintaan akan diteruskan ke Staff IT untuk diproses.
                            </p>

                        </div>

                        <form
                            method="POST"
                            action="{{ route(
                                'kepala-bagian.it-requests.approve',
                                $itRequest
                            ) }}"
                        >

                            @csrf

                            @method('PATCH')

                            <label
                                for="approve_catatan"
                                class="mb-1.5 block text-xs font-semibold text-slate-700"
                            >
                                Catatan
                                <span class="font-normal text-slate-400">
                                    (opsional)
                                </span>
                            </label>

                            <textarea
                                id="approve_catatan"
                                name="catatan"
                                rows="4"
                                placeholder="Tambahkan catatan approval jika diperlukan..."
                                class="block w-full resize-y rounded-xl border border-slate-300 bg-white px-3.5 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            >{{ old('catatan') }}</textarea>

                            <button
                                type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menyetujui permintaan ini?')"
                                class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-800"
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
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                Setujui Permintaan

                            </button>

                        </form>

                    </div>

                    <div class="border-t border-slate-200"></div>

                    {{-- =====================================
                        REJECT
                    ====================================== --}}

                    <div>

                        <div class="mb-3">

                            <h3 class="text-sm font-semibold text-slate-900">
                                Tolak Permintaan
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Jelaskan alasan penolakan agar pemohon mengetahui perbaikannya.
                            </p>

                        </div>

                        <form
                            method="POST"
                            action="{{ route(
                                'kepala-bagian.it-requests.reject',
                                $itRequest
                            ) }}"
                        >

                            @csrf

                            @method('PATCH')

                            <label
                                for="reject_catatan"
                                class="mb-1.5 block text-xs font-semibold text-slate-700"
                            >
                                Alasan Penolakan
                                <span class="text-red-500">
                                    *
                                </span>
                            </label>

                            <textarea
                                id="reject_catatan"
                                name="catatan"
                                rows="4"
                                required
                                minlength="3"
                                placeholder="Contoh: Permintaan belum dapat disetujui karena..."
                                class="block w-full resize-y rounded-xl border border-slate-300 bg-white px-3.5 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20"
                            >{{ old('catatan') }}</textarea>

                            <p class="mt-1.5 text-xs text-slate-400">
                                Catatan penolakan wajib diisi.
                            </p>

                            <button
                                type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menolak permintaan ini? Pastikan alasan penolakan sudah benar.')"
                                class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-800"
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
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>

                                Tolak Permintaan

                            </button>

                        </form>

                    </div>

                </div>

            </section>

        @else

            {{-- =============================================
                ALREADY PROCESSED
            ============================================== --}}

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75"
                            />
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                            />
                        </svg>

                    </div>

                    <div>

                        <h3 class="text-sm font-semibold text-slate-900">
                            Request Sudah Diproses
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            Request ini sudah memiliki keputusan dan tidak dapat diproses kembali oleh Kepala Bagian.
                        </p>

                    </div>

                </div>

            </section>

        @endif

        {{-- =================================================
            REQUEST INFO
        ================================================== --}}

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <h2 class="text-sm font-semibold text-slate-900">
                Informasi Request
            </h2>

            <div class="mt-4 space-y-3">

                <div class="flex items-center justify-between gap-4">

                    <span class="text-xs text-slate-500">
                        Nomor Request
                    </span>

                    <span class="text-right text-xs font-semibold text-slate-800">
                        {{ $itRequest->NoRequest }}
                    </span>

                </div>

                <div class="flex items-center justify-between gap-4">

                    <span class="text-xs text-slate-500">
                        Diajukan
                    </span>

                    <span class="text-right text-xs font-medium text-slate-700">
                        {{ $itRequest->created_at?->format('d M Y, H:i') ?? '-' }}
                    </span>

                </div>

                <div class="flex items-center justify-between gap-4">

                    <span class="text-xs text-slate-500">
                        Status
                    </span>

                    <span class="text-right text-xs font-semibold text-slate-700">
                        {{ $requestStatusLabel }}
                    </span>

                </div>

            </div>

        </section>

        {{-- =================================================
            LOGOUT
        ================================================== --}}

        <form
            method="POST"
            action="{{ route('kepala-bagian.logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18 12H9m0 0l3-3m-3 3l3 3"
                    />
                </svg>

                Keluar dari Akun

            </button>

        </form>

    </aside>

</div>

</main>
{{-- ============================================================
FOOTER
============================================================= --}}

<footer class="border-t border-slate-200 bg-white">
<div class="mx-auto max-w-7xl px-4 py-5 text-center text-xs text-slate-400 sm:px-6 lg:px-8">

    Sistem Manajemen Permintaan IT

    <span class="mx-1">
        •
    </span>

    Panel Kepala Bagian

</div>

</footer> </body> </html>