@extends('layouts.layout')

@section('title', 'Edit Permintaan IT')

@section('content')

{{-- ============================================================
PAGE HEADER
============================================================= --}}

<div class="mb-8">
<a
    href="{{ route('it-requests.index') }}"
    class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600"
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
                d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"
            />
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
            />
        </svg>

        IT Service Request

    </div>

    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
        Edit Permintaan IT
    </h1>

    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
        Perbarui informasi permintaan IT Anda dengan lengkap agar
        tim Departemen IT dapat menindaklanjutinya dengan tepat.
    </p>

</div>

</div>
{{-- ============================================================
VALIDATION ERROR
============================================================= --}}

@if ($errors->any())

<div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5 text-red-800">

    <div class="flex items-start gap-3">

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="mt-0.5 h-5 w-5 shrink-0"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3.75m0 3.75h.008M12 3.75a8.25 8.25 0 110 16.5 8.25 8.25 0 010-16.5z"
            />
        </svg>

        <div>

            <p class="font-semibold">
                Terdapat kesalahan pada formulir.
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">

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
FORM
============================================================= --}}

<form method="POST" action="{{ route('it-requests.update', $itRequest->IDRequest) }}" class="space-y-6" >
@csrf

@method('PUT')

{{-- ========================================================
    INFORMASI PEMOHON
========================================================= --}}

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-200 bg-slate-50/70 px-5 py-5 sm:px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600">

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
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                    />
                </svg>

            </div>

            <div>

                <h2 class="font-semibold text-slate-900">
                    Informasi Pemohon
                </h2>

                <p class="text-xs text-slate-500">
                    Informasi ini diambil dari akun Anda.
                </p>

            </div>

        </div>

    </div>

    <div class="grid gap-5 p-5 sm:grid-cols-3 sm:p-6">

        <div>

            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                Pemohon
            </p>

            <p class="mt-1 font-semibold text-slate-800">
                {{ auth()->user()->karyawan?->Nama ?? auth()->user()->name }}
            </p>

        </div>

        <div>

            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                NIK
            </p>

            <p class="mt-1 font-semibold text-slate-800">
                {{ auth()->user()->NIK ?? '-' }}
            </p>

        </div>

        <div>

            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                Email
            </p>

            <p class="mt-1 break-all font-semibold text-slate-800">
                {{ auth()->user()->email }}
            </p>

        </div>

    </div>

</div>

{{-- ========================================================
    DETAIL REQUEST
========================================================= --}}

