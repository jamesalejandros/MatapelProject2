@extends('layouts.layout')

@section('title', 'Edit Permintaan IT')

@section('content')

<div class="mb-6"> <a href="{{ route('it-requests.show', $itRequest->IDRequest) }}" class="text-sm text-slate-500 hover:text-blue-600" > ← Kembali </a>
<h1 class="mt-3 text-2xl font-bold text-slate-900">
    Edit Permintaan IT
</h1>

<p class="mt-1 text-sm text-slate-500">
    Perbarui informasi permintaan IT Anda.
</p>

</div>
@if ($errors->any())
<div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
<p class="font-semibold">Terdapat kesalahan pada formulir:</p>

    <ul class="mt-2 list-disc pl-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

@endif

@php
/*
|--------------------------------------------------------------------------
| JENIS PERMINTAAN
|--------------------------------------------------------------------------
*/

$existingJenisPermintaanIds = $itRequest->jenisPermintaan
    ->pluck('id')
    ->map(fn ($id) => (string) $id)
    ->unique()
    ->values()
    ->toArray();

$selectedJenisPermintaan = old(
    'jenis_permintaan',
    $existingJenisPermintaanIds
);

$selectedJenisPermintaan = collect($selectedJenisPermintaan)
    ->map(fn ($id) => (string) $id)
    ->unique()
    ->values()
    ->toArray();

/*
|--------------------------------------------------------------------------
| ASSET
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

$selectedAssets = collect($selectedAssets)
    ->map(fn ($id) => (string) $id)
    ->unique()
    ->values()
    ->toArray();

/*
|--------------------------------------------------------------------------
| USER TERKAIT
|--------------------------------------------------------------------------
*/

$existingRelatedUserIds = $itRequest->relatedUsers
    ->pluck('id')
    ->map(fn ($id) => (string) $id)
    ->reject(fn ($id) => (int) $id === (int) auth()->id())
    ->unique()
    ->values()
    ->toArray();

$selectedRelatedUsers = old(
    'related_users',
    $existingRelatedUserIds
);

$selectedRelatedUsers = collect($selectedRelatedUsers)
    ->map(fn ($id) => (string) $id)
    ->reject(fn ($id) => (int) $id === (int) auth()->id())
    ->unique()
    ->values()
    ->toArray();

@endphp

