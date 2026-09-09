@extends('layouts.layout')

@section('title', 'Permintaan IT')

@section('content')

@php
/*
|--------------------------------------------------------------------------
| HELPER STATUS
|--------------------------------------------------------------------------
*/

$getStatusClass = function (?string $status): string {
    return match (strtolower($status ?? '')) {
        'selesai',
        'completed',
        'done' =>
            'bg-emerald-50 text-emerald-700 ring-emerald-600/20',

        'disetujui',
        'approved' =>
            'bg-indigo-50 text-indigo-700 ring-indigo-600/20',

        'diproses',
        'process',
        'processing',
        'in_progress' =>
            'bg-blue-50 text-blue-700 ring-blue-600/20',

        'ditolak',
        'rejected',
        'cancelled' =>
            'bg-red-50 text-red-700 ring-red-600/20',

        'diajukan',
        'pending' =>
            'bg-amber-50 text-amber-700 ring-amber-600/20',

        default =>
            'bg-slate-50 text-slate-700 ring-slate-600/20',
    };
};

$getStatusLabel = function (?string $status): string {
    return match (strtolower($status ?? '')) {
        'selesai',
        'completed',
        'done' => 'Selesai',

        'disetujui',
        'approved' => 'Disetujui',

        'diproses',
        'process',
        'processing',
        'in_progress' => 'Diproses',

        'ditolak',
        'rejected',
        'cancelled' => 'Ditolak',

        'diajukan',
        'pending' => 'Diajukan',

        default => ucfirst($status ?? 'Menunggu'),
    };
};

@endphp

{{-- ============================================================
FLASH MESSAGE
============================================================= --}}

<!-- @if (session('success'))
<div
    class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 shadow-sm"
    role="alert"
>

    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">

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

    </div>

    <div class="min-w-0">

        <p class="text-sm font-semibold">
            Berhasil
        </p>

        <p class="mt-0.5 text-sm text-emerald-700">
            {{ session('success') }}
        </p>

    </div>

</div>

@endif -->

@if (session('error'))

<div
    class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800 shadow-sm"
    role="alert"
>

    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">

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
                d="M12 9v3.75m0 3.75h.008v.008H12V16.5zm9-4.5a9 9 0 11-18 0 9 9 0 0118 0z"
            />
        </svg>

    </div>

    <div class="min-w-0">

        <p class="text-sm font-semibold">
            Tidak dapat memproses permintaan
        </p>

        <p class="mt-0.5 text-sm text-red-700">
            {{ session('error') }}
        </p>

    </div>

</div>

@endif

{{-- ============================================================
VALIDATION ERROR
============================================================= --}}

@if ($errors->any())

<div
    class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 shadow-sm"
    role="alert"
>

    <div class="flex items-start gap-3">

        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">

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
                    d="M12 9v3.75m0 3.75h.008v.008H12V16.5zm9-4.5a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>

        </div>

        <div>

            <p class="text-sm font-semibold text-red-800">
                Terdapat kesalahan
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    </div>

</div>

@endif

{{-- ============================================================
HEADER
============================================================= --}}

<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
<div>

    <div class="mb-2 flex items-center gap-2 text-sm font-medium text-blue-600">

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

        IT Service Request

    </div>

    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
        Permintaan IT Saya
    </h1>

    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
        Pantau seluruh permintaan IT yang telah Anda ajukan beserta status penyelesaiannya.
    </p>

</div>

<a
    href="{{ route('it-requests.create') }}"
    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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
            d="M12 4v16m8-8H4"
        />
    </svg>

    Buat Permintaan

</a>

</div>
{{-- ============================================================
SUMMARY
============================================================= --}}

<div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
{{-- Total Request --}}

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

    <div class="flex items-center justify-between">

        <div>

            <p class="text-sm font-medium text-slate-500">
                Total Request
            </p>

            <p class="mt-1 text-2xl font-bold text-slate-900">
                {{ $requests->total() }}
            </p>

        </div>

        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

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
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                />
            </svg>

        </div>

    </div>

</div>

{{-- Halaman --}}

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

    <div class="flex items-center justify-between">

        <div>

            <p class="text-sm font-medium text-slate-500">
                Halaman Saat Ini
            </p>

            <p class="mt-1 text-2xl font-bold text-slate-900">
                {{ $requests->currentPage() }}
            </p>

        </div>

        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

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
                    d="M9 12.75L11.25 15 15 9.75"
                />
            </svg>

        </div>

    </div>