<div class="overflow-visible rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-200 bg-slate-50/70 px-5 py-5 sm:px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-600">

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
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                    />
                </svg>

            </div>

            <div>

                <h2 class="font-semibold text-slate-900">
                    Detail Permintaan
                </h2>

                <p class="text-xs text-slate-500">
                    Perbarui kebutuhan yang ingin Anda ajukan.
                </p>

            </div>

        </div>

    </div>

    <div class="space-y-6 p-5 sm:p-6">

        {{-- ====================================================
            JENIS PERMINTAAN
        ===================================================== --}}

        @php

            /*
            |--------------------------------------------------------------------------
            | Controller sudah melakukan:
            |
            | $itRequest->load([
            |     'jenisPermintaan',
            |     'assets',
            |     'relatedUsers',
            | ]);
            |
            | Jadi gunakan langsung relasi jenisPermintaan.
            |--------------------------------------------------------------------------
            */

            $existingJenisPermintaanIds =
                $itRequest->jenisPermintaan
                    ->pluck('id')
                    ->map(fn ($id) => (string) $id)
                    ->unique()
                    ->values()
                    ->toArray();

            /*
            |--------------------------------------------------------------------------
            | old() digunakan apabila validasi update gagal.
            |--------------------------------------------------------------------------
            */

            $selectedJenisPermintaan = old(
                'jenis_permintaan',
                $existingJenisPermintaanIds
            );

            $selectedJenisPermintaan = collect(
                $selectedJenisPermintaan
            )
                ->map(fn ($id) => (string) $id)
                ->unique()
                ->values()
                ->toArray();

        @endphp

        <div>

            <label
                for="jenisPermintaanSearch"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Jenis Permintaan
                <span class="text-red-500">*</span>
            </label>

            <div
                id="jenisPermintaanWrapper"
                class="relative"
            >

                <div
                    id="jenisPermintaanContainer"
                    class="min-h-[50px] w-full cursor-text rounded-xl border border-slate-300 bg-white px-3 py-2 shadow-sm transition"
                >

                    <div
                        id="jenisPermintaanTags"
                        class="flex flex-wrap items-center gap-2"
                    >

                        @foreach ($jenisPermintaans as $jenis)

                            @if (
                                in_array(
                                    (string) $jenis->id,
                                    $selectedJenisPermintaan,
                                    true
                                )
                            )

                                <div
                                    class="jenis-permintaan-tag inline-flex items-center gap-1.5 rounded-lg bg-violet-50 px-2.5 py-1.5 text-sm font-medium text-violet-700 ring-1 ring-inset ring-violet-200"
                                    data-tag-id="{{ $jenis->id }}"
                                >

                                    <span class="max-w-[220px] truncate">
                                        {{ $jenis->name }}
                                    </span>

                                    <button
                                        type="button"
                                        data-remove-id="{{ $jenis->id }}"
                                        class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md text-violet-500 transition hover:bg-violet-100 hover:text-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500"
                                        aria-label="Hapus jenis permintaan"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-3.5 w-3.5"
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

                                    </button>

                                </div>

                            @endif

                        @endforeach

                        <input
                            type="text"
                            id="jenisPermintaanSearch"
                            autocomplete="off"
                            placeholder="Cari dan pilih jenis permintaan..."
                            class="min-w-[220px] flex-1 border-0 bg-transparent px-1 py-1 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0"
                        >

                    </div>

                </div>

                <div
                    id="jenisPermintaanDropdown"
                    class="absolute z-50 mt-2 hidden max-h-72 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg ring-1 ring-black/5"
                >

                    @foreach ($jenisPermintaans as $jenis)

                        <button
                            type="button"
                            class="jenis-permintaan-option flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left transition hover:bg-slate-50"
                            data-id="{{ $jenis->id }}"
                            data-search="{{ strtolower(
                                ($jenis->name ?? '') . ' ' .
                                ($jenis->kode ?? '')
                            ) }}"
                        >

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-violet-100 text-xs font-semibold text-violet-600"
                            >
                                {{ strtoupper(substr($jenis->name ?? 'J', 0, 1)) }}
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="jenis-option-name truncate text-sm font-semibold text-slate-700">
                                    {{ $jenis->name }}
                                </div>

                                @if (!empty($jenis->kode))

                                    <div class="truncate text-xs text-slate-400">
                                        {{ $jenis->kode }}
                                    </div>

                                @endif

                            </div>

                            <svg
                                class="jenis-permintaan-check hidden h-5 w-5 shrink-0 text-violet-600"
                                xmlns="http://www.w3.org/2000/svg"
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

                        </button>

                    @endforeach

                    <div
                        id="jenisPermintaanNoResult"
                        class="hidden px-3 py-6 text-center text-sm text-slate-400"
                    >
                        Jenis permintaan tidak ditemukan.
                    </div>

                </div>

                <div id="jenisPermintaanInputs">

                    @foreach ($selectedJenisPermintaan as $jenisId)

                        <input
                            type="hidden"
                            name="jenis_permintaan[]"
                            value="{{ $jenisId }}"
                            data-input-id="{{ $jenisId }}"
                        >

                    @endforeach

                </div>

            </div>

            <p class="mt-2 text-xs text-slate-400">
                Anda dapat memilih lebih dari satu jenis permintaan.
            </p>

            @error('jenis_permintaan')

                <p class="mt-2 text-xs font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

            @error('jenis_permintaan.*')

                <p class="mt-2 text-xs font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>

        {{-- ====================================================
            PERMINTAAN
        ===================================================== --}}

        <div>

            <label
                for="Permintaan"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Permintaan
                <span class="text-red-500">*</span>
            </label>

            <textarea
                name="Permintaan"
                id="Permintaan"
                rows="5"
                required
                placeholder="Contoh: Laptop saya mengalami masalah saat booting..."
                class="block w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-700 shadow-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500"
            >{{ old('Permintaan', $itRequest->Permintaan) }}</textarea>

            <p class="mt-2 text-xs text-slate-400">
                Jelaskan permintaan atau masalah Anda secara singkat dan jelas.
            </p>

            @error('Permintaan')

                <p class="mt-2 text-xs font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>

        {{-- ====================================================
            KETERANGAN
        ===================================================== --}}

        <div>

            <label
                for="Keterangan"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Keterangan Tambahan

                <span class="font-normal text-slate-400">
                    (Opsional)
                </span>
            </label>

            <textarea
                name="Keterangan"
                id="Keterangan"
                rows="5"
                placeholder="Tambahkan informasi lain yang dapat membantu tim IT..."
                class="block w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-700 shadow-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500"
            >{{ old('Keterangan', $itRequest->Keterangan) }}</textarea>

            @error('Keterangan')

                <p class="mt-2 text-xs font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>

        {{-- ====================================================
            ASSET IT
        ===================================================== --}}

        @php

            /*
            |--------------------------------------------------------------------------
            | Controller menggunakan relasi:
            |
            | $itRequest->assets
            |
            | dan update menggunakan:
            |
            | $itRequest->assets()->sync(
            |     $validated['assets'] ?? []
            | );
            |
            | Jadi value asset adalah NoAssetIT.
            |--------------------------------------------------------------------------
            */

            $existingAssetIds = $itRequest->assets
                ->pluck('NoAssetIT')
                ->map(fn ($id) => (string) $id)
                ->unique()
                ->values()
                ->toArray();

            $selectedAssets = old(
                'assets',
                $existingAssetIds
            );

            $selectedAssets = collect(
                $selectedAssets
            )
                ->map(fn ($id) => (string) $id)
                ->unique()
                ->values()
                ->toArray();

        @endphp

        <div>

            <label
                for="assetSearch"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Asset IT

                <span class="font-normal text-slate-400">
                    (Opsional)
                </span>
            </label>

            <div
                id="assetWrapper"
                class="relative"
            >

                <div
                    id="assetContainer"
                    class="min-h-[50px] w-full cursor-text rounded-xl border border-slate-300 bg-white px-3 py-2 shadow-sm transition"
                >

                    <div
                        id="assetTags"
                        class="flex flex-wrap items-center gap-2"
                    >

                        @foreach ($assets as $asset)

                            @if (
                                in_array(
                                    (string) $asset->NoAssetIT,
                                    $selectedAssets,
                                    true
                                )
                            )

                                <div
                                    class="asset-tag inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-sm font-medium text-emerald-700 ring-1 ring-inset ring-emerald-200"
                                    data-tag-id="{{ $asset->NoAssetIT }}"
                                >

                                    <span class="max-w-[220px] truncate">

                                        {{ $asset->NoAssetIT }}

                                        —

                                        {{ $asset->Nama ?? '-' }}

                                    </span>

                                    <button
                                        type="button"
                                        data-remove-id="{{ $asset->NoAssetIT }}"
                                        class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md text-emerald-500 transition hover:bg-emerald-100 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                        aria-label="Hapus asset"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-3.5 w-3.5"
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

                                    </button>

                                </div>

                            @endif

                        @endforeach

                        <input
                            type="text"
                            id="assetSearch"
                            autocomplete="off"
                            placeholder="Cari dan pilih asset IT..."
                            class="min-w-[220px] flex-1 border-0 bg-transparent px-1 py-1 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0"
                        >

                    </div>

                </div>

                <div
                    id="assetDropdown"
                    class="absolute z-50 mt-2 hidden max-h-72 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg ring-1 ring-black/5"
                >

                    @foreach ($assets as $asset)

                        <button
                            type="button"
                            class="asset-option flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left transition hover:bg-slate-50"
                            data-id="{{ $asset->NoAssetIT }}"
                            data-search="{{ strtolower(
                                ($asset->NoAssetIT ?? '') . ' ' .
                                ($asset->Nama ?? '') . ' ' .
                                ($asset->SN ?? '') . ' ' .
                                ($asset->ComputerName ?? '')
                            ) }}"
                        >

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-semibold text-emerald-600"
                            >
                                {{ strtoupper(substr($asset->Nama ?? 'A', 0, 1)) }}
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="asset-option-name truncate text-sm font-semibold text-slate-700">
                                    {{ $asset->NoAssetIT }}
                                </div>

                                <div class="truncate text-xs text-slate-400">

                                    {{ $asset->Nama ?? '-' }}

                                    @if (!empty($asset->SN))

                                        —
                                        SN: {{ $asset->SN }}

                                    @endif

                                </div>

                            </div>

                            <svg
                                class="asset-check hidden h-5 w-5 shrink-0 text-emerald-600"
                                xmlns="http://www.w3.org/2000/svg"
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

                        </button>

                    @endforeach

                    <div
                        id="assetNoResult"
                        class="hidden px-3 py-6 text-center text-sm text-slate-400"
                    >
                        Asset IT tidak ditemukan.
                    </div>

                </div>

                <div id="assetInputs">

                    @foreach ($selectedAssets as $assetId)

                        <input
                            type="hidden"
                            name="assets[]"
                            value="{{ $assetId }}"
                            data-input-id="{{ $assetId }}"
                        >

                    @endforeach

                </div>

            </div>

            <p class="mt-2 flex items-start gap-1.5 text-xs text-slate-400">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mt-0.5 h-3.5 w-3.5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.008M12 21a9 9 0 110-18 9 9 0 010 18z"
                    />
                </svg>

                Anda dapat memilih lebih dari satu asset IT.
                Hapus semua pilihan jika request tidak memiliki asset.

            </p>

            @error('assets')

                <p class="mt-2 text-xs font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

            @error('assets.*')

                <p class="mt-2 text-xs font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>

    </div>