<form method="POST" action="{{ route('it-requests.update', $itRequest->IDRequest) }}" class="space-y-6" > @csrf @method('PUT')
{{-- =========================================================
    INFORMASI PEMOHON
========================================================== --}}

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <h2 class="text-base font-semibold text-slate-900">
        Informasi Pemohon
    </h2>

    <div class="mt-4 grid gap-4 sm:grid-cols-3">
        <div>
            <p class="text-xs text-slate-500">Pemohon</p>
            <p class="mt-1 font-medium text-slate-800">
                {{ auth()->user()->karyawan?->Nama ?? auth()->user()->name }}
            </p>
        </div>

        <div>
            <p class="text-xs text-slate-500">NIK</p>
            <p class="mt-1 font-medium text-slate-800">
                {{ auth()->user()->NIK ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-xs text-slate-500">Email</p>
            <p class="mt-1 break-all font-medium text-slate-800">
                {{ auth()->user()->email }}
            </p>
        </div>
    </div>
</div>

{{-- =========================================================
    DETAIL PERMINTAAN
========================================================== --}}

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <h2 class="text-base font-semibold text-slate-900">
        Detail Permintaan
    </h2>

    <div class="mt-5 space-y-5">

        {{-- JENIS PERMINTAAN --}}

        <div>
            <label
                for="jenisPermintaanSearch"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Jenis Permintaan
                <span class="text-red-500">*</span>
            </label>

            <div id="jenisPermintaanWrapper" class="relative">

                <div
                    id="jenisPermintaanContainer"
                    class="min-h-[48px] cursor-text rounded-lg border border-slate-300 bg-white px-3 py-2"
                >
                    <div
                        id="jenisPermintaanTags"
                        class="flex flex-wrap items-center gap-2"
                    >
                        @foreach ($jenisPermintaans as $jenis)
                            @if (in_array((string) $jenis->id, $selectedJenisPermintaan, true))
                                <div
                                    class="jenis-permintaan-tag inline-flex items-center gap-2 rounded-md bg-violet-50 px-2 py-1 text-sm text-violet-700"
                                    data-tag-id="{{ $jenis->id }}"
                                >
                                    <span class="max-w-[220px] truncate">
                                        {{ $jenis->name }}
                                    </span>

                                    <button
                                        type="button"
                                        data-remove-id="{{ $jenis->id }}"
                                        class="text-violet-500 hover:text-violet-700"
                                    >
                                        ×
                                    </button>
                                </div>
                            @endif
                        @endforeach

                        <input
                            type="text"
                            id="jenisPermintaanSearch"
                            autocomplete="off"
                            placeholder="Cari jenis permintaan..."
                            class="min-w-[180px] flex-1 border-0 bg-transparent py-1 text-sm outline-none focus:ring-0"
                        >
                    </div>
                </div>

                <div
                    id="jenisPermintaanDropdown"
                    class="absolute z-50 mt-1 hidden max-h-64 w-full overflow-y-auto rounded-lg border border-slate-200 bg-white p-1 shadow-lg"
                >
                    @foreach ($jenisPermintaans as $jenis)
                        <button
                            type="button"
                            class="jenis-permintaan-option flex w-full items-center justify-between rounded-md px-3 py-2 text-left hover:bg-slate-50"
                            data-id="{{ $jenis->id }}"
                            data-search="{{ strtolower(($jenis->name ?? '') . ' ' . ($jenis->kode ?? '')) }}"
                        >
                            <span class="min-w-0">
                                <span class="jenis-option-name block truncate text-sm font-medium text-slate-700">
                                    {{ $jenis->name }}
                                </span>

                                @if (!empty($jenis->kode))
                                    <span class="block text-xs text-slate-400">
                                        {{ $jenis->kode }}
                                    </span>
                                @endif
                            </span>

                            <span class="jenis-permintaan-check hidden text-violet-600">
                                ✓
                            </span>
                        </button>
                    @endforeach

                    <div
                        id="jenisPermintaanNoResult"
                        class="hidden px-3 py-4 text-center text-sm text-slate-400"
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

            @error('jenis_permintaan')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            @error('jenis_permintaan.*')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- PERMINTAAN --}}

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
                placeholder="Jelaskan permintaan atau masalah Anda..."
                class="block w-full rounded-lg border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
            >{{ old('Permintaan', $itRequest->Permintaan) }}</textarea>

            @error('Permintaan')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- KETERANGAN --}}

        <div>
            <label
                for="Keterangan"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Keterangan
                <span class="font-normal text-slate-400">(Opsional)</span>
            </label>

            <textarea
                name="Keterangan"
                id="Keterangan"
                rows="4"
                placeholder="Tambahkan keterangan jika diperlukan..."
                class="block w-full rounded-lg border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
            >{{ old('Keterangan', $itRequest->Keterangan) }}</textarea>

            @error('Keterangan')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- ASSET --}}

        <div>
            <label
                for="assetSearch"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Asset IT
                <span class="font-normal text-slate-400">(Opsional)</span>
            </label>

            <div id="assetWrapper" class="relative">

                <div
                    id="assetContainer"
                    class="min-h-[48px] cursor-text rounded-lg border border-slate-300 bg-white px-3 py-2"
                >
                    <div
                        id="assetTags"
                        class="flex flex-wrap items-center gap-2"
                    >
                        @foreach ($assets as $asset)
                            @if (in_array((string) $asset->NoAssetIT, $selectedAssets, true))
                                <div
                                    class="asset-tag inline-flex items-center gap-2 rounded-md bg-emerald-50 px-2 py-1 text-sm text-emerald-700"
                                    data-tag-id="{{ $asset->NoAssetIT }}"
                                >
                                    <span class="max-w-[240px] truncate">
                                        {{ $asset->NoAssetIT }} — {{ $asset->Nama ?? '-' }}
                                    </span>

                                    <button
                                        type="button"
                                        data-remove-id="{{ $asset->NoAssetIT }}"
                                        class="text-emerald-500 hover:text-emerald-700"
                                    >
                                        ×
                                    </button>
                                </div>
                            @endif
                        @endforeach

                        <input
                            type="text"
                            id="assetSearch"
                            autocomplete="off"
                            placeholder="Cari asset IT..."
                            class="min-w-[180px] flex-1 border-0 bg-transparent py-1 text-sm outline-none focus:ring-0"
                        >
                    </div>
                </div>

                <div
                    id="assetDropdown"
                    class="absolute z-50 mt-1 hidden max-h-64 w-full overflow-y-auto rounded-lg border border-slate-200 bg-white p-1 shadow-lg"
                >
                    @foreach ($assets as $asset)
                        <button
                            type="button"
                            class="asset-option flex w-full items-center justify-between rounded-md px-3 py-2 text-left hover:bg-slate-50"
                            data-id="{{ $asset->NoAssetIT }}"
                            data-search="{{ strtolower(($asset->NoAssetIT ?? '') . ' ' . ($asset->Nama ?? '') . ' ' . ($asset->SN ?? '') . ' ' . ($asset->ComputerName ?? '')) }}"
                        >
                            <span class="min-w-0">
                                <span class="asset-option-name block truncate text-sm font-medium text-slate-700">
                                    {{ $asset->NoAssetIT }}
                                </span>

                                <span class="block truncate text-xs text-slate-400">
                                    {{ $asset->Nama ?? '-' }}

                                    @if (!empty($asset->SN))
                                        — SN: {{ $asset->SN }}
                                    @endif
                                </span>
                            </span>

                            <span class="asset-check hidden text-emerald-600">
                                ✓
                            </span>
                        </button>
                    @endforeach

                    <div
                        id="assetNoResult"
                        class="hidden px-3 py-4 text-center text-sm text-slate-400"
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

            @error('assets')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            @error('assets.*')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

    </div>
