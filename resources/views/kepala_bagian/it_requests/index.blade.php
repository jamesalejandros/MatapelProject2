<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Persetujuan Permintaan IT
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="min-h-screen bg-slate-100 text-slate-800">

@php

    $currentSort = request('sort', 'IDRequest');

    $currentDirection = request('direction', 'desc');

    $currentStatus = request('status', '');

@endphp

<div class="min-h-screen">

    {{-- ========================================================
        TOP NAVBAR
    ========================================================= --}}

    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex min-h-16 items-center justify-between gap-4">

                <div class="flex min-w-0 items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">

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

                    <div class="min-w-0">

                        <p class="truncate text-sm font-bold text-slate-900">
                            Persetujuan Permintaan IT
                        </p>

                        <p class="hidden text-xs text-slate-500 sm:block">
                            Panel Kepala Bagian
                        </p>

                    </div>

                </div>

                <div class="flex items-center gap-3">

                    <div class="hidden text-right sm:block">

                        <p class="text-sm font-semibold text-slate-800">
                            {{ auth('kepala_bagian')->user()->name }}
                        </p>

                        <p class="text-xs text-slate-500">
                            {{ auth('kepala_bagian')->user()->email }}
                        </p>

                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 text-sm font-bold text-white">

                        {{ strtoupper(
                            substr(
                                auth('kepala_bagian')->user()->name ?? 'K',
                                0,
                                1
                            )
                        ) }}

                    </div>

                </div>

            </div>

        </div>

    </header>


    {{-- ========================================================
        MAIN
    ========================================================= --}}

    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

        {{-- ====================================================
            FLASH MESSAGE
        ===================================================== --}}

        @if (session('success'))

            <div
                class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800"
                role="alert"
            >

                <div class="mt-0.5 shrink-0">

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

                <div class="text-sm font-medium">
                    {{ session('success') }}
                </div>

            </div>

        @endif


        @if (session('error'))

            <div
                class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800"
                role="alert"
            >

                <div class="mt-0.5 shrink-0">

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
                            d="M12 9v3.75m0 3.75h.007v.008H12V16.5z"
                        />
                    </svg>

                </div>

                <div class="text-sm font-medium">
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- ====================================================
            PAGE HEADER
        ===================================================== --}}

        <div class="mb-6">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

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

                        Approval Center

                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Permintaan IT
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Tinjau dan proses permintaan IT dari pengguna
                        yang berada di bawah tanggung jawab Anda.
                    </p>

                </div>

                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">

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

                        <p class="text-xs font-medium text-slate-500">
                            Total Ditampilkan
                        </p>

                        <p class="text-lg font-bold text-slate-900">
                            {{ $requests->total() }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- ====================================================
            FILTER CARD
        ===================================================== --}}

        <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <form
                method="GET"
                action="{{ route('kepala-bagian.it-requests.index') }}"
            >

                <div class="p-4 sm:p-5">

                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">

                        {{-- SEARCH --}}

                        <div class="lg:col-span-2">

                            <label
                                for="search"
                                class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500"
                            >
                                Cari Permintaan
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">

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
                                            d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"
                                        />
                                    </svg>

                                </div>

                                <input
                                    id="search"
                                    type="search"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="No request, nama, NIK, departemen..."
                                    class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                                >

                            </div>

                        </div>


                        {{-- STATUS APPROVAL --}}

                        <div>

                            <label
                                for="status"
                                class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500"
                            >
                                Status Approval
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                            >

                                <option value="">
                                    Semua Status
                                </option>

                                <option
                                    value="pending"
                                    @selected($currentStatus === 'pending')
                                >
                                    Menunggu Persetujuan
                                </option>

                                <option
                                    value="approved"
                                    @selected($currentStatus === 'approved')
                                >
                                    Disetujui
                                </option>

                                <option
                                    value="rejected"
                                    @selected($currentStatus === 'rejected')
                                >
                                    Ditolak
                                </option>

                            </select>

                        </div>


                        {{-- SORT --}}

                        <div>

                            <label
                                for="sort"
                                class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500"
                            >
                                Urutkan
                            </label>

                            <select
                                id="sort"
                                name="sort"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                            >

                                <option
                                    value="IDRequest"
                                    @selected($currentSort === 'IDRequest')
                                >
                                    Request Terbaru
                                </option>

                                <option
                                    value="created_at"
                                    @selected($currentSort === 'created_at')
                                >
                                    Tanggal Pengajuan
                                </option>

                                <option
                                    value="NoRequest"
                                    @selected($currentSort === 'NoRequest')
                                >
                                    Nomor Request
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-2">

                            <label
                                for="direction"
                                class="text-sm text-slate-500"
                            >
                                Arah:
                            </label>

                            <select
                                id="direction"
                                name="direction"
                                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                            >

                                <option
                                    value="desc"
                                    @selected($currentDirection === 'desc')
                                >
                                    Terbaru
                                </option>

                                <option
                                    value="asc"
                                    @selected($currentDirection === 'asc')
                                >
                                    Terlama
                                </option>

                            </select>

                        </div>

                        <div class="flex flex-col gap-2 sm:flex-row">

                            <a
                                href="{{ route('kepala-bagian.it-requests.index') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900"
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

                                Reset

                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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
                                        d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"
                                    />
                                </svg>

                                Terapkan Filter

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>


        {{-- ====================================================
            REQUEST LIST
        ===================================================== --}}

        @if ($requests->count() === 0)

            <div class="rounded-2xl border border-slate-200 bg-white px-6 py-14 text-center shadow-sm">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8"
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

                <h2 class="mt-5 text-lg font-semibold text-slate-900">
                    Tidak ada permintaan
                </h2>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                    Tidak ditemukan permintaan IT yang sesuai dengan
                    filter atau pencarian Anda.
                </p>

                @if (
                    request('search')
                    || request('status')
                )

                    <a
                        href="{{ route('kepala-bagian.it-requests.index') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        Tampilkan Semua
                    </a>

                @endif

            </div>

        @else

            {{-- =================================================
                DESKTOP TABLE
            ================================================== --}}

            <div class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:block">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    #
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Request
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Pemohon
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Jenis
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Asset
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Tanggal
                                </th>

                                <th class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">

                            @foreach ($requests as $index => $itRequest)

                                @php

                                    $approvalStatus =
                                        strtolower(
                                            $itRequest->approval?->status ?? 'pending'
                                        );

                                    $approvalLabel = match ($approvalStatus) {
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        'pending' => 'Menunggu',
                                        default => ucfirst($approvalStatus),
                                    };

                                    $approvalClass = match ($approvalStatus) {
                                        'approved' =>
                                            'bg-emerald-50 text-emerald-700 ring-emerald-200',

                                        'rejected' =>
                                            'bg-red-50 text-red-700 ring-red-200',

                                        default =>
                                            'bg-amber-50 text-amber-700 ring-amber-200',
                                    };

                                    $pemohonNama =
                                        $itRequest->pemohon?->karyawan?->Nama
                                        ?? $itRequest->pemohon?->name
                                        ?? '-';

                                    $departemen =
                                        $itRequest->pemohon?->karyawan?->departemen?->NamaDept
                                        ?? '-';

                                @endphp

                                <tr class="transition hover:bg-slate-50">

                                    {{-- NUMBER --}}

                                    <td class="whitespace-nowrap px-5 py-4 align-top text-sm font-medium text-slate-400">

                                        {{ $requests->firstItem() + $index }}

                                    </td>


                                    {{-- REQUEST --}}

                                    <td class="min-w-[180px] px-5 py-4 align-top">

                                        <a
                                            href="{{ route(
                                                'kepala-bagian.it-requests.show',
                                                $itRequest
                                            ) }}"
                                            class="font-semibold text-blue-600 hover:text-blue-800 hover:underline"
                                        >
                                            {{ $itRequest->NoRequest }}
                                        </a>

                                        <p class="mt-1 line-clamp-2 text-xs leading-5 text-slate-500">
                                            {{ \Illuminate\Support\Str::limit(
                                                $itRequest->Permintaan,
                                                90
                                            ) }}
                                        </p>

                                    </td>


                                    {{-- PEMOHON --}}

                                    <td class="min-w-[200px] px-5 py-4 align-top">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">

                                                {{ strtoupper(
                                                    substr(
                                                        $pemohonNama,
                                                        0,
                                                        1
                                                    )
                                                ) }}

                                            </div>

                                            <div class="min-w-0">

                                                <p class="font-semibold text-slate-800">
                                                    {{ $pemohonNama }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-slate-500">
                                                    NIK:
                                                    {{ $itRequest->pemohon?->NIK ?? '-' }}
                                                </p>

                                                <p class="mt-0.5 truncate text-xs text-slate-500">
                                                    {{ $departemen }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- JENIS --}}

                                    <td class="min-w-[170px] px-5 py-4 align-top">

                                        <div class="flex flex-wrap gap-1.5">

                                            @forelse (
                                                $itRequest->jenisPermintaan
                                                as $jenis
                                            )

                                                <span class="inline-flex rounded-md bg-violet-50 px-2 py-1 text-xs font-semibold text-violet-700 ring-1 ring-inset ring-violet-200">
                                                    {{ $jenis->name ?? $jenis->Nama ?? '-' }}
                                                </span>

                                            @empty

                                                <span class="text-sm text-slate-400">
                                                    -
                                                </span>

                                            @endforelse

                                        </div>

                                    </td>


                                    {{-- ASSET --}}

                                    <td class="min-w-[130px] px-5 py-4 align-top">

                                        <div class="flex flex-wrap gap-1.5">

                                            @forelse (
                                                $itRequest->assets
                                                as $asset
                                            )

                                                <span class="inline-flex rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-200">
                                                    {{ $asset->NoAssetIT }}
                                                </span>

                                            @empty

                                                <span class="text-sm text-slate-400">
                                                    -
                                                </span>

                                            @endforelse

                                        </div>

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="whitespace-nowrap px-5 py-4 align-top">

                                        <span
                                            class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $approvalClass }}"
                                        >

                                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current"></span>

                                            {{ $approvalLabel }}

                                        </span>

                                        @if ($approvalStatus === 'rejected' && filled($itRequest->approval?->catatan))

                                            <p
                                                class="mt-2 max-w-[180px] truncate text-xs text-red-600"
                                                title="{{ $itRequest->approval->catatan }}"
                                            >
                                                {{ $itRequest->approval->catatan }}
                                            </p>

                                        @endif

                                    </td>


                                    {{-- DATE --}}

                                    <td class="whitespace-nowrap px-5 py-4 align-top">

                                        <p class="text-sm font-medium text-slate-700">
                                            {{ $itRequest->created_at?->format('d M Y') ?? '-' }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            {{ $itRequest->created_at?->format('H:i') ?? '-' }}
                                        </p>

                                    </td>


                                    {{-- ACTION --}}

                                    <td class="whitespace-nowrap px-5 py-4 text-right align-top">

                                        <a
                                            href="{{ route(
                                                'kepala-bagian.it-requests.show',
                                                $itRequest
                                            ) }}"
                                            class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
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
                                                    d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6z"
                                                />
                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="2.5"
                                                />
                                            </svg>

                                            Detail

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- =================================================
                MOBILE / TABLET CARDS
            ================================================== --}}

            <div class="space-y-4 lg:hidden">

                @foreach ($requests as $index => $itRequest)

                    @php

                        $approvalStatus =
                            strtolower(
                                $itRequest->approval?->status ?? 'pending'
                            );

                        $approvalLabel = match ($approvalStatus) {
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            'pending' => 'Menunggu Persetujuan',
                            default => ucfirst($approvalStatus),
                        };

                        $approvalClass = match ($approvalStatus) {
                            'approved' =>
                                'bg-emerald-50 text-emerald-700 ring-emerald-200',

                            'rejected' =>
                                'bg-red-50 text-red-700 ring-red-200',

                            default =>
                                'bg-amber-50 text-amber-700 ring-amber-200',
                        };

                        $pemohonNama =
                            $itRequest->pemohon?->karyawan?->Nama
                            ?? $itRequest->pemohon?->name
                            ?? '-';

                        $departemen =
                            $itRequest->pemohon?->karyawan?->departemen?->NamaDept
                            ?? '-';

                    @endphp

                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="p-5">

                            <div class="flex items-start justify-between gap-4">

                                <div class="min-w-0">

                                    <p class="text-xs font-medium text-slate-400">
                                        #{{ $requests->firstItem() + $index }}
                                    </p>

                                    <a
                                        href="{{ route(
                                            'kepala-bagian.it-requests.show',
                                            $itRequest
                                        ) }}"
                                        class="mt-1 block truncate text-base font-bold text-blue-600 hover:text-blue-800"
                                    >
                                        {{ $itRequest->NoRequest }}
                                    </a>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $itRequest->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>

                                </div>

                                <span
                                    class="inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $approvalClass }}"
                                >
                                    {{ $approvalLabel }}
                                </span>

                            </div>


                            <div class="mt-5 rounded-xl bg-slate-50 p-4">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">

                                        {{ strtoupper(
                                            substr(
                                                $pemohonNama,
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>

                                    <div class="min-w-0">

                                        <p class="font-semibold text-slate-800">
                                            {{ $pemohonNama }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-500">
                                            NIK:
                                            {{ $itRequest->pemohon?->NIK ?? '-' }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-500">
                                            {{ $departemen }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="mt-4">

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Permintaan
                                </p>

                                <p class="mt-1 text-sm leading-6 text-slate-700">
                                    {{ \Illuminate\Support\Str::limit(
                                        $itRequest->Permintaan,
                                        180
                                    ) }}
                                </p>

                            </div>


                            <div class="mt-4">

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Jenis Permintaan
                                </p>

                                <div class="mt-2 flex flex-wrap gap-1.5">

                                    @forelse (
                                        $itRequest->jenisPermintaan
                                        as $jenis
                                    )

                                        <span class="rounded-md bg-violet-50 px-2 py-1 text-xs font-semibold text-violet-700 ring-1 ring-inset ring-violet-200">
                                            {{ $jenis->name ?? $jenis->Nama ?? '-' }}
                                        </span>

                                    @empty

                                        <span class="text-sm text-slate-400">
                                            -
                                        </span>

                                    @endforelse

                                </div>

                            </div>


                            @if (
                                $approvalStatus === 'rejected'
                                && filled($itRequest->approval?->catatan)
                            )

                                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3">

                                    <p class="text-xs font-semibold uppercase tracking-wider text-red-600">
                                        Catatan Penolakan
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-red-800">
                                        {{ \Illuminate\Support\Str::limit(
                                            $itRequest->approval->catatan,
                                            180
                                        ) }}
                                    </p>

                                </div>

                            @endif


                            <div class="mt-5 border-t border-slate-100 pt-4">

                                <a
                                    href="{{ route(
                                        'kepala-bagian.it-requests.show',
                                        $itRequest
                                    ) }}"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                                >

                                    Lihat Detail

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
                                            d="M5 12h14m-5-5l5 5-5 5"
                                        />
                                    </svg>

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif


        {{-- ====================================================
            PAGINATION
        ===================================================== --}}

        @if ($requests->hasPages())

            <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm sm:px-5">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <p class="text-sm text-slate-500">

                        Menampilkan

                        <span class="font-semibold text-slate-700">
                            {{ $requests->firstItem() }}
                        </span>

                        sampai

                        <span class="font-semibold text-slate-700">
                            {{ $requests->lastItem() }}
                        </span>

                        dari

                        <span class="font-semibold text-slate-700">
                            {{ $requests->total() }}
                        </span>

                        permintaan

                    </p>

                    <div>
                        {{ $requests->links() }}
                    </div>

                </div>

            </div>

        @endif


        {{-- ====================================================
            LOGOUT
        ===================================================== --}}

        <div class="mt-8 flex justify-end">

            <form
                method="POST"
                action="{{ route('kepala-bagian.logout') }}"
                onsubmit="return confirm('Yakin ingin logout?');"
            >

                @csrf

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-700"
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
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 12H9m0 0l3-3m-3 3l3 3"
                        />
                    </svg>

                    Logout

                </button>

            </form>

        </div>

    </main>

</div>

</body>

</html>
