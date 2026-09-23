{{-- ============================================================
SIDEBAR
------------------------------------------------------------
Sidebar utama aplikasi Permintaan IT.

FITUR:
- Mobile sidebar menggunakan `sidebarOpen`
- Desktop sidebar dapat collapse / expand
- Expanded  : w-72
- Collapsed : w-20
- State collapse disimpan di localStorage
- Semua menu tetap berfungsi saat collapsed
- Icon tetap tampil saat collapsed
- Text menu disembunyikan saat collapsed
- Tooltip menggunakan attribute `title`

PENTING:
- Alpine state berasal dari layout utama.
- JANGAN tambahkan x-data di file sidebar ini.

Layout utama harus memiliki:

<div
    x-data="{
        sidebarOpen: false,
        sidebarCollapsed:
            localStorage.getItem('sidebarCollapsed') === 'true'
    }"
>

Logika menu:
- Semua user:
    * Permintaan IT
    * Buat Request
- kepala_bagian:
    * Approve Request IT
- super_admin / staff_it / user dengan permission:
    * Admin Dashboard
============================================================= --}}

@php
    $totalPendingApproval = 0;

    if (
        auth()->check()
        &&
        auth()->user()->hasRole('kepala_bagian')
    ) {
        $totalPendingApproval = \App\Models\ItRequestApproval::query()
            ->where('approver_id', auth()->id())
            ->where(
                'status',
                \App\Models\ItRequestApproval::STATUS_PENDING
            )
            ->count();
    }
@endphp


{{-- ========================================================
MOBILE OVERLAY
========================================================= --}}

<div
    x-show="sidebarOpen"
    x-cloak
    x-transition.opacity
    @click="sidebarOpen = false"
    class="
        fixed
        inset-0
        z-40
        bg-slate-900/40
        backdrop-blur-sm
        lg:hidden
    "
    aria-hidden="true"
></div>


{{-- ========================================================
SIDEBAR
========================================================= --}}

<aside x-cloak
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:w-20': sidebarCollapsed,
        'lg:w-72': !sidebarCollapsed
    }"
    class="
        fixed
        inset-y-0
        left-0
        z-50
        flex
        w-72
        -translate-x-full
        flex-col
        border-r
        border-slate-200
        bg-white
        shadow-xl
        transition-all
        duration-300
        ease-in-out
        lg:translate-x-0
        lg:shadow-sm
    "
>


    {{-- ====================================================
SIDEBAR HEADER
===================================================== --}}

<div
    class="
        relative
        flex
        h-16
        shrink-0
        items-center
        border-b
        border-slate-200
        px-3
        transition-all
        duration-300
    "
>

    {{-- =================================================
    BRAND
    ================================================== --}}

    <a
        href="{{ route('it-requests.index') }}"
        @click="sidebarOpen = false"
        class="
            flex
            min-w-0
            items-center
            gap-3
            transition-opacity
            hover:opacity-80
        "
        :class="
            sidebarCollapsed
                ? 'mx-auto justify-center'
                : 'pr-10'
        "
        title="Permintaan IT"
    >

        {{-- LOGO --}}

        <div
            class="
                flex
                h-10
                w-10
                shrink-0
                items-center
                justify-center
                rounded-xl
                bg-blue-600
                text-white
                shadow-sm
            "
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


        {{-- BRAND TEXT --}}

        <div
            x-show="!sidebarCollapsed"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 -translate-x-2"
            class="min-w-0"
        >

            <p
                class="
                    truncate
                    text-sm
                    font-bold
                    leading-tight
                    text-slate-900
                "
            >
                Permintaan IT
            </p>

            <p
                class="
                    truncate
                    text-xs
                    text-slate-500
                "
            >
                IT Service Request
            </p>

        </div>

    </a>


    {{-- =================================================
    DESKTOP COLLAPSE BUTTON
    ================================================== --}}

    <button
        type="button"
        @click="
            sidebarCollapsed = !sidebarCollapsed;

            localStorage.setItem(
                'sidebarCollapsed',
                sidebarCollapsed
            );
        "
        class="
            absolute
            right-2
            top-1/2
            hidden
            h-8
            w-8
            -translate-y-1/2
            items-center
            justify-center
            rounded-lg
            text-slate-500
            transition
            hover:bg-slate-100
            hover:text-slate-800
            focus:outline-none
            focus:ring-2
            focus:ring-blue-500
            lg:flex
        "
        :aria-label="
            sidebarCollapsed
                ? 'Perbesar sidebar'
                : 'Kecilkan sidebar'
        "
        :title="
            sidebarCollapsed
                ? 'Perbesar sidebar'
                : 'Kecilkan sidebar'
        "
    >

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="
                h-5
                w-5
                transition-transform
                duration-300
            "
            :class="
                sidebarCollapsed
                    ? 'rotate-180'
                    : ''
            "
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 19l-7-7 7-7"
            />
        </svg>

    </button>


    {{-- =================================================
    MOBILE CLOSE BUTTON
    ================================================== --}}

    <button
        type="button"
        @click="sidebarOpen = false"
        class="
            absolute
            right-3
            top-1/2
            flex
            h-9
            w-9
            -translate-y-1/2
            items-center
            justify-center
            rounded-lg
            text-slate-500
            transition
            hover:bg-slate-100
            hover:text-slate-800
            focus:outline-none
            focus:ring-2
            focus:ring-blue-500
            lg:hidden
        "
        aria-label="Tutup sidebar"
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
                d="M6 18L18 6M6 6l12 12"
            />
        </svg>

    </button>

