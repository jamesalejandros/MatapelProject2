<!DOCTYPE html> <html lang="id" class="h-full"> <head>
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

</head> <body class=" min-h-full bg-slate-50 text-slate-800 antialiased " >
{{-- ============================================================
APPLICATION SHELL
------------------------------------------------------------
Alpine state diletakkan di wrapper utama agar:
- sidebar
- mobile hamburger
- overlay
berada dalam scope yang sama.
============================================================= --}}

<div
    x-data="{
        sidebarOpen: false,
        sidebarCollapsed: false
    }"
    x-init="
        sidebarCollapsed =
            localStorage.getItem('sidebarCollapsed') === 'true'
    "
    class="min-h-screen"
>


{{-- ========================================================
    SIDEBAR
    --------------------------------------------------------
    Sidebar hanya menangani:
    - Navigasi utama
    - User summary
    - Profile
    - Logout
    - Role-based navigation

    Navbar tidak lagi mengulang menu-menu tersebut.
========================================================= --}}

@include('layouts.sidebar')


{{-- ========================================================
    MAIN APPLICATION AREA
    --------------------------------------------------------
    Sidebar:
    width = w-72

    Desktop:
    content diberi margin kiri 18rem.

    Mobile:
    content memenuhi seluruh layar.
========================================================= --}}

<div
    class="
        min-h-screen
        transition-[margin]
        duration-300
        ease-in-out
    "
    :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-72'"
>



    {{-- ====================================================
        TOP NAVBAR
        ----------------------------------------------------
        Navbar sekarang benar-benar hanya menjadi TOPBAR.

        Tidak ada lagi:
        - menu Permintaan IT
        - Approve Request IT
        - Admin Dashboard
        - User information
        - Logout

        Semua fungsi tersebut sudah berada di sidebar.
    ===================================================== --}}

    <header
        class="
            sticky
            top-0
            z-30
            h-16
            border-b
            border-slate-200
            bg-white/95
            backdrop-blur
        "
    >

        <div
            class="
                flex
                h-full
                items-center
                justify-between
                px-4
                sm:px-6
                lg:px-8
            "
        >


            {{-- =================================================
                LEFT SIDE
            ================================================== --}}

            <div
                class="
                    flex
                    min-w-0
                    items-center
                    gap-3
                "
            >

                {{-- =============================================
                    MOBILE SIDEBAR BUTTON
                    ---------------------------------------------
                    Karena x-data berada di wrapper utama,
                    sidebarOpen tersedia di sini.
                ============================================== --}}

                <button
                    type="button"
                    @click="sidebarOpen = true"
                    class="
                        flex
                        h-10
                        w-10
                        shrink-0
                        items-center
                        justify-center
                        rounded-xl
                        border
                        border-slate-200
                        bg-white
                        text-slate-600
                        shadow-sm
                        transition
                        hover:border-slate-300
                        hover:bg-slate-50
                        hover:text-slate-900
                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-500
                        focus:ring-offset-2
                        lg:hidden
                    "
                    aria-label="Buka menu navigasi"
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
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>

                </button>


                {{-- =============================================
                    PAGE CONTEXT
                ============================================== --}}

                <div class="min-w-0">

                    <div
                        class="
                            flex
                            min-w-0
                            items-center
                            gap-2
                        "
                    >

                        <span
                            class="
                                hidden
                                h-2
                                w-2
                                shrink-0
                                rounded-full
                                bg-blue-600
                                sm:block
                            "
                        ></span>


                        <p
                            class="
                                truncate
                                text-sm
                                font-semibold
                                text-slate-900
                                sm:text-base
                            "
                        >

                            @yield(
                                'page_title',
                                'Permintaan IT'
                            )

                        </p>

                    </div>


                    <p
                        class="
                            hidden
                            truncate
                            text-xs
                            text-slate-500
                            sm:block
                        "
                    >

                        @yield(
                            'page_description',
                            'IT Service Request'
                        )

                    </p>

                </div>

            </div>


            {{-- =================================================
                RIGHT SIDE
                --------------------------------------------------
                Hanya berisi aksi yang relevan dengan halaman.

                User/logout sengaja TIDAK ditampilkan di sini
                karena sudah tersedia di sidebar.
            ================================================== --}}

            <div
                class="
                    flex
                    shrink-0
                    items-center
                    gap-2
                    sm:gap-3
                "
            >

                {{-- =============================================
                    CREATE REQUEST
                    ---------------------------------------------
                    Tetap disediakan sebagai quick action karena
                    merupakan aksi kontekstual utama aplikasi.

                    Menu navigasi "Buat Request" tetap berada
                    di sidebar.
                ============================================== --}}

                <!-- <a
                    href="{{ route('it-requests.create') }}"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        rounded-xl
                        bg-blue-600
                        px-3
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

                    <span class="hidden sm:inline">
                        Buat Request
                    </span>

                </a> -->

            </div>

        </div>

    </header>


    {{-- ====================================================
        MAIN CONTENT
    ===================================================== --}}

    <main
        class="
            min-h-[calc(100vh-4rem)]
        "
    >

        <div
    class="
        mx-auto
        w-full
        max-w-[1600px]
        px-4
        py-6
        sm:px-6
        sm:py-8
        lg:px-8
        xl:px-10
    "
>



            {{-- =================================================
                BREADCRUMB
            ================================================== --}}

            @hasSection('breadcrumb')

                <div
                    class="
                        mb-5
                        flex
                        min-w-0
                        items-center
                        gap-2
                        overflow-x-auto
                        text-xs
                        text-slate-500
                    "
                >

                    @yield('breadcrumb')

                </div>

            @endif


            {{-- =================================================
                FLASH SUCCESS
            ================================================== --}}

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

                    <div
                        class="
                            min-w-0
                            text-sm
                            font-medium
                        "
                    >

                        {{ session('success') }}

                    </div>

                </div>

            @endif


            {{-- =================================================
                FLASH ERROR
            ================================================== --}}

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

                    <div
                        class="
                            min-w-0
                            text-sm
                            font-medium
                        "
                    >

                        {{ session('error') }}

                    </div>

                </div>

            @endif


            {{-- =================================================
                VALIDATION ERRORS
            ================================================== --}}

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

                    <div
                        class="
                            flex
                            items-start
                            gap-3
                        "
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="
                                mt-0.5
                                h-5
                                w-5
                                shrink-0
                            "
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


                        <div class="min-w-0">

                            <p class="text-sm font-semibold">
                                Terdapat kesalahan.
                            </p>


                            <ul
                                class="
                                    mt-2
                                    space-y-1
                                    text-sm
                                "
                            >

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


            {{-- =================================================
                PAGE CONTENT
            ================================================== --}}

            @yield('content')

        </div>

    </main>


    {{-- ====================================================
        FOOTER
    ===================================================== --}}

    <footer
        class="
            border-t
            border-slate-200
            bg-white
        "
    >

        <div
    class="
        mx-auto
        flex
        w-full
        max-w-[1600px]
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
        xl:px-10
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

</div>

</div>
{{-- ============================================================
ALPINE CLOAK
============================================================= --}}

<style> [x-cloak] { display: none !important; } </style> </body> </html>