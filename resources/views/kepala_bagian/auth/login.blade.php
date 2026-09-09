<!DOCTYPE html> <html lang="id"> <head>
<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Login Kepala Bagian
</title>

<script src="https://cdn.tailwindcss.com"></script>

</head> <body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
<div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-8 sm:px-6">

    {{-- =========================================================
        BACKGROUND DECORATION
    ========================================================== --}}

    <div class="pointer-events-none absolute inset-0 overflow-hidden">

        <div
            class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"
        ></div>

        <div
            class="absolute -bottom-32 -right-32 h-80 w-80 rounded-full bg-indigo-200/40 blur-3xl"
        ></div>

        <div
            class="absolute left-1/2 top-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-slate-200/50 blur-3xl"
        ></div>

    </div>

    {{-- =========================================================
        LOGIN CARD
    ========================================================== --}}

    <div class="relative z-10 w-full max-w-md">

        {{-- Brand / Header --}}

        <div class="mb-6 text-center">

            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-lg shadow-blue-600/20"
            >

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
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 21a8 8 0 0116 0"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 8v6m3-3h-6"
                    />
                </svg>

            </div>

            <h1 class="mt-5 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Login Kepala Bagian
            </h1>

            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                Masuk untuk meninjau dan memberikan persetujuan
                terhadap permintaan IT dari anggota tim Anda.
            </p>

        </div>

        {{-- =====================================================
            ALERT SUCCESS
        ====================================================== --}}

        @if (session('success'))

            <div
                class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm"
                role="alert"
            >

                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600"
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

                </div>

                <div class="min-w-0">

                    <p class="font-semibold">
                        Berhasil
                    </p>

                    <p class="mt-0.5 leading-5">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        @endif

        {{-- =====================================================
            ALERT ERROR SESSION
        ====================================================== --}}

        @if (session('error'))

            <div
                class="mb-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 shadow-sm"
                role="alert"
            >

                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600"
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
                            d="M12 9v3.75m0 3.75h.007v.008H12v-.008z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.29 3.86l-7.82 13.5A1.5 1.5 0 003.77 19.6h16.46a1.5 1.5 0 001.3-2.24l-7.82-13.5a1.5 1.5 0 00-2.6 0z"
                        />
                    </svg>

                </div>

                <div class="min-w-0">

                    <p class="font-semibold">
                        Login gagal
                    </p>

                    <p class="mt-0.5 leading-5">
                        {{ session('error') }}
                    </p>

                </div>

            </div>

        @endif

        {{-- =====================================================
            VALIDATION ERRORS
        ====================================================== --}}

        @if ($errors->any())

            <div
                class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 shadow-sm"
                role="alert"
            >

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600"
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
                                d="M12 9v3.75m0 3.75h.007v.008H12v-.008z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10.29 3.86l-7.82 13.5A1.5 1.5 0 003.77 19.6h16.46a1.5 1.5 0 001.3-2.24l-7.82-13.5a1.5 1.5 0 00-2.6 0z"
                            />
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="font-semibold text-red-800">
                            Periksa kembali data Anda
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-red-700">

                            @foreach ($errors->all() as $error)

                                <li class="flex items-start gap-2">

                                    <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-red-500"></span>

                                    <span>
                                        {{ $error }}
                                    </span>

                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif

        {{-- =====================================================
            FORM CARD
        ====================================================== --}}

        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-900/5"
        >

            <div class="p-6 sm:p-8">

                <div class="mb-6">

                    <h2 class="text-lg font-semibold text-slate-900">
                        Selamat datang kembali
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Silakan masukkan akun Kepala Bagian Anda.
                    </p>

                </div>

                <form
                    method="POST"
                    action="{{ route('kepala-bagian.login.store') }}"
                    class="space-y-5"
                >

                    @csrf

                    {{-- =================================================
                        EMAIL
                    ================================================== --}}

                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Email
                        </label>

                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400"
                            >

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
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"
                                    />

                                    <rect
                                        width="18"
                                        height="14"
                                        x="3"
                                        y="5"
                                        rx="2"
                                        ry="2"
                                    />
                                </svg>

                            </div>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="nama@perusahaan.com"
                                class="block w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500/10 @enderror"
                            >

                        </div>

                        @error('email')

                            <p class="mt-1.5 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    {{-- =================================================
                        PASSWORD
                    ================================================== --}}

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <label
                                for="password"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Password
                            </label>

                        </div>

                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect
                                        width="14"
                                        height="11"
                                        x="5"
                                        y="10"
                                        rx="2"
                                        ry="2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8 10V7a4 4 0 018 0v3"
                                    />

                                </svg>

                            </div>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="block w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @error('password') border-red-400 focus:border-red-500 focus:ring-red-500/10 @enderror"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400 transition hover:text-slate-600 focus:outline-none"
                                aria-label="Tampilkan password"
                            >

                                <svg
                                    id="eyeOpen"
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
                                        d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6S2.25 12 2.25 12z"
                                    />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5"
                                    />
                                </svg>

                                <svg
                                    id="eyeClosed"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="hidden h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 3l18 18"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M10.58 10.58a2 2 0 002.84 2.84"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9.88 5.08A9.74 9.74 0 0112 4.85c6 0 9.75 7.15 9.75 7.15a17.74 17.74 0 01-3.04 3.97"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.24 6.24C3.93 7.83 2.25 12 2.25 12s3.75 7.15 9.75 7.15a9.72 9.72 0 004.24-.96"
                                    />

                                </svg>

                            </button>

                        </div>

                        @error('password')

                            <p class="mt-1.5 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    {{-- =================================================
                        REMEMBER ME
                    ================================================== --}}

                    <div class="flex items-center justify-between">

                        <label class="inline-flex cursor-pointer items-center gap-2.5">

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 accent-blue-600 focus:ring-2 focus:ring-blue-500/20"
                                {{ old('remember') ? 'checked' : '' }}
                            >

                            <span class="text-sm text-slate-600">
                                Ingat saya
                            </span>

                        </label>

                    </div>

                    {{-- =================================================
                        SUBMIT
                    ================================================== --}}

                    <button
                        type="submit"
                        class="group flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition duration-200 hover:-translate-y-0.5 hover:from-blue-700 hover:to-indigo-700 hover:shadow-xl hover:shadow-blue-600/25 focus:outline-none focus:ring-4 focus:ring-blue-500/20 active:translate-y-0"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform group-hover:translate-x-0.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10 17l5-5-5-5"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12H3"
                            />

                        </svg>

                        Masuk sebagai Kepala Bagian

                    </button>

                </form>

            </div>

            {{-- =====================================================
                FOOTER CARD
            ====================================================== --}}

            <div class="border-t border-slate-100 bg-slate-50 px-6 py-5 sm:px-8">

                <p class="text-center text-sm text-slate-500">

                    Bukan Kepala Bagian?

                    <a
                        href="{{ url('/login') }}"
                        class="font-semibold text-blue-600 transition hover:text-blue-700 hover:underline"
                    >
                        Login sebagai User
                    </a>

                </p>

            </div>

        </div>

        {{-- =========================================================
            SECURITY NOTE
        ========================================================== --}}

        <div class="mt-5 flex items-center justify-center gap-2 text-center text-xs text-slate-400">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 shrink-0"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <rect
                    width="14"
                    height="11"
                    x="5"
                    y="10"
                    rx="2"
                    ry="2"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 10V7a4 4 0 018 0v3"
                />

            </svg>

            <span>
                Akses Kepala Bagian dilindungi dan hanya untuk pengguna berwenang.
            </span>

        </div>

    </div>

</div>

{{-- =============================================================
    PASSWORD TOGGLE
============================================================= --}}

<script>

    const togglePassword =
        document.getElementById('togglePassword');

    const password =
        document.getElementById('password');

    const eyeOpen =
        document.getElementById('eyeOpen');

    const eyeClosed =
        document.getElementById('eyeClosed');

    togglePassword.addEventListener(
        'click',
        function () {

            const isPassword =
                password.type === 'password';

            password.type =
                isPassword
                    ? 'text'
                    : 'password';

            eyeOpen.classList.toggle(
                'hidden',
                !isPassword
            );

            eyeClosed.classList.toggle(
                'hidden',
                isPassword
            );

            togglePassword.setAttribute(
                'aria-label',
                isPassword
                    ? 'Sembunyikan password'
                    : 'Tampilkan password'
            );

        }
    );

</script>

</body> </html>