</div>

{{-- =========================================================
    USER TERKAIT
========================================================== --}}

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <h2 class="text-base font-semibold text-slate-900">
        User Terkait
    </h2>

    <p class="mt-1 text-sm text-slate-500">
        Pilih user yang perlu mengetahui request ini.
    </p>

    <div class="mt-5">
        <label
            for="relatedUsersSearch"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            User Terkait
            <span class="font-normal text-slate-400">(Opsional)</span>
        </label>

        <div id="relatedUsersWrapper" class="relative">

            <div
                id="relatedUsersContainer"
                class="min-h-[48px] cursor-text rounded-lg border border-slate-300 bg-white px-3 py-2"
            >
                <div
                    id="relatedUsersTags"
                    class="flex flex-wrap items-center gap-2"
                >
                    @foreach ($users as $relatedUser)
                        @if (in_array((string) $relatedUser->id, $selectedRelatedUsers, true))
                            <div
                                class="related-user-tag inline-flex items-center gap-2 rounded-md bg-blue-50 px-2 py-1 text-sm text-blue-700"
                                data-tag-id="{{ $relatedUser->id }}"
                            >
                                <span class="max-w-[240px] truncate">
                                    {{ $relatedUser->karyawan?->Nama ?? $relatedUser->name }}
                                </span>

                                <button
                                    type="button"
                                    data-remove-id="{{ $relatedUser->id }}"
                                    class="text-blue-500 hover:text-blue-700"
                                >
                                    ×
                                </button>
                            </div>
                        @endif
                    @endforeach

                    <input
                        type="text"
                        id="relatedUsersSearch"
                        autocomplete="off"
                        placeholder="Cari user..."
                        class="min-w-[180px] flex-1 border-0 bg-transparent py-1 text-sm outline-none focus:ring-0"
                    >
                </div>
            </div>

            <div
                id="relatedUsersDropdown"
                class="absolute z-50 mt-1 hidden max-h-64 w-full overflow-y-auto rounded-lg border border-slate-200 bg-white p-1 shadow-lg"
            >
                @foreach ($users as $relatedUser)
                    <button
                        type="button"
                        class="related-user-option flex w-full items-center justify-between rounded-md px-3 py-2 text-left hover:bg-slate-50"
                        data-id="{{ $relatedUser->id }}"
                        data-search="{{ strtolower(($relatedUser->NIK ?? '') . ' ' . ($relatedUser->karyawan?->Nama ?? $relatedUser->name) . ' ' . ($relatedUser->karyawan?->departemen?->NamaDept ?? '')) }}"
                    >
                        <span class="min-w-0">
                            <span class="related-user-option-name block truncate text-sm font-medium text-slate-700">
                                {{ $relatedUser->karyawan?->Nama ?? $relatedUser->name }}
                            </span>

                            <span class="block truncate text-xs text-slate-400">
                                {{ $relatedUser->NIK ?? '-' }}

                                @if ($relatedUser->karyawan?->departemen?->NamaDept)
                                    — {{ $relatedUser->karyawan?->departemen?->NamaDept }}
                                @endif
                            </span>
                        </span>

                        <span class="related-user-check hidden text-blue-600">
                            ✓
                        </span>
                    </button>
                @endforeach

                <div
                    id="relatedUsersNoResult"
                    class="hidden px-3 py-4 text-center text-sm text-slate-400"
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

        @error('related_users')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

        @error('related_users.*')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>
