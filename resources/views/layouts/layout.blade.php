<!DOCTYPE html>
<html lang="id" class="h-full">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="theme-color"
        content="#f8fafc"
    >

    <title>
        @yield('title', 'Permintaan IT')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-full bg-slate-50 text-slate-800 antialiased">

    {{-- ============================================================
        NAVBAR
    ============================================================= --}}

    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">

        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

            {{-- =====================================================
                BRAND
            ====================================================== --}}

            <a
                href="{{ route('it-requests.index') }}"
                class="flex items-center gap-3 transition-opacity hover:opacity-80"
            >

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm"
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
                            d="M9 3h6m-7 4h8m-9 4h10m-9 4h8m-6 4h4"
                        />
                    </svg>

                </div>


                <div class="hidden sm:block">

                    <p class="text-sm font-bold leading-tight text-slate-900">
                        Permintaan IT
                    </p>

                    <p class="text-xs text-slate-500">
                        IT Service Request
                    </p>

                </div>

            </a>


            {{-- =====================================================
                RIGHT NAVIGATION
            ====================================================== --}}

            <div class="flex items-center gap-2 sm:gap-3">


                {{-- =================================================
                    PERMINTAAN IT
                ================================================== --}}

                <a
                    href="{{ route('it-requests.index') }}"
                    class="
                        hidden
                        rounded-lg
                        px-3
                        py-2
                        text-sm
                        font-medium
                        text-slate-600
                        transition
                        hover:bg-slate-100
                        hover:text-slate-900
                        sm:inline-flex
                    "
                >

                    Permintaan IT

                </a>


                {{-- =================================================
                    BUAT REQUEST
                ================================================== --}}

                <a
                    href="{{ route('it-requests.create') }}"
                    class="
                        hidden
                        items-center
                        gap-2
                        rounded-lg
                        bg-blue-600
                        px-4
                        py-2
                        text-sm
                        font-semibold
                        text-white
                        shadow-sm
                        transition
                        hover:bg-blue-700
                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-500
                        focus:ring-offset-2
                        sm:inline-flex
                    "
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

                    Buat Request

                </a>


                {{-- =================================================
                    ADMIN DASHBOARD
                    --------------------------------------------------
                    Tampil apabila:
                    - super_admin
                    - staff_it
                    - user dengan minimal 1 permission
                ================================================== --}}

                @if (
                    auth()->check()
                    &&
                    (
                        auth()->user()->hasAnyRole([
                            'super_admin',
                            'staff_it',
                        ])
                        ||
                        auth()->user()->getAllPermissions()->isNotEmpty()
                    )
                )

                    <a
                        href="{{ url('/admin') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            gap-2
                            rounded-lg
                            border
                            border-slate-200
                            bg-white
                            px-3
                            py-2
                            text-sm
                            font-semibold
                            text-slate-700
                            shadow-sm
                            transition
                            hover:border-slate-300
                            hover:bg-slate-50
                            hover:text-slate-900
                            focus:outline-none
                            focus:ring-2
                            focus:ring-slate-400
                            focus:ring-offset-2
                        "
                        title="Buka Admin Dashboard"
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
                                d="M3 13h8V3H3v10zm10 8h8v-10h-8v10zM3 21h8v-4H3v4zm10-12h8V3h-8v6z"
                            />
                        </svg>

                        <span class="hidden sm:inline">
                            Admin Dashboard
                        </span>

                    </a>

                @endif


                {{-- =================================================
                    USER AREA
                ================================================== --}}

                <div
                    class="
                        ml-1
                        flex
                        items-center
                        gap-2
                        border-l
                        border-slate-200
                        pl-2
                        sm:ml-1
                        sm:gap-3
                        sm:pl-3
                    "
                >

                    {{-- =================================================
                        USER INFORMATION
                    ================================================== --}}

                    <div class="hidden text-right md:block">

                        <p
                            class="
                                max-w-40
                                truncate
                                text-sm
                                font-semibold
                                text-slate-800
                            "
                        >

                            {{ auth()->user()->karyawan?->Nama
                                ?? auth()->user()->name }}

                        </p>

                        <p class="text-xs text-slate-500">

                            {{ auth()->user()->NIK ?? 'User' }}

                        </p>

                    </div>


                    {{-- =================================================
                        USER AVATAR
                    ================================================== --}}

                    <div
                        class="
                            flex
                            h-9
                            w-9
                            shrink-0
                            items-center
                            justify-center
                            rounded-full
                            bg-blue-100
                            text-sm
                            font-bold
                            text-blue-700
                        "
                    >

                        {{
                            strtoupper(
                                substr(
                                    auth()->user()->karyawan?->Nama
                                    ?? auth()->user()->name
                                    ?? 'U',
                                    0,
                                    1
                                )
                            )
                        }}

                    </div>


                    {{-- =================================================
                        LOGOUT
                    ================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="inline"
                    >

                        @csrf

                        <button
                            type="submit"
                            title="Logout"
                            aria-label="Logout"
                            class="
                                group
                                flex
                                h-9
                                w-9
                                items-center
                                justify-center
                                rounded-lg
                                text-slate-500
                                transition
                                hover:bg-red-50
                                hover:text-red-600
                                focus:outline-none
                                focus:ring-2
                                focus:ring-red-500
                                focus:ring-offset-2
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 transition group-hover:translate-x-0.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3"
                                />
                            </svg>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </header>


    {{-- ============================================================
        MAIN CONTENT
    ============================================================= --}}

    <main class="min-h-[calc(100vh-4rem)]">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">


            {{-- =====================================================
                FLASH SUCCESS
            ====================================================== --}}

            @if (session('success'))

                <div
                    class="
                        mb-6
                        flex
                        items-start
                        gap-3
                        rounded-xl
                        border
                        border-emerald-200
                        bg-emerald-50
                        p-4
                        text-emerald-800
                        shadow-sm
                    "
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
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                    </div>

                    <div class="text-sm font-medium">

                        {{ session('success') }}

                    </div>

                </div>

            @endif


            {{-- =====================================================
                FLASH ERROR
            ====================================================== --}}

            @if (session('error'))

                <div
                    class="
                        mb-6
                        flex
                        items-start
                        gap-3
                        rounded-xl
                        border
                        border-red-200
                        bg-red-50
                        p-4
                        text-red-800
                        shadow-sm
                    "
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
                                d="M12 9v3.75m0 3.75h.007M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                    </div>

                    <div class="text-sm font-medium">

                        {{ session('error') }}

                    </div>

                </div>

            @endif


            {{-- =====================================================
                VALIDATION ERRORS
            ====================================================== --}}

            @if ($errors->any())

                <div
                    class="
                        mb-6
                        rounded-xl
                        border
                        border-red-200
                        bg-red-50
                        p-4
                        text-red-800
                        shadow-sm
                    "
                    role="alert"
                >

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
                                d="M12 9v3.75m0 3.75h.007M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>


                        <div>

                            <p class="text-sm font-semibold">
                                Terdapat kesalahan.
                            </p>

                            <ul class="mt-2 space-y-1 text-sm">

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


            {{-- =====================================================
                PAGE CONTENT
            ====================================================== --}}

            @yield('content')

        </div>

    </main>


    {{-- ============================================================
        FOOTER
    ============================================================= --}}

    <footer class="border-t border-slate-200 bg-white">

        <div
            class="
                mx-auto
                flex
                max-w-7xl
                flex-col
                gap-2
                px-4
                py-5
                text-center
                text-xs
                text-slate-500
                sm:flex-row
                sm:items-center
                sm:justify-between
                sm:px-6
                lg:px-8
            "
        >

            <p>
                © {{ date('Y') }} IT Asset Management
            </p>

            <p>
                IT Service Request
            </p>

        </div>

    </footer>

</body>

</html>