</div>

{{-- Akun Pemohon --}}

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2 lg:col-span-1">

    <div class="flex items-center justify-between">

        <div class="min-w-0">

            <p class="text-sm font-medium text-slate-500">
                Akun Pemohon
            </p>

            <p class="mt-1 max-w-48 truncate text-sm font-bold text-slate-900">
                {{ auth()->user()->karyawan?->Nama ?? auth()->user()->name }}
            </p>

        </div>

        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">

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
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                />
            </svg>

        </div>

    </div>

</div>

</div>
{{-- ============================================================
DAFTAR PERMINTAAN
============================================================= --}}

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
{{-- Section Header --}}

<div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

    <div>

        <h2 class="font-semibold text-slate-900">
            Daftar Permintaan
        </h2>

        <p class="mt-1 text-xs text-slate-500">
            Seluruh permintaan IT yang dapat Anda akses.
        </p>

    </div>

    <div class="flex items-center gap-2 text-xs text-slate-500">

        <span class="inline-flex h-2 w-2 rounded-full bg-amber-500"></span>

        <span>
            Request berstatus <strong class="font-semibold text-slate-700">Diajukan</strong> masih dapat diedit atau dihapus.
        </span>

    </div>

</div>

{{-- ========================================================
    DESKTOP / TABLET
========================================================= --}}