</div>

{{-- =========================================================
    ACTION
========================================================== --}}

<div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a
        href="{{ route('it-requests.show', $itRequest->IDRequest) }}"
        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
    >
        Batal
    </a>

    <button
        type="submit"
        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
    >
        Simpan Perubahan
    </button>
</div>

</form> <script> document.addEventListener('DOMContentLoaded', function () {
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

    const selected = new Set();

    /*
    |--------------------------------------------------------------------------
    | INITIAL STATE
    |--------------------------------------------------------------------------
    */

    inputsContainer
        .querySelectorAll('input[data-input-id]')
        .forEach(input => {
            selected.add(String(input.dataset.inputId));
        });

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    function getOption(id) {
        return options.find(option =>
            String(option.dataset.id) === String(id)
        );
    }

    function getTag(id) {
        return Array.from(
            tagsContainer.querySelectorAll('[data-tag-id]')
        ).find(tag =>
            String(tag.dataset.tagId) === String(id)
        );
    }

    function getInput(id) {
        return Array.from(
            inputsContainer.querySelectorAll('input[data-input-id]')
        ).find(input =>
            String(input.dataset.inputId) === String(id)
        );
    }

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

        const keyword = searchInput.value
            .trim()
            .toLowerCase();

        let visibleCount = 0;

        options.forEach(option => {

            const text = String(
                option.dataset.search || ''
            ).toLowerCase();

            const matches = text.includes(keyword);

            option.classList.toggle(
                'hidden',
                !matches
            );

            const check = option.querySelector(config.check);

            if (check) {
                check.classList.toggle(
                    'hidden',
                    !selected.has(String(option.dataset.id))
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
    | INPUT
    |--------------------------------------------------------------------------
    */

    function addInput(id) {

        id = String(id);

        if (getInput(id)) {
            return;
        }

        const input = document.createElement('input');

        input.type = 'hidden';
        input.name = config.inputName;
        input.value = id;
        input.dataset.inputId = id;

        inputsContainer.appendChild(input);
    }

    function removeInput(id) {

        const input = getInput(id);

        if (input) {
            input.remove();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | TAG
    |--------------------------------------------------------------------------
    */

    function createTag(id) {

        id = String(id);

        if (getTag(id)) {
            return;
        }

        const option = getOption(id);

        if (!option) {
            return;
        }

        const nameElement = option.querySelector(
            config.nameSelector
        );

        const name = nameElement
            ? nameElement.textContent.trim()
            : 'Item';

        const tag = document.createElement('div');

        tag.className = config.tagClass;
        tag.dataset.tagId = id;

        const span = document.createElement('span');

        span.className = 'max-w-[240px] truncate';
        span.textContent = name;

        const button = document.createElement('button');

        button.type = 'button';
        button.dataset.removeId = id;
        button.className = config.removeButtonClass;
        button.textContent = '×';
        button.setAttribute(
            'aria-label',
            'Hapus pilihan'
        );

        tag.appendChild(span);
        tag.appendChild(button);

        tagsContainer.insertBefore(
            tag,
            searchInput
        );
    }

    function removeTag(id) {

        const tag = getTag(id);

        if (tag) {
            tag.remove();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SELECT / DESELECT
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
    }

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

        option.addEventListener('click', function (event) {

            event.preventDefault();

            const id = String(this.dataset.id);

            if (selected.has(id)) {
                deselect(id);
            } else {
                select(id);
            }

            openDropdown();
        });
    });

    /*
    |--------------------------------------------------------------------------
    | REMOVE TAG
    |--------------------------------------------------------------------------
    */

    tagsContainer.addEventListener('click', function (event) {

        const button = event.target.closest(
            '[data-remove-id]'
        );

        if (!button) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        deselect(
            String(button.dataset.removeId)
        );

        searchInput.focus();

        openDropdown();
    });

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener('input', function () {
        openDropdown();
    });

    searchInput.addEventListener('focus', function () {
        openDropdown();
    });

    container.addEventListener('click', function (event) {

        if (event.target.closest('[data-remove-id]')) {
            return;
        }

        searchInput.focus();
        openDropdown();
    });

    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeDropdown();
            searchInput.blur();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | OUTSIDE CLICK
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        if (!wrapper.contains(event.target)) {
            closeDropdown();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | INITIAL FILTER
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
    wrapper: 'jenisPermintaanWrapper',
    container: 'jenisPermintaanContainer',
    search: 'jenisPermintaanSearch',
    dropdown: 'jenisPermintaanDropdown',
    tags: 'jenisPermintaanTags',
    inputs: 'jenisPermintaanInputs',
    noResult: 'jenisPermintaanNoResult',
    option: '.jenis-permintaan-option',
    check: '.jenis-permintaan-check',
    inputName: 'jenis_permintaan[]',
    nameSelector: '.jenis-option-name',

    tagClass:
        'jenis-permintaan-tag inline-flex items-center gap-2 rounded-md bg-violet-50 px-2 py-1 text-sm text-violet-700',

    removeButtonClass:
        'text-violet-500 hover:text-violet-700'
});

/*
|--------------------------------------------------------------------------
| ASSET
|--------------------------------------------------------------------------
*/

initializeMultiSelect({
    wrapper: 'assetWrapper',
    container: 'assetContainer',
    search: 'assetSearch',
    dropdown: 'assetDropdown',
    tags: 'assetTags',
    inputs: 'assetInputs',
    noResult: 'assetNoResult',
    option: '.asset-option',
    check: '.asset-check',
    inputName: 'assets[]',
    nameSelector: '.asset-option-name',

    tagClass:
        'asset-tag inline-flex items-center gap-2 rounded-md bg-emerald-50 px-2 py-1 text-sm text-emerald-700',

    removeButtonClass:
        'text-emerald-500 hover:text-emerald-700'
});

/*
|--------------------------------------------------------------------------
| USER TERKAIT
|--------------------------------------------------------------------------
*/

initializeMultiSelect({
    wrapper: 'relatedUsersWrapper',
    container: 'relatedUsersContainer',
    search: 'relatedUsersSearch',
    dropdown: 'relatedUsersDropdown',
    tags: 'relatedUsersTags',
    inputs: 'relatedUsersInputs',
    noResult: 'relatedUsersNoResult',
    option: '.related-user-option',
    check: '.related-user-check',
    inputName: 'related_users[]',
    nameSelector: '.related-user-option-name',

    tagClass:
        'related-user-tag inline-flex items-center gap-2 rounded-md bg-blue-50 px-2 py-1 text-sm text-blue-700',

    removeButtonClass:
        'text-blue-500 hover:text-blue-700'
});

});
</script>

@endsection