</div>



    {{-- ====================================================
    USER SUMMARY
    ===================================================== --}}

    <div
        class="
            border-b
            border-slate-200
            p-3
            transition-all
            duration-300
        "
    >

        <div
            class="
                flex
                items-center
                gap-3
                rounded-xl
                bg-slate-50
                p-3
                transition-all
                duration-300
            "
            :class="
                sidebarCollapsed
                    ? 'justify-center'
                    : ''
            "
            :title="
                sidebarCollapsed
                    ? '{{ auth()->user()->karyawan?->Nama ?? auth()->user()->name }}'
                    : ''
            "
        >

            {{-- AVATAR --}}

            <div
                class="
                    flex
                    h-10
                    w-10
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


            {{-- USER INFO --}}

            <div
                x-show="!sidebarCollapsed"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-2"
                class="min-w-0"
            >

                <p
                    class="
                        truncate
                        text-sm
                        font-semibold
                        text-slate-800
                    "
                >
                    {{ auth()->user()->karyawan?->Nama
                        ?? auth()->user()->name }}
                </p>

                <p
                    class="
                        truncate
                        text-xs
                        text-slate-500
                    "
                >
                    {{ auth()->user()->NIK ?? 'User' }}
                </p>

            </div>

        </div>

    </div>


    {{-- ====================================================
    NAVIGATION
    ===================================================== --}}

    <nav
        class="
            flex-1
            overflow-y-auto
            px-3
            py-5
        "
    >

        {{-- =================================================
        SECTION: MENU UTAMA
        ================================================== --}}

        <div class="mb-6">

            {{-- SECTION TITLE --}}

            <p
                x-show="!sidebarCollapsed"
                x-transition
                class="
                    mb-2
                    px-3
                    text-[11px]
                    font-bold
                    uppercase
                    tracking-wider
                    text-slate-400
                "
            >
                Menu Utama
            </p>


            {{-- =============================================
            PERMINTAAN IT
            ============================================== --}}

            <a
                href="{{ route('it-requests.index') }}"
                @click="sidebarOpen = false"
                class="
                    group
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-2.5
                    text-sm
                    font-medium
                    transition
                    {{ request()->routeIs('it-requests.index')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                    }}
                "
                :class="
                    sidebarCollapsed
                        ? 'justify-center px-0'
                        : ''
                "
                title="Permintaan IT"
            >

                {{-- ICON --}}

                <span
                    class="
                        flex
                        h-9
                        w-9
                        shrink-0
                        items-center
                        justify-center
                        rounded-lg
                        transition
                        {{ request()->routeIs('it-requests.index')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:text-slate-700'
                        }}
                    "
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
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>

                </span>


                {{-- TEXT --}}

                <span
                    x-show="!sidebarCollapsed"
                    x-transition
                    class="min-w-0 truncate"
                >
                    Permintaan IT
                </span>

            </a>


            {{-- =============================================
            BUAT REQUEST
            ============================================== --}}

            <a
                href="{{ route('it-requests.create') }}"
                @click="sidebarOpen = false"
                class="
                    group
                    mt-1
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-2.5
                    text-sm
                    font-medium
                    transition
                    {{ request()->routeIs('it-requests.create')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                    }}
                "
                :class="
                    sidebarCollapsed
                        ? 'justify-center px-0'
                        : ''
                "
                title="Buat Request"
            >

                {{-- ICON --}}

                <span
                    class="
                        flex
                        h-9
                        w-9
                        shrink-0
                        items-center
                        justify-center
                        rounded-lg
                        transition
                        {{ request()->routeIs('it-requests.create')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:text-slate-700'
                        }}
                    "
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
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                </span>


                {{-- TEXT --}}

                <span
                    x-show="!sidebarCollapsed"
                    x-transition
                    class="min-w-0 truncate"
                >
                    Buat Permintaan
                </span>

            </a>

        </div>


        {{-- =================================================
        SECTION: APPROVAL
        --------------------------------------------------
        Hanya kepala_bagian
        ================================================== --}}

        @if (
            auth()->check()
            &&
            auth()->user()->hasRole('kepala_bagian')
        )

            <div class="mb-6">

                {{-- SECTION TITLE --}}

                <p
                    x-show="!sidebarCollapsed"
                    x-transition
                    class="
                        mb-2
                        px-3
                        text-[11px]
                        font-bold
                        uppercase
                        tracking-wider
                        text-slate-400
                    "
                >
                    Persetujuan
                </p>


                {{-- =========================================
                APPROVE REQUEST IT
                ========================================== --}}

                <a
                    href="{{ route('kepala-bagian.it-requests.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        group
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-3
                        py-2.5
                        text-sm
                        font-medium
                        transition
                        {{ request()->routeIs('kepala-bagian.it-requests.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                        }}
                    "
                    :class="
                        sidebarCollapsed
                            ? 'justify-center px-0'
                            : ''
                    "
                    title="Approve Request IT"
                >

                    {{-- ICON --}}

                    <span
                        class="
                            flex
                            h-9
                            w-9
                            shrink-0
                            items-center
                            justify-center
                            rounded-lg
                            transition
                            {{ request()->routeIs('kepala-bagian.it-requests.*')
                                ? 'bg-emerald-600 text-white shadow-sm'
                                : 'bg-emerald-50 text-emerald-600 group-hover:bg-white'
                            }}
                        "
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
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                    </span>


                    {{-- TEXT --}}

                    <span
                        x-show="!sidebarCollapsed"
                        x-transition
                        class="min-w-0 flex-1 truncate"
                    >
                        Approve Request IT
                    </span>


                    {{-- NOTIFICATION BADGE --}}

                    @if ($totalPendingApproval > 0)

                        <span
                            class="
                                inline-flex
                                min-w-5
                                h-5
                                shrink-0
                                items-center
                                justify-center
                                rounded-full
                                bg-red-500
                                px-1.5
                                text-[11px]
                                font-bold
                                leading-none
                                text-white
                                shadow-sm
                                ring-2
                                ring-white
                            "
                            :class="
                                sidebarCollapsed
                                    ? 'absolute ml-7 mt-[-20px]'
                                    : ''
                            "
                            title="{{ $totalPendingApproval }} permintaan menunggu persetujuan"
                        >
                            {{ $totalPendingApproval > 99 ? '99+' : $totalPendingApproval }}
                        </span>

                    @endif

                </a>

            </div>

        @endif


        {{-- =================================================
        SECTION: ADMINISTRASI
        --------------------------------------------------
        Tampil untuk:
        - super_admin
        - staff_it
        - user dengan permission
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

            <div class="mb-6">

                {{-- SECTION TITLE --}}

                <p
                    x-show="!sidebarCollapsed"
                    x-transition
                    class="
                        mb-2
                        px-3
                        text-[11px]
                        font-bold
                        uppercase
                        tracking-wider
                        text-slate-400
                    "
                >
                    Administrasi
                </p>


                {{-- =========================================
                ADMIN DASHBOARD
                ========================================== --}}

                <a
                    href="{{ url('/admin') }}"
                    @click="sidebarOpen = false"
                    class="
                        group
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-3
                        py-2.5
                        text-sm
                        font-medium
                        transition
                        {{ request()->is('admin*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                        }}
                    "
                    :class="
                        sidebarCollapsed
                            ? 'justify-center px-0'
                            : ''
                    "
                    title="Admin Dashboard"
                >

                    {{-- ICON --}}

                    <span
                        class="
                            flex
                            h-9
                            w-9
                            shrink-0
                            items-center
                            justify-center
                            rounded-lg
                            bg-slate-100
                            text-slate-500
                            transition
                            group-hover:bg-white
                            group-hover:text-slate-700
                        "
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
                                d="M3 13h8V3H3v10zm10 8h8v-10h-8v10zM3 21h8v-4H3v4zm10-12h8V3h-8v6z"
                            />
                        </svg>

                    </span>


                    {{-- TEXT --}}

                    <span
                        x-show="!sidebarCollapsed"
                        x-transition
                        class="min-w-0 truncate"
                    >
                        Admin Dashboard
                    </span>

                </a>

            </div>

        @endif

    </nav>


    {{-- ====================================================
    SIDEBAR FOOTER
    ===================================================== --}}

    <div
        class="
            shrink-0
            border-t
            border-slate-200
            p-3
        "
    >

        {{-- =================================================
        PROFILE
        ================================================== --}}

        @if (Route::has('profile.edit'))

            <a
                href="{{ route('profile.edit') }}"
                @click="sidebarOpen = false"
                class="
                    group
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-2.5
                    text-sm
                    font-medium
                    text-slate-600
                    transition
                    hover:bg-slate-100
                    hover:text-slate-900
                "
                :class="
                    sidebarCollapsed
                        ? 'justify-center px-0'
                        : ''
                "
                title="Profile"
            >

                {{-- ICON --}}

                <span
                    class="
                        flex
                        h-9
                        w-9
                        shrink-0
                        items-center
                        justify-center
                        rounded-lg
                        bg-slate-100
                        text-slate-500
                        transition
                        group-hover:bg-white
                        group-hover:text-slate-700
                    "
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
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                        />
                    </svg>

                </span>


                {{-- TEXT --}}

                <span
                    x-show="!sidebarCollapsed"
                    x-transition
                    class="min-w-0 truncate"
                >
                    Profile
                </span>

            </a>

        @endif


        {{-- =================================================
        LOGOUT
        ================================================== --}}

        <form
            method="POST"
            action="{{ route('logout') }}"
            class="mt-1"
        >

            @csrf

            <button
                type="submit"
                class="
                    group
                    flex
                    w-full
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-2.5
                    text-left
                    text-sm
                    font-medium
                    text-slate-600
                    transition
                    hover:bg-red-50
                    hover:text-red-600
                    focus:outline-none
                    focus:ring-2
                    focus:ring-red-500
                    focus:ring-offset-1
                "
                :class="
                    sidebarCollapsed
                        ? 'justify-center px-0'
                        : ''
                "
                title="Logout"
            >

                {{-- ICON --}}

                <span
                    class="
                        flex
                        h-9
                        w-9
                        shrink-0
                        items-center
                        justify-center
                        rounded-lg
                        bg-slate-100
                        text-slate-500
                        transition
                        group-hover:bg-red-100
                        group-hover:text-red-600
                    "
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
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3"
                        />
                    </svg>

                </span>


                {{-- TEXT --}}

                <span
                    x-show="!sidebarCollapsed"
                    x-transition
                    class="min-w-0 truncate"
                >
                    Logout
                </span>

            </button>

        </form>


        {{-- =================================================
        APPLICATION INFO
        ================================================== --}}

        <div
            x-show="!sidebarCollapsed"
            x-transition
            class="
                mt-3
                border-t
                border-slate-100
                px-3
                pt-3
            "
        >

            <p
                class="
                    text-[11px]
                    font-medium
                    text-slate-400
                "
            >
                IT Asset Management
            </p>

            <p
                class="
                    mt-0.5
                    text-[10px]
                    text-slate-400
                "
            >
                IT Service Request
            </p>

        </div>

    </div>

</aside>