<div class="hidden overflow-x-auto md:block">

    <table class="min-w-full divide-y divide-slate-200">

        <thead class="bg-slate-50">

            <tr>

                {{-- NO REQUEST --}}

                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    No Request
                </th>

                {{-- PEMOHON --}}

                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Pemohon
                </th>

                {{-- JENIS --}}

                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Jenis
                </th>

                {{-- PERMINTAAN --}}

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Permintaan
                </th>

                {{-- ASSET --}}

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Asset
                </th>

                {{-- USER TERKAIT --}}

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    User Terkait
                </th>

                {{-- STATUS --}}

                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Status
                </th>

                {{-- TANGGAL --}}

                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Tanggal
                </th>

                {{-- AKSI --}}

                <th class="whitespace-nowrap px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody class="divide-y divide-slate-100 bg-white">

            @forelse ($requests as $request)

                @php

                    $status = strtolower($request->Status ?? '');

                    /*
                    |--------------------------------------------------------------------------
                    | PEMOHON
                    |--------------------------------------------------------------------------
                    */

                    $pemohonNama =
                        $request->pemohon?->karyawan?->Nama
                        ?? $request->pemohon?->name
                        ?? '-';

                    $pemohonNik =
                        $request->pemohon?->NIK
                        ?? '';

                    /*
                    |--------------------------------------------------------------------------
                    | HANYA PEMOHON + STATUS DIAJUKAN
                    |--------------------------------------------------------------------------
                    */

                    $isPemohon =
                        (int) $request->UserPemohonID ===
                        (int) auth()->id();

                    $canModify =
                        $isPemohon &&
                        $status === 'diajukan';

                    /*
                    |--------------------------------------------------------------------------
                    | STATUS SELESAI + SERAH TERIMA
                    |--------------------------------------------------------------------------
                    */

                    $statusRequest = strtolower(
                        (string) ($request->Status ?? '')
                    );

                    $isSelesai = in_array(
                        $statusRequest,
                        [
                            'selesai',
                            'completed',
                            'done',
                        ],
                        true
                    );

                    $isSudahSerahTerima =
                        $request->SerahTerima === true;

                @endphp

                <tr class="transition hover:bg-slate-50">

                    {{-- NO REQUEST --}}

                    <td class="whitespace-nowrap px-6 py-4">

                        <a
                            href="{{ route('it-requests.show', $request) }}"
                            class="font-semibold text-blue-600 transition hover:text-blue-800 hover:underline"
                        >
                            {{ $request->NoRequest }}
                        </a>

                        @if ($canModify)

                            <div class="mt-1">

                                <span class="inline-flex items-center gap-1 text-[11px] font-medium text-amber-600">

                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                    Dapat diubah

                                </span>

                            </div>

                        @endif

                    </td>

                    {{-- PEMOHON --}}

                    <td class="px-6 py-4">

                        <div class="flex min-w-[190px] items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">

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
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4.5 20.25a8.25 8.25 0 0115 0"
                                    />
                                </svg>

                            </div>

                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-semibold text-slate-800"
                                    title="{{ $pemohonNama }}"
                                >
                                    {{ $pemohonNama }}
                                </p>

                                @if ($pemohonNik)

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        NIK: {{ $pemohonNik }}
                                    </p>

                                @endif

                            </div>

                        </div>

                    </td>

                    {{-- JENIS --}}

                    <td class="px-6 py-4">

                        <div class="flex min-w-[160px] flex-wrap gap-1.5">

                            @forelse ($request->jenisPermintaan as $jenis)

                                <span
                                    class="inline-flex items-center rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700 ring-1 ring-inset ring-violet-200"
                                >
                                    {{ $jenis->name }}
                                </span>

                            @empty

                                <span class="text-xs text-slate-400">
                                    Tidak ada jenis
                                </span>

                            @endforelse

                        </div>

                    </td>

                    {{-- PERMINTAAN --}}

                    <td class="max-w-md px-6 py-4">

                        <p
                            class="line-clamp-2 text-sm leading-5 text-slate-700"
                            title="{{ $request->Permintaan }}"
                        >
                            {{ \Illuminate\Support\Str::limit($request->Permintaan, 100) }}
                        </p>

                    </td>

                    {{-- ASSET --}}

                    <td class="px-6 py-4">

                        <div class="flex min-w-[180px] flex-wrap gap-1.5">

                            @forelse ($request->assets as $asset)

                                <span
                                    class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-200"
                                    title="{{ $asset->NoAssetIT }}"
                                >
                                    {{ $asset->NoAssetIT }}
                                </span>

                            @empty

                                <span class="text-xs text-slate-400">
                                    Tidak ada asset
                                </span>

                            @endforelse

                        </div>

                    </td>

                    {{-- USER TERKAIT --}}

                    <td class="px-6 py-4">

                        <div class="flex min-w-[200px] flex-wrap gap-1.5">

                            @forelse ($request->relatedUsers as $relatedUser)

                                @php

                                    $relatedUserNama =
                                        $relatedUser->karyawan?->Nama
                                        ?? $relatedUser->name
                                        ?? '-';

                                @endphp

                                <span
                                    class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-200"
                                    title="{{ $relatedUser->NIK ?? '' }}"
                                >
                                    {{ $relatedUserNama }}
                                </span>

                            @empty

                                <span class="text-xs text-slate-400">
                                    Tidak ada
                                </span>

                            @endforelse

                        </div>

                    </td>

                    {{-- STATUS --}}

                    <td class="whitespace-nowrap px-6 py-4">

                        @if ($isSelesai)

                            @if ($isSudahSerahTerima)

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                    Sudah Diterima
                                </span>

                            @else

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                    Menunggu Serah Terima
                                </span>

                            @endif

                        @else

                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $getStatusClass($request->Status) }}"
                            >

                                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current"></span>

                                {{ $getStatusLabel($request->Status) }}

                            </span>

                        @endif

                    </td>

                    {{-- TANGGAL --}}

                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">

                        <div class="font-medium text-slate-700">
                            {{ $request->created_at?->format('d M Y') }}
                        </div>

                        <div class="mt-0.5 text-xs text-slate-400">
                            {{ $request->created_at?->format('H:i') }}
                        </div>

                    </td>

                    {{-- AKSI --}}

                    <td class="whitespace-nowrap px-6 py-4">

                        <div class="flex items-center justify-end gap-2">

                            {{-- DETAIL --}}

                            <a
                                href="{{ route('it-requests.show', $request) }}"
                                title="Lihat detail"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
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
                                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>

                                <span class="sr-only">
                                    Lihat detail
                                </span>

                            </a>

                            {{-- EDIT --}}

                            @if ($canModify)

                                <a
                                    href="{{ route('it-requests.edit', $request) }}"
                                    title="Edit permintaan"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-amber-200 bg-amber-50 text-amber-600 shadow-sm transition hover:bg-amber-100 hover:text-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1"
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

                                    <span class="sr-only">
                                        Edit permintaan
                                    </span>

                                </a>

                                {{-- DELETE --}}

                                <form
                                    method="POST"
                                    action="{{ route('it-requests.destroy', $request) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus permintaan {{ $request->NoRequest }}? Data yang sudah dihapus tidak dapat dikembalikan.');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        title="Hapus permintaan"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 shadow-sm transition hover:bg-red-100 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
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

                                        <span class="sr-only">
                                            Hapus permintaan
                                        </span>

                                    </button>

                                </form>

                            @else

                                {{-- STATUS TIDAK DAPAT DIUBAH --}}

                                <span
                                    title="{{ $isPemohon ? 'Permintaan sudah diproses dan tidak dapat diubah.' : 'Anda hanya terdaftar sebagai user terkait.' }}"
                                    class="inline-flex h-9 w-9 cursor-help items-center justify-center rounded-lg bg-slate-50 text-slate-400 ring-1 ring-inset ring-slate-200"
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
                                            d="M12 9v3.75m0 3.75h.008v.008H12V16.5z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>

                                    <span class="sr-only">
                                        Tidak dapat diubah
                                    </span>

                                </span>

                            @endif

                            {{-- SERAH TERIMA --}}

                            @if (
                                $isSelesai
                                && !$isSudahSerahTerima
                                && $isPemohon
                            )

                                <a
                                    href="{{ route('it-requests.show', $request) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-100 hover:text-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                                    title="Konfirmasi serah terima"
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

                                    Serah Terima

                                </a>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="10" class="px-6 py-16 text-center">

                        <div class="mx-auto flex max-w-sm flex-col items-center">

                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-7 w-7"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                                    />
                                </svg>

                            </div>

                            <h3 class="mt-4 text-sm font-semibold text-slate-900">
                                Belum ada permintaan
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Anda belum memiliki permintaan IT.
                            </p>

                            <a
                                href="{{ route('it-requests.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
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
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>

                                Buat Permintaan

                            </a>

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