</div>

{{-- ========================================================
    BAGIAN TERKAIT
========================================================= --}}

@php

    /*
    |--------------------------------------------------------------------------
    | Controller sudah load:
    |
    | 'relatedUsers'
    |
    | dan update menggunakan:
    |
    | $validated['related_users'] ?? []
    |--------------------------------------------------------------------------
    */

    $existingRelatedUserIds = $itRequest->relatedUsers
        ->pluck('id')
        ->map(fn ($id) => (string) $id)
        ->reject(
            fn ($id) =>
                (int) $id === (int) auth()->id()
        )
        ->unique()
        ->values()
        ->toArray();

    $selectedRelatedUsers = old(
        'related_users',
        $existingRelatedUserIds
    );

    $selectedRelatedUsers = collect(
        $selectedRelatedUsers
    )
        ->map(fn ($id) => (string) $id)
        ->reject(
            fn ($id) =>
                (int) $id === (int) auth()->id()
        )
        ->unique()
        ->values()
        ->toArray();

@endphp

<div class="overflow-visible rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-200 bg-slate-50/70 px-5 py-5 sm:px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600">

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

            <div>

                <h2 class="font-semibold text-slate-900">
                    Bagian Terkait
                </h2>

                <p class="text-xs text-slate-500">
                    Perbarui user yang perlu mengetahui request ini.
                </p>

            </div>

        </div>

    </div>

    <div class="p-5 sm:p-6">

        <label
            for="relatedUsersSearch"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            User Terkait

            <span class="font-normal text-slate-400">
                (Opsional)
            </span>
        </label>

        <div
            id="relatedUsersWrapper"
            class="relative"
        >

            <div
                id="relatedUsersContainer"
                class="min-h-[50px] w-full cursor-text rounded-xl border border-slate-300 bg-white px-3 py-2 shadow-sm transition"
            >

                <div
                    id="relatedUsersTags"
                    class="flex flex-wrap items-center gap-2"
                >

                    @foreach ($users as $relatedUser)

                        @continue(
                            (int) $relatedUser->id ===
                            (int) auth()->id()
                        )

                        @if (
                            in_array(
                                (string) $relatedUser->id,
                                $selectedRelatedUsers,
                                true
                            )
                        )

                            <div
                                class="related-user-tag inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1.5 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-200"
                                data-tag-id="{{ $relatedUser->id }}"
                            >

                                <span class="max-w-[220px] truncate">

                                    {{ $relatedUser->karyawan?->Nama ?? $relatedUser->name }}

                                </span>

                                <button
                                    type="button"
                                    data-remove-id="{{ $relatedUser->id }}"
                                    class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md text-blue-500 transition hover:bg-blue-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    aria-label="Hapus user"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5"
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

                                </button>

                            </div>

                        @endif

                    @endforeach

                    <input
                        type="text"
                        id="relatedUsersSearch"
                        autocomplete="off"
                        placeholder="Cari dan pilih user..."
                        class="min-w-[180px] flex-1 border-0 bg-transparent px-1 py-1 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0"
                    >

                </div>

            </div>

            <div
                id="relatedUsersDropdown"
                class="absolute z-50 mt-2 hidden max-h-72 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg ring-1 ring-black/5"
            >

                @foreach ($users as $relatedUser)

                    @continue(
                        (int) $relatedUser->id ===
                        (int) auth()->id()
                    )

                    <button
                        type="button"
                        class="related-user-option flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left transition hover:bg-slate-50"
                        data-id="{{ $relatedUser->id }}"
                        data-search="{{ strtolower(
                            ($relatedUser->NIK ?? '') . ' ' .
                            ($relatedUser->karyawan?->Nama ?? $relatedUser->name) . ' ' .
                            ($relatedUser->karyawan?->departemen?->NamaDept ?? '')
                        ) }}"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-600"
                        >

                            {{ strtoupper(
                                substr(
                                    $relatedUser->karyawan?->Nama ??
                                    $relatedUser->name,
                                    0,
                                    1
                                )
                            ) }}

                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="related-user-option-name truncate text-sm font-semibold text-slate-700">

                                {{ $relatedUser->karyawan?->Nama ?? $relatedUser->name }}

                            </div>

                            <div class="truncate text-xs text-slate-400">

                                {{ $relatedUser->NIK ?? '-' }}

                                @if ($relatedUser->karyawan?->departemen?->NamaDept)

                                    —
                                    {{ $relatedUser->karyawan?->departemen?->NamaDept }}

                                @endif

                            </div>

                        </div>

                        <svg
                            class="related-user-check hidden h-5 w-5 shrink-0 text-blue-600"
                            xmlns="http://www.w3.org/2000/svg"
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

                    </button>

                @endforeach

                <div
                    id="relatedUsersNoResult"
                    class="hidden px-3 py-6 text-center text-sm text-slate-400"
                >
                    User tidak ditemukan.
                </div>

            </div>

            <div id="relatedUsersInputs">

                @foreach ($selectedRelatedUsers as $userId)

                    <input
                        type="hidden"
                        name="related_users[]"
                        value="{{ $userId }}"
                        data-input-id="{{ $userId }}"
                    >

                @endforeach

            </div>

        </div>

        <p class="mt-2 text-xs text-slate-400">
            Klik untuk memilih user. Anda dapat memilih lebih dari satu user
            dan menghapus pilihan menggunakan tombol ×.
        </p>

        <div class="mt-3 rounded-xl bg-slate-50 p-4">

            <p class="flex items-start gap-2 text-xs leading-5 text-slate-500">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mt-0.5 h-4 w-4 shrink-0 text-slate-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.008M12 21a9 9 0 110-18 9 9 0 010 18z"
                    />
                </svg>

                User yang dipilih dapat melihat permintaan ini
                secara read-only.

            </p>

        </div>

        @error('related_users')

            <p class="mt-2 text-xs font-medium text-red-600">
                {{ $message }}
            </p>

        @enderror

        @error('related_users.*')

            <p class="mt-2 text-xs font-medium text-red-600">
                {{ $message }}
            </p>

        @enderror

    </div>

