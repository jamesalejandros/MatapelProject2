@extends('layouts.layout')

@section('content')

<div class="container mx-auto px-4 py-4">
{{-- =========================================================
     HEADER
========================================================== --}}

<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">

    <div>
        <h4 class="mb-1 text-xl font-semibold">
            Catatan Request
        </h4>

        <div class="text-gray-500">
            {{ $itRequest->NoRequest }}
        </div>
    </div>

    <a href="{{ route('it-requests.index') }}">
        Kembali ke Permintaan IT
    </a>


</div>

<!-- 
{{-- =========================================================
     FLASH MESSAGE
========================================================== --}}

@if(session('success'))

    <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
        {{ session('success') }}
    </div>

@endif -->


{{-- =========================================================
     VALIDATION ERROR
========================================================== --}}

@if($errors->any())

    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<div class="grid grid-cols-1 gap-4 lg:grid-cols-12">

    {{-- =====================================================
         DETAIL REQUEST
    ====================================================== --}}

    <div class="lg:col-span-5">

        <div class="overflow-hidden rounded-lg bg-white shadow-sm">

            <div class="border-b bg-gray-50 px-4 py-3">
                <strong>Detail Permintaan</strong>
            </div>

            <div class="px-4 py-4">

                <div class="mb-3">

                    <label class="block text-sm text-gray-500">
                        Nomor Request
                    </label>

                    <div class="font-semibold">
                        {{ $itRequest->NoRequest }}
                    </div>

                </div>


                <div class="mb-3">

                    <label class="block text-sm text-gray-500">
                        Pemohon
                    </label>

                    <div>
                        {{ $itRequest->pemohon?->name ?? '-' }}
                    </div>

                </div>


                <div class="mb-3">

                    <label class="block text-sm text-gray-500">
                        Status
                    </label>

                    <div>
                        {{ $itRequest->Status }}
                    </div>

                </div>


                <div class="mb-3">

                    <label class="block text-sm text-gray-500">
                        Permintaan
                    </label>

                    <div>
                        {!! nl2br(e($itRequest->Permintaan)) !!}
                    </div>

                </div>


                @if($itRequest->Keterangan)

                    <div class="mb-3">

                        <label class="block text-sm text-gray-500">
                            Keterangan
                        </label>

                        <div>
                            {!! nl2br(e($itRequest->Keterangan)) !!}
                        </div>

                    </div>

                @endif

            </div>

        </div>


        {{-- =================================================
             RELATED USERS
        ================================================== --}}

        <div class="mt-4 overflow-hidden rounded-lg bg-white shadow-sm">

            <div class="border-b bg-gray-50 px-4 py-3">
                <strong>User Terkait</strong>
            </div>

            <div class="px-4 py-4">

                @forelse($itRequest->relatedUsers as $relatedUser)

                    <div class="mb-2 flex items-center">

                        <div>

                            <div class="font-semibold">
                                {{ $relatedUser->name }}
                            </div>

                            <div class="text-sm text-gray-500">
                                {{ $relatedUser->email }}
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-gray-500">
                        Tidak ada user terkait.
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- =====================================================
         CATATAN
    ====================================================== --}}

    <div class="lg:col-span-7">

        {{-- =================================================
             FORM CATATAN
        ================================================== --}}

        <div class="mb-4 overflow-hidden rounded-lg bg-white shadow-sm">

            <div class="border-b bg-gray-50 px-4 py-3">

                <strong>
                    Berikan Catatan
                </strong>

            </div>

            <div class="px-4 py-4">

                <form
                    action="{{ route(
                        'it-requests.related-user-notes.store',
                        $itRequest
                    ) }}"
                    method="POST"
                >

                    @csrf

                    <div class="mb-3">

                        <label
                            for="catatan"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Catatan
                        </label>

                        <textarea
                            name="catatan"
                            id="catatan"
                            rows="5"
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @error('catatan') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                            placeholder="Tuliskan catatan atau informasi terkait request ini..."
                            required
                        >{{ old('catatan') }}</textarea>

                        @error('catatan')

                            <div class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="flex justify-end">

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        >
                            Simpan Catatan
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- =================================================
             RIWAYAT CATATAN
        ================================================== --}}

        <div class="overflow-hidden rounded-lg bg-white shadow-sm">

            <div class="border-b bg-gray-50 px-4 py-3">

                <strong>
                    Riwayat Catatan
                </strong>

            </div>

            <div class="px-4 py-4">

                @forelse(
                    $itRequest->relatedUserNotes->sortByDesc('created_at')
                    as $note
                )

                    <div class="mb-3 rounded-lg border border-gray-200 p-3">

                        <div
                            class="mb-2 flex items-start justify-between"
                        >

                            <div>

                                <div class="font-semibold">
                                    {{ $note->user?->name ?? 'User' }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $note->created_at?->format('d/m/Y H:i') }}
                                </div>

                            </div>

                        </div>


                        <div>

                            {!! nl2br(e($note->catatan)) !!}

                        </div>

                    </div>

                @empty

                    <div class="py-4 text-center text-gray-500">

                        Belum ada catatan dari user terkait.

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

</div>

@endsection