{{-- ========================================================
    MOBILE
========================================================= --}}

<div class="divide-y divide-slate-100 md:hidden">

    @forelse ($requests as $request)

        @php

            $status = strtolower($request->Status ?? '');

            /*
            |--------------------------------------------------------------------------
            | PEMOHON
            |--------------------------------------------------------------------------
            */

            $pemohonNama =
                $request->pemohon?->karyawan?->Nama
                ?? $request->pemohon?->name
                ?? '-';

            $pemohonNik =
                $request->pemohon?->NIK
                ?? '';

            /*
            |--------------------------------------------------------------------------
            | PERMISSION
            |--------------------------------------------------------------------------
            */

            $isPemohon =
                (int) $request->UserPemohonID ===
                (int) auth()->id();

            $canModify =
                $isPemohon &&
                $status === 'diajukan';

            /*
            |--------------------------------------------------------------------------
            | STATUS SELESAI + SERAH TERIMA
            |--------------------------------------------------------------------------
            */

            $statusRequest = strtolower(
                (string) ($request->Status ?? '')
            );

            $isSelesai = in_array(
                $statusRequest,
                [
                    'selesai',
                    'completed',
                    'done',
                ],
                true
            );

            $isSudahSerahTerima =
                $request->SerahTerima === true;

        @endphp

        <div class="p-5 transition hover:bg-slate-50">

            {{-- Header Card --}}

            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0">

                    <a
                        href="{{ route('it-requests.show', $request) }}"
                        class="text-sm font-bold text-blue-600 hover:text-blue-800"
                    >
                        {{ $request->NoRequest }}
                    </a>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $request->created_at?->format('d M Y, H:i') }}
                    </p>

                </div>

                @if ($isSelesai)

                    @if ($isSudahSerahTerima)

                        <span
                            class="inline-flex shrink-0 items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200"
                        >
                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Sudah Diterima
                        </span>

                    @else

                        <span
                            class="inline-flex shrink-0 items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200"
                        >
                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                            Menunggu Serah Terima
                        </span>

                    @endif

                @else

                    <span
                        class="inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $getStatusClass($request->Status) }}"
                    >

                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current"></span>

                        {{ $getStatusLabel($request->Status) }}

                    </span>

                @endif

            </div>

            {{-- ====================================================
                PEMOHON
            ===================================================== --}}

            <div class="mt-4 rounded-xl border border-violet-100 bg-violet-50/50 p-3">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-violet-600">

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
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 20.25a8.25 8.25 0 0115 0"
                            />
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="text-[11px] font-semibold uppercase tracking-wider text-violet-500">
                            Pemohon
                        </p>

                        <p class="mt-0.5 truncate text-sm font-bold text-slate-800">
                            {{ $pemohonNama }}
                        </p>

                        @if ($pemohonNik)

                            <p class="mt-0.5 text-xs text-slate-500">
                                NIK: {{ $pemohonNik }}
                            </p>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Jenis --}}

            <div class="mt-4">

                <p class="mb-1.5 text-xs font-medium uppercase tracking-wider text-slate-400">
                    Jenis
                </p>

                <div class="flex flex-wrap gap-1.5">

                    @forelse ($request->jenisPermintaan as $jenis)

                        <span
                            class="inline-flex rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700 ring-1 ring-inset ring-violet-200"
                        >
                            {{ $jenis->name }}
                        </span>

                    @empty

                        <span class="text-xs text-slate-400">
                            Tidak ada jenis
                        </span>

                    @endforelse

                </div>

            </div>

            {{-- Permintaan --}}

            <div class="mt-4">

                <p class="mb-1 text-xs font-medium uppercase tracking-wider text-slate-400">
                    Permintaan
                </p>

                <p class="text-sm leading-6 text-slate-700">
                    {{ \Illuminate\Support\Str::limit($request->Permintaan, 150) }}
                </p>

            </div>

            {{-- Asset --}}

            <div class="mt-4">

                <p class="mb-1.5 text-xs font-medium uppercase tracking-wider text-slate-400">
                    Asset
                </p>

                <div class="flex flex-wrap gap-1.5">

                    @forelse ($request->assets as $asset)

                        <span
                            class="inline-flex rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-200"
                        >
                            {{ $asset->NoAssetIT }}
                        </span>

                    @empty

                        <span class="text-xs text-slate-400">
                            Tidak ada asset
                        </span>

                    @endforelse

                </div>

            </div>

            {{-- User Terkait --}}

            <div class="mt-4">

                <p class="mb-1.5 text-xs font-medium uppercase tracking-wider text-slate-400">
                    User Terkait
                </p>

                <div class="flex flex-wrap gap-1.5">

                    @forelse ($request->relatedUsers as $relatedUser)

                        @php

                            $relatedUserNama =
                                $relatedUser->karyawan?->Nama
                                ?? $relatedUser->name
                                ?? '-';

                        @endphp

                        <span
                            class="inline-flex rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-200"
                        >
                            {{ $relatedUserNama }}
                        </span>

                    @empty

                        <span class="text-xs text-slate-400">
                            Tidak ada
                        </span>

                    @endforelse

                </div>

            </div>

            {{-- MOBILE ACTIONS --}}

            <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">

                {{-- DETAIL --}}

                <a
                    href="{{ route('it-requests.show', $request) }}"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
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
                            d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>

                    Detail

                </a>

                @if ($canModify)

                    {{-- EDIT --}}

                    <a
                        href="{{ route('it-requests.edit', $request) }}"
                        class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
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

                    {{-- DELETE --}}

                    <form
                        method="POST"
                        action="{{ route('it-requests.destroy', $request) }}"
                        class="flex-1"
                        onsubmit="return confirm('Yakin ingin menghapus permintaan {{ $request->NoRequest }}? Data yang sudah dihapus tidak dapat dikembalikan.');"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2.5 text-xs font-semibold text-red-700 transition hover:bg-red-100"
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

                @endif

            </div>

            @if ($canModify)

                <div class="mt-3 flex items-start gap-2 rounded-xl bg-amber-50 px-3 py-2.5 text-xs text-amber-700">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mt-0.5 h-4 w-4 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m0 3.75h.008v.008H12V16.5z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                    <span>
                        Permintaan masih berstatus <strong>Diajukan</strong>, sehingga Anda masih dapat mengubah atau menghapusnya.
                    </span>

                </div>

            @elseif ($isPemohon)

                <div class="mt-3 rounded-xl bg-slate-50 px-3 py-2.5 text-xs text-slate-500">

                    Request sudah diproses dan tidak dapat diedit atau dihapus lagi.

                </div>

            @endif

        </div>

    @empty

        <div class="px-5 py-16 text-center">

            <div
                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                    />
                </svg>

            </div>

            <h3 class="mt-4 text-sm font-semibold text-slate-900">
                Belum ada permintaan
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Anda belum memiliki permintaan IT.
            </p>

        </div>

    @endforelse

</div>

{{-- ========================================================
    PAGINATION
========================================================= --}}

@if ($requests->hasPages())

    <div class="border-t border-slate-200 px-5 py-4 sm:px-6">

        {{ $requests->links() }}

    </div>

@endif

</div>
@endsection