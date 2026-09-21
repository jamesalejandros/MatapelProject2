@extends('layouts.layout')

@section('title', 'Profile')
@section('page_title', 'Profile')
@section('page_description', 'Informasi akun dan pengaturan profile')

@section('breadcrumb')

<a
    href="{{ route('it-requests.index') }}"
    class="transition hover:text-slate-700"
>
    Permintaan IT
</a>

<svg
    xmlns="http://www.w3.org/2000/svg"
    class="h-3.5 w-3.5 shrink-0 text-slate-400"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
    stroke-width="2"
>
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M9 5l7 7-7 7"
    />
</svg>

<span class="font-medium text-slate-700">
    Profile
</span>


@endsection

@section('content')

<div class="mx-auto w-full max-w-4xl">

    {{-- =====================================================
        PROFILE INFORMATION
    ====================================================== --}}

    @include('profile.partials.update-profile-information-form')


    {{-- =====================================================
        UPDATE PASSWORD
    ====================================================== --}}

    <div class="mt-6">
        @include('profile.partials.update-password-form')
    </div>


    {{-- =====================================================
        DELETE ACCOUNT
    ====================================================== --}}

    <div class="mt-6">
        @include('profile.partials.delete-user-form')
    </div>

</div>


@endsection