</div>

{{-- ========================================================
    ACTIONS
========================================================= --}}

<div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

    <a
        href="{{ route('it-requests.show', $itRequest->IDRequest) }}"
        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2"
    >
        Batal
    </a>

    <button
        type="submit"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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
                d="M5 12h14m-7-7l7 7-7 7"
            />
        </svg>

        Simpan Perubahan

    </button>

</div>

</form>
{{-- ============================================================
INLINE JAVASCRIPT
============================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

/*
|--------------------------------------------------------------------------
| GENERIC MULTI SELECT
|--------------------------------------------------------------------------
*/

function initializeMultiSelect(config) {

    const wrapper =
        document.getElementById(config.wrapper);

    const container =
        document.getElementById(config.container);

    const searchInput =
        document.getElementById(config.search);

    const dropdown =
        document.getElementById(config.dropdown);

    const tagsContainer =
        document.getElementById(config.tags);

    const inputsContainer =
        document.getElementById(config.inputs);

    const noResult =
        document.getElementById(config.noResult);

    const options =
        Array.from(
            document.querySelectorAll(config.option)
        );

    if (
        !wrapper ||
        !container ||
        !searchInput ||
        !dropdown ||
        !tagsContainer ||
        !inputsContainer
    ) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    const selected = new Set();

    /*
    |--------------------------------------------------------------------------
    | LOAD EXISTING HIDDEN INPUT
    |--------------------------------------------------------------------------
    */

    function loadInitialState() {

        const inputs =
            Array.from(
                inputsContainer.querySelectorAll(
                    'input[data-input-id]'
                )
            );

        inputs.forEach(input => {

            selected.add(
                String(input.dataset.inputId)
            );

        });

    }

    loadInitialState();

    /*
    |--------------------------------------------------------------------------
    | GET OPTION
    |--------------------------------------------------------------------------
    */

    function getOption(id) {

        id = String(id);

        return options.find(option => {

            return String(option.dataset.id) === id;

        }) || null;

    }

    /*
    |--------------------------------------------------------------------------
    | GET TAG
    |--------------------------------------------------------------------------
    */

    function getTag(id) {

        id = String(id);

        return Array.from(
            tagsContainer.querySelectorAll(
                '[data-tag-id]'
            )
        ).find(tag => {

            return String(tag.dataset.tagId) === id;

        }) || null;

    }

    /*
    |--------------------------------------------------------------------------
    | GET INPUT
    |--------------------------------------------------------------------------
    */

    function getInput(id) {

        id = String(id);

        return Array.from(
            inputsContainer.querySelectorAll(
                'input[data-input-id]'
            )
        ).find(input => {

            return String(input.dataset.inputId) === id;

        }) || null;

    }

    /*
    |--------------------------------------------------------------------------
    | DROPDOWN
    |--------------------------------------------------------------------------
    */

    function openDropdown() {

        dropdown.classList.remove('hidden');

        filter();

    }

    function closeDropdown() {

        dropdown.classList.add('hidden');

    }

    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    function filter() {

        const keyword =
            searchInput.value
                .trim()
                .toLowerCase();

        let visibleCount = 0;

        options.forEach(option => {

            const searchableText =
                String(
                    option.dataset.search || ''
                ).toLowerCase();

            const id =
                String(
                    option.dataset.id
                );

            const matches =
                searchableText.includes(keyword);

            option.classList.toggle(
                'hidden',
                !matches
            );

            const check =
                option.querySelector(
                    config.check
                );

            if (check) {

                check.classList.toggle(
                    'hidden',
                    !selected.has(id)
                );

            }

            if (matches) {

                visibleCount++;

            }

        });

        if (noResult) {

            noResult.classList.toggle(
                'hidden',
                visibleCount > 0
            );

        }

    }

    /*
    |--------------------------------------------------------------------------
    | ADD HIDDEN INPUT
    |--------------------------------------------------------------------------
    */

    function addInput(id) {

        id = String(id);

        if (getInput(id)) {

            return;

        }

        const input =
            document.createElement('input');

        input.type =
            'hidden';

        input.name =
            config.inputName;

        input.value =
            id;

        input.dataset.inputId =
            id;

        inputsContainer.appendChild(
            input
        );

    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE HIDDEN INPUT
    |--------------------------------------------------------------------------
    */

    function removeInput(id) {

        const input =
            getInput(id);

        if (input) {

            input.remove();

        }

    }

    /*
    |--------------------------------------------------------------------------
    | CREATE TAG
    |--------------------------------------------------------------------------
    */

    function createTag(id) {

        id = String(id);

        if (getTag(id)) {

            return;

        }

        const option =
            getOption(id);

        if (!option) {

            return;

        }

        const nameElement =
            option.querySelector(
                config.nameSelector
            );

        const name =
            nameElement
                ? nameElement.textContent.trim()
                : 'Item';

        const tag =
            document.createElement('div');

        tag.className =
            config.tagClass;

        tag.dataset.tagId =
            id;

        const span =
            document.createElement('span');

        span.className =
            'max-w-[220px] truncate';

        span.textContent =
            name;

        const button =
            document.createElement('button');

        button.type =
            'button';

        button.dataset.removeId =
            id;

        button.className =
            config.removeButtonClass;

        button.setAttribute(
            'aria-label',
            'Hapus pilihan'
        );

        button.innerHTML = `
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-3.5 w-3.5"
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
        `;

        tag.appendChild(span);

        tag.appendChild(button);

        tagsContainer.insertBefore(
            tag,
            searchInput
        );

    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE TAG
    |--------------------------------------------------------------------------
    */

    function removeTag(id) {

        const tag =
            getTag(id);

        if (tag) {

            tag.remove();

        }

    }

    /*
    |--------------------------------------------------------------------------
    | SELECT
    |--------------------------------------------------------------------------
    */

    function select(id) {

        id = String(id);

        if (selected.has(id)) {

            return;

        }

        selected.add(id);

        addInput(id);

        createTag(id);

        searchInput.value = '';

        filter();

        searchInput.focus();

        openDropdown();

    }

    /*
    |--------------------------------------------------------------------------
    | DESELECT
    |--------------------------------------------------------------------------
    */

    function deselect(id) {

        id = String(id);

        selected.delete(id);

        removeInput(id);

        removeTag(id);

        filter();

    }

    /*
    |--------------------------------------------------------------------------
    | OPTION CLICK
    |--------------------------------------------------------------------------
    */

    options.forEach(option => {

        option.addEventListener(
            'click',
            function (event) {

                event.preventDefault();

                const id =
                    String(
                        this.dataset.id
                    );

                if (selected.has(id)) {

                    deselect(id);

                } else {

                    select(id);

                }

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | REMOVE TAG CLICK
    |--------------------------------------------------------------------------
    */

    tagsContainer.addEventListener(
        'click',
        function (event) {

            const button =
                event.target.closest(
                    '[data-remove-id]'
                );

            if (!button) {

                return;

            }

            event.preventDefault();

            event.stopPropagation();

            const id =
                String(
                    button.dataset.removeId
                );

            deselect(id);

            searchInput.focus();

            openDropdown();

        }
    );

    /*
    |--------------------------------------------------------------------------
    | SEARCH INPUT
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener(
        'input',
        function () {

            openDropdown();

        }
    );

    searchInput.addEventListener(
        'focus',
        function () {

            openDropdown();

        }
    );

    /*
    |--------------------------------------------------------------------------
    | CONTAINER CLICK
    |--------------------------------------------------------------------------
    */

    container.addEventListener(
        'click',
        function (event) {

            if (
                event.target.closest(
                    '[data-remove-id]'
                )
            ) {

                return;

            }

            searchInput.focus();

            openDropdown();

        }
    );

    /*
    |--------------------------------------------------------------------------
    | KEYBOARD
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape'
            ) {

                closeDropdown();

                searchInput.blur();

            }

        }
    );

    /*
    |--------------------------------------------------------------------------
    | OUTSIDE CLICK
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !wrapper.contains(
                    event.target
                )
            ) {

                closeDropdown();

            }

        }
    );

    /*
    |--------------------------------------------------------------------------
    | INITIAL RENDER
    |--------------------------------------------------------------------------
    */

    filter();

}

/*
|--------------------------------------------------------------------------
| JENIS PERMINTAAN
|--------------------------------------------------------------------------
*/

initializeMultiSelect({

    wrapper:
        'jenisPermintaanWrapper',

    container:
        'jenisPermintaanContainer',

    search:
        'jenisPermintaanSearch',

    dropdown:
        'jenisPermintaanDropdown',

    tags:
        'jenisPermintaanTags',

    inputs:
        'jenisPermintaanInputs',

    noResult:
        'jenisPermintaanNoResult',

    option:
        '.jenis-permintaan-option',

    check:
        '.jenis-permintaan-check',

    inputName:
        'jenis_permintaan[]',

    nameSelector:
        '.jenis-option-name',

    tagClass:
        'jenis-permintaan-tag inline-flex items-center gap-1.5 rounded-lg bg-violet-50 px-2.5 py-1.5 text-sm font-medium text-violet-700 ring-1 ring-inset ring-violet-200',

    removeButtonClass:
        'inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md text-violet-500 transition hover:bg-violet-100 hover:text-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500'

});

/*
|--------------------------------------------------------------------------
| ASSET IT
|--------------------------------------------------------------------------
*/

initializeMultiSelect({

    wrapper:
        'assetWrapper',

    container:
        'assetContainer',

    search:
        'assetSearch',

    dropdown:
        'assetDropdown',

    tags:
        'assetTags',

    inputs:
        'assetInputs',

    noResult:
        'assetNoResult',

    option:
        '.asset-option',

    check:
        '.asset-check',

    inputName:
        'assets[]',

    nameSelector:
        '.asset-option-name',

    tagClass:
        'asset-tag inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-sm font-medium text-emerald-700 ring-1 ring-inset ring-emerald-200',

    removeButtonClass:
        'inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md text-emerald-500 transition hover:bg-emerald-100 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500'

});

/*
|--------------------------------------------------------------------------
| USER TERKAIT
|--------------------------------------------------------------------------
*/

initializeMultiSelect({

    wrapper:
        'relatedUsersWrapper',

    container:
        'relatedUsersContainer',

    search:
        'relatedUsersSearch',

    dropdown:
        'relatedUsersDropdown',

    tags:
        'relatedUsersTags',

    inputs:
        'relatedUsersInputs',

    noResult:
        'relatedUsersNoResult',

    option:
        '.related-user-option',

    check:
        '.related-user-check',

    inputName:
        'related_users[]',

    nameSelector:
        '.related-user-option-name',

    tagClass:
        'related-user-tag inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1.5 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-200',

    removeButtonClass:
        'inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md text-blue-500 transition hover:bg-blue-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500'

});

});

</script>
@endsection