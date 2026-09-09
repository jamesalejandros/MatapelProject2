<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="theme-color"
        content="#f8fafc"
    >

    <title>IT Service Desk</title>

    {{-- =========================================================
        FONTS
    ========================================================== --}}

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap"
        rel="stylesheet"
    >

    {{-- =========================================================
        ASSETS
    ========================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">


    <main class="flex min-h-screen flex-col">


        {{-- =====================================================
            HEADER
        ====================================================== --}}

        <header class="border-b border-slate-200 bg-white">

            <div class="mx-auto flex h-16 w-full max-w-7xl items-center px-5 sm:px-6 lg:px-8">

                <a
                    href="/"
                    class="group inline-flex items-center gap-3"
                    aria-label="IT Service Desk"
                >

                    {{-- Logo --}}

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm"
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
                                d="M18 10a6 6 0 10-12 0v1a3 3 0 00-3 3v1a3 3 0 003 3h1v-6H6a6 6 0 0112 0h-1v6h1a3 3 0 003-3v-1a3 3 0 00-3-3v-1z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 18h1a2 2 0 002-2v-1"
                            />

                        </svg>

                    </div>


                    {{-- Brand --}}

                    <div class="leading-tight">

                        <p class="text-sm font-semibold tracking-tight text-slate-900">
                            IT Service Desk
                        </p>

                        <p class="text-[11px] font-medium text-slate-500">
                            Support &amp; Ticketing
                        </p>

                    </div>

                </a>

            </div>

        </header>


        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}

        <div class="flex flex-1 items-center justify-center px-5 py-10 sm:px-6 lg:px-8">

            <div class="w-full max-w-md">


                {{-- =================================================
                    INTRO
                ================================================== --}}

                <div class="mb-7 text-center">


                    {{-- Icon --}}

                    <div
                        class="mx-auto mb-5 flex h-12 w-12 items-center justify-center rounded-xl border border-blue-100 bg-blue-50 text-blue-600"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6m-6 4h4m5-12H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 8h8"
                            />

                        </svg>

                    </div>


                    <h1 class="text-2xl font-semibold tracking-tight text-slate-900">
                        IT Service Desk
                    </h1>


                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                        Ajukan dan pantau permintaan layanan IT
                        melalui satu portal terpusat.
                    </p>

                </div>


                {{-- =================================================
                    AUTH CARD
                ================================================== --}}

                <section
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >

                    <div class="p-6 sm:p-8">

                        {{ $slot }}

                    </div>

                </section>


                {{-- =================================================
                    SECURITY NOTE
                ================================================== --}}

                <div class="mt-5 flex items-center justify-center gap-2 text-xs text-slate-400">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3l7 4v5c0 4.5-2.8 7.7-7 9-4.2-1.3-7-4.5-7-9V7l7-4z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9.5 12l1.7 1.7 3.3-3.4"
                        />

                    </svg>

                    <span>
                        Secure IT Support Portal
                    </span>

                </div>


                {{-- =================================================
                    FOOTER
                ================================================== --}}

                <p class="mt-6 text-center text-xs text-slate-400">
                    © {{ date('Y') }} IT Service Desk
                </p>

            </div>

        </div>

    </main>

</body>

</html>
