@extends('layouts.layout')

@section('title', 'Buat Permintaan IT')

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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            IT Service Request

        </div>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Buat Permintaan IT
        </h1>

        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
            Sampaikan kebutuhan IT Anda dengan lengkap agar tim
            Departemen IT dapat membantu dengan lebih cepat.
        </p>

    </div>

</div>

<!-- 
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

@endif -->


<form
    method="POST"
    action="{{ route('it-requests.store') }}"
    class="space-y-6"
>

    @csrf


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
                        Jelaskan kebutuhan yang ingin Anda ajukan.
                    </p>

                </div>

            </div>

        </div>


        <div class="space-y-6 p-5 sm:p-6">


            {{-- ====================================================
                JENIS PERMINTAAN
            ===================================================== --}}

            @php

                $selectedJenisPermintaan = collect(
                    old('jenis_permintaan', [])
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


                    {{-- Dropdown --}}

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


                    {{-- Hidden Inputs --}}

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
                >{{ old('Permintaan') }}</textarea>


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
                >{{ old('Keterangan') }}</textarea>


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

                $selectedAssets = collect(
                    old('assets', [])
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


                    {{-- Dropdown --}}

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


                    {{-- Hidden Inputs --}}

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
                    Kosongkan jika request belum memiliki asset.

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
                        Pilih user yang perlu mengetahui request ini.
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


            @php

                $selectedRelatedUsers = collect(
                    old('relatedUsers', [])
                )
                    ->map(fn ($id) => (string) $id)
                    ->unique()
                    ->values()
                    ->toArray();

            @endphp


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

                        @foreach ($users as $user)

                            @continue($user->id === auth()->id())


                            @if (
                                in_array(
                                    (string) $user->id,
                                    $selectedRelatedUsers,
                                    true
                                )
                            )

                                <div
                                    class="related-user-tag inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1.5 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-200"
                                    data-tag-id="{{ $user->id }}"
                                >

                                    <span class="max-w-[220px] truncate">
                                        {{ $user->karyawan?->Nama ?? $user->name }}
                                    </span>


                                    <button
                                        type="button"
                                        data-remove-id="{{ $user->id }}"
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


                {{-- Dropdown --}}

                <div
                    id="relatedUsersDropdown"
                    class="absolute z-50 mt-2 hidden max-h-72 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg ring-1 ring-black/5"
                >

                    @foreach ($users as $user)

                        @continue($user->id === auth()->id())


                        <button
                            type="button"
                            class="related-user-option flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left transition hover:bg-slate-50"
                            data-id="{{ $user->id }}"
                            data-search="{{ strtolower(
                                ($user->NIK ?? '') . ' ' .
                                ($user->karyawan?->Nama ?? $user->name) . ' ' .
                                ($user->karyawan?->departemen?->NamaDept ?? '')
                            ) }}"
                        >

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-600"
                            >
                                {{ strtoupper(
                                    substr(
                                        $user->karyawan?->Nama ?? $user->name,
                                        0,
                                        1
                                    )
                                ) }}
                            </div>


                            <div class="min-w-0 flex-1">

                                <div class="related-user-option-name truncate text-sm font-semibold text-slate-700">
                                    {{ $user->karyawan?->Nama ?? $user->name }}
                                </div>


                                <div class="truncate text-xs text-slate-400">

                                    {{ $user->NIK ?? '-' }}

                                    @if ($user->karyawan?->departemen?->NamaDept)

                                        —
                                        {{ $user->karyawan?->departemen?->NamaDept }}

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


                {{-- Hidden Inputs --}}

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
                            d="M13 16h-1v-4h-1m1-4h.008M12 21a9 9 0 110-18 9 9 0 010-18z"
                        />
                    </svg>

                    User yang dipilih dapat melihat permintaan ini
                    secara read-only.

                </p>

            </div>

        </div>

    </div>


    {{-- ========================================================
        ACTIONS
    ========================================================= --}}

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

        <a
            href="{{ route('it-requests.index') }}"
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
                    d="M6 12h12m0 0l-4-4m4 4l-4 4"
                />
            </svg>

            Ajukan Permintaan

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
    |
    | Semua multi-select sekarang menggunakan:
    |
    | option  -> data-id
    | tag     -> data-tag-id
    | input   -> data-input-id
    |
    | Dengan demikian state antara Blade dan JavaScript selalu konsisten.
    |
    */

    function initializeMultiSelect(config) {

        const wrapper = document.getElementById(config.wrapper);
        const container = document.getElementById(config.container);
        const searchInput = document.getElementById(config.search);
        const dropdown = document.getElementById(config.dropdown);
        const tagsContainer = document.getElementById(config.tags);
        const inputsContainer = document.getElementById(config.inputs);
        const noResult = document.getElementById(config.noResult);

        const options = Array.from(
            document.querySelectorAll(config.option)
        );

        /*
        |--------------------------------------------------------------------------
        | VALIDATE ELEMENT
        |--------------------------------------------------------------------------
        */

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
        |
        | Ambil state langsung dari hidden input yang sudah dirender Blade.
        |
        */

        const selected = new Set();

        function loadInitialState() {

            const inputs = Array.from(
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
        | OPEN DROPDOWN
        |--------------------------------------------------------------------------
        */

        function openDropdown() {

            dropdown.classList.remove('hidden');

            filter();

        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE DROPDOWN
        |--------------------------------------------------------------------------
        */

        function closeDropdown() {

            dropdown.classList.add('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        function filter() {

            const keyword = searchInput.value
                .trim()
                .toLowerCase();

            let visibleCount = 0;

            options.forEach(option => {

                const searchableText =
                    String(option.dataset.search || '')
                        .toLowerCase();

                const id =
                    String(option.dataset.id);

                const matches =
                    searchableText.includes(keyword);

                option.classList.toggle(
                    'hidden',
                    !matches
                );

                const check =
                    option.querySelector(config.check);

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

            /*
            | Jangan pernah membuat input duplikat.
            */

            if (getInput(id)) {

                return;

            }


            const input =
                document.createElement('input');

            input.type = 'hidden';

            input.name =
                config.inputName;

            input.value =
                id;

            input.dataset.inputId =
                id;


            inputsContainer.appendChild(input);

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

            /*
            | Jangan membuat tag kalau sudah ada.
            */

            if (getTag(id)) {

                return;

            }


            const option =
                getOption(id);

            if (!option) {

                return;

            }


            const nameElement =
                option.querySelector(config.nameSelector);


            const name =
                nameElement
                    ? nameElement.textContent.trim()
                    : 'Item';


            const tag =
                document.createElement('div');


            tag.className =
                config.tagClass;


            /*
            | INI PENTING:
            | Tag menggunakan data-tag-id yang sama dengan
            | selector getTag().
            */

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


            /*
            | Tag selalu diletakkan sebelum search input.
            */

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


            /*
            | Kalau sudah dipilih, jangan lakukan apa-apa.
            */

            if (selected.has(id)) {

                return;

            }


            /*
            | Update state terlebih dahulu.
            */

            selected.add(id);


            /*
            | Sinkronkan hidden input.
            */

            addInput(id);


            /*
            | Sinkronkan visual tag.
            */

            createTag(id);


            /*
            | Update checkbox/checkmark.
            */

            filter();


            /*
            | Kosongkan search agar user dapat mencari item berikutnya.
            */

            searchInput.value = '';


            /*
            | Tetap fokus ke input.
            */

            searchInput.focus();


            /*
            | Dropdown tetap terbuka agar dapat memilih item berikutnya.
            */

            openDropdown();

        }


        /*
        |--------------------------------------------------------------------------
        | DESELECT
        |--------------------------------------------------------------------------
        */

        function deselect(id) {

            id = String(id);


            /*
            | Hapus dari state.
            */

            selected.delete(id);


            /*
            | Hapus hidden input.
            */

            removeInput(id);


            /*
            | Hapus tag.
            */

            removeTag(id);


            /*
            | Update checkmark.
            */

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
                        String(this.dataset.id);


                    /*
                    | Toggle:
                    |
                    | Belum dipilih -> pilih
                    | Sudah dipilih -> hapus
                    */

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
                    String(button.dataset.removeId);


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

                /*
                | Jika yang diklik adalah tombol remove,
                | jangan menjalankan focus container.
                */

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
        |
        | Penting untuk kasus:
        |
        | old('jenis_permintaan')
        | old('assets')
        | old('relatedUsers')
        |
        | State Blade langsung disinkronkan dengan checkmark.
        |
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
