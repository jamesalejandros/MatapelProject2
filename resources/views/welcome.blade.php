<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#111827">

    <title>IT Asset Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-gray-950 via-gray-900 to-amber-700 antialiased">

    <div class="mx-5 w-full max-w-3xl rounded-3xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur-xl sm:p-10 md:p-12">

        {{-- =========================================================
            LOGO
        ========================================================== --}}

        <div class="flex justify-center">

            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-500 shadow-lg shadow-amber-500/30">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="white"
                    class="h-11 w-11"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25Z"
                    />
                </svg>

            </div>

        </div>


        {{-- =========================================================
            TITLE
        ========================================================== --}}

        <div class="mt-7 text-center">

            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                IT Asset Management
            </h1>

            <p class="mx-auto mt-4 max-w-xl text-sm leading-6 text-gray-500 sm:text-base">
                Platform terintegrasi untuk pengelolaan aset,
                layanan teknologi informasi, dan proses persetujuan permintaan IT.
            </p>

        </div>


        {{-- =========================================================
            ACCESS OPTIONS
        ========================================================== --}}

        <div class="mt-10 grid gap-4 sm:grid-cols-2">


            {{-- =====================================================
                PERMINTAAN IT
            ====================================================== --}}

            <a
                href="{{ url('/login') }}"
                class="group rounded-2xl border border-blue-200 bg-blue-50 p-5 text-left transition duration-200 hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-100 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >

                <div class="flex items-start justify-between gap-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6l5 5v11a2 2 0 0 1-2 2Z"
                            />
                        </svg>

                    </div>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5 text-blue-400 transition group-hover:translate-x-1 group-hover:text-blue-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                        />
                    </svg>

                </div>

                <div class="mt-4">

                    <h2 class="font-semibold text-gray-900">
                        Permintaan IT
                    </h2>

                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Ajukan dan pantau tiket atau permintaan layanan IT Anda.
                    </p>

                </div>

            </a>


            {{-- =====================================================
                LOGIN KEPALA BAGIAN
            ====================================================== --}}

            <a
                href="{{ route('kepala-bagian.login') }}"
                class="group rounded-2xl border border-violet-200 bg-violet-50 p-5 text-left transition duration-200 hover:-translate-y-0.5 hover:border-violet-300 hover:bg-violet-100 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
            >

                <div class="flex items-start justify-between gap-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-600 text-white shadow-sm">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-.993-.124-1.956-.356-2.865M15 19.128a23.3 23.3 0 0 1-6 0m0 0a23.3 23.3 0 0 1-6-0m6 0v-.003c0-.993.124-1.956.356-2.865m0 0a4.125 4.125 0 1 0-7.533 2.493A9.337 9.337 0 0 0 6 19.5a9.38 9.38 0 0 0 2.625-.372M12 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm8.25 1.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                            />
                        </svg>

                    </div>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5 text-violet-400 transition group-hover:translate-x-1 group-hover:text-violet-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                        />
                    </svg>

                </div>

                <div class="mt-4">

                    <h2 class="font-semibold text-gray-900">
                        Kepala Bagian
                    </h2>

                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Masuk untuk meninjau, menyetujui, atau menolak permintaan IT bawahan.
                    </p>

                </div>

            </a>


            {{-- =====================================================
                ASSET MANAGEMENT
            ====================================================== --}}

            <a
                href="{{ url('/admin') }}"
                class="group rounded-2xl border border-amber-200 bg-amber-50 p-5 text-left transition duration-200 hover:-translate-y-0.5 hover:border-amber-300 hover:bg-amber-100 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 sm:col-span-2"
            >

                <div class="flex items-start justify-between gap-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-sm">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 4.5h16.5A1.75 1.75 0 0 1 22 6.25v10.5a1.75 1.75 0 0 1-1.75 1.75H3.75A1.75 1.75 0 0 1 2 16.75V6.25A1.75 1.75 0 0 1 3.75 4.5ZM8.25 21h7.5M12 18.5V21"
                            />
                        </svg>

                    </div>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5 text-amber-400 transition group-hover:translate-x-1 group-hover:text-amber-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                        />
                    </svg>

                </div>

                <div class="mt-4">

                    <h2 class="font-semibold text-gray-900">
                        Asset Management
                    </h2>

                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Kelola aset, master data, assignment, service, dan administrasi IT.
                    </p>

                </div>

            </a>

        </div>


        {{-- =========================================================
            INFORMATION
        ========================================================== --}}

        <div class="mt-8 flex items-center justify-center gap-2 text-center text-xs text-gray-400">

            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

            Sistem Informasi Teknologi

        </div>


        {{-- =========================================================
            FOOTER
        ========================================================== --}}

        <div class="mt-6 border-t border-gray-100 pt-5 text-center text-xs text-gray-400">

            © {{ date('Y') }} IT Asset Management

        </div>

    </div>

</body>

</html>
