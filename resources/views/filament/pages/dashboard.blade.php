<x-filament-panels::page>

    {{-- ========================================================= --}}
    {{-- DASHBOARD CONTAINER                                       --}}
    {{-- ========================================================= --}}

    <div style="width:100%;">

        {{-- ===================================================== --}}
        {{-- ASSET STATISTICS                                      --}}
        {{-- ===================================================== --}}

        <div style="margin-bottom:24px;">

            @livewire(
                $this->getStatsWidget(),
                [],
                key('asset-stats')
            )

        </div>

        {{-- ========================================================= --}}
{{-- SOFTWARE LICENSE EXPIRATION REMINDER                     --}}
{{-- ========================================================= --}}

<div style="margin-bottom:24px;">

    @livewire(
        $this->getSoftwareLicenseReminderWidget(),
        [],
        key('software-license-expiration-reminder')
    )

</div>




        {{-- ===================================================== --}}
        {{-- ANALYTICS + ACTIVE WIDGET                             --}}
        {{-- 40% : 60%                                            --}}
        {{-- ===================================================== --}}

        <div
            style="
                display:grid;
                grid-template-columns:minmax(0, 40%) minmax(0, 60%);
                gap:20px;
                align-items:start;
            "
        >

            {{-- ================================================= --}}
            {{-- ANALYTICS MENU                                    --}}
            {{-- ================================================= --}}

            <div
                style="
                    min-width:0;
                    background:white;
                    border:1px solid #e5e7eb;
                    border-radius:14px;
                    padding:20px;
                    box-shadow:0 1px 3px rgba(0,0,0,.05);
                "
                class="dark:bg-gray-900 dark:border-gray-700"
            >

                {{-- HEADER --}}

                <div style="margin-bottom:18px;">

                    <div
                        style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            margin-bottom:6px;
                        "
                    >

                        <div
                            style="
                                width:38px;
                                height:38px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                flex-shrink:0;
                                border-radius:10px;
                                background:rgba(245,158,11,.12);
                                color:#d97706;
                            "
                        >

                            <x-heroicon-o-chart-bar class="h-5 w-5" />

                        </div>

                        <h2
                            style="
                                margin:0;
                                font-size:17px;
                                font-weight:700;
                                color:#111827;
                            "
                            class="dark:text-white"
                        >
                            Dashboard Analytics
                        </h2>

                    </div>


                    <p
                        style="
                            margin:0;
                            font-size:13px;
                            line-height:1.5;
                            color:#6b7280;
                        "
                    >
                        Pilih informasi yang ingin ditampilkan.
                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- ANALYTICS BUTTONS                                --}}
                {{-- ================================================= --}}

                <div
                    style="
                        display:flex;
                        flex-direction:column;
                        gap:9px;
                    "
                >

                    {{-- STATUS --}}

                    <button
                        type="button"
                        wire:click="openWidget('status')"
                        style="
                            width:100%;
                            padding:13px;
                            border:1px solid {{ $activeWidget === 'status' ? '#f59e0b' : '#e5e7eb' }};
                            border-radius:10px;
                            background:{{ $activeWidget === 'status' ? 'rgba(245,158,11,.08)' : 'white' }};
                            cursor:pointer;
                            text-align:left;
                            transition:all .15s ease;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <div
                                style="
                                    width:40px;
                                    height:40px;
                                    flex-shrink:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:9px;
                                    background:#fef3c7;
                                    color:#d97706;
                                "
                            >
                                <x-heroicon-o-chart-pie class="h-5 w-5" />
                            </div>

                            <div style="min-width:0;">

                                <div
                                    style="
                                        font-size:14px;
                                        font-weight:600;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    Status Asset
                                </div>

                                <div
                                    style="
                                        margin-top:3px;
                                        font-size:12px;
                                        color:#6b7280;
                                    "
                                >
                                    Available, Service & Retired
                                </div>

                            </div>

                        </div>

                    </button>


                    {{-- COMPANY --}}

                    <button
                        type="button"
                        wire:click="openWidget('company')"
                        style="
                            width:100%;
                            padding:13px;
                            border:1px solid {{ $activeWidget === 'company' ? '#f59e0b' : '#e5e7eb' }};
                            border-radius:10px;
                            background:{{ $activeWidget === 'company' ? 'rgba(245,158,11,.08)' : 'white' }};
                            cursor:pointer;
                            text-align:left;
                            transition:all .15s ease;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <div
                                style="
                                    width:40px;
                                    height:40px;
                                    flex-shrink:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:9px;
                                    background:#dbeafe;
                                    color:#2563eb;
                                "
                            >
                                <x-heroicon-o-building-office-2 class="h-5 w-5" />
                            </div>

                            <div style="min-width:0;">

                                <div
                                    style="
                                        font-size:14px;
                                        font-weight:600;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    Asset per Company
                                </div>

                                <div
                                    style="
                                        margin-top:3px;
                                        font-size:12px;
                                        color:#6b7280;
                                    "
                                >
                                    Distribusi asset perusahaan
                                </div>

                            </div>

                        </div>

                    </button>


                    {{-- DEPARTMENT --}}

                    <button
                        type="button"
                        wire:click="openWidget('department')"
                        style="
                            width:100%;
                            padding:13px;
                            border:1px solid {{ $activeWidget === 'department' ? '#f59e0b' : '#e5e7eb' }};
                            border-radius:10px;
                            background:{{ $activeWidget === 'department' ? 'rgba(245,158,11,.08)' : 'white' }};
                            cursor:pointer;
                            text-align:left;
                            transition:all .15s ease;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <div
                                style="
                                    width:40px;
                                    height:40px;
                                    flex-shrink:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:9px;
                                    background:#dcfce7;
                                    color:#16a34a;
                                "
                            >
                                <x-heroicon-o-users class="h-5 w-5" />
                            </div>

                            <div style="min-width:0;">

                                <div
                                    style="
                                        font-size:14px;
                                        font-weight:600;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    Asset per Department
                                </div>

                                <div
                                    style="
                                        margin-top:3px;
                                        font-size:12px;
                                        color:#6b7280;
                                    "
                                >
                                    Distribusi berdasarkan department
                                </div>

                            </div>

                        </div>

                    </button>


                    {{-- JENIS --}}

                    <button
                        type="button"
                        wire:click="openWidget('jenis')"
                        style="
                            width:100%;
                            padding:13px;
                            border:1px solid {{ $activeWidget === 'jenis' ? '#f59e0b' : '#e5e7eb' }};
                            border-radius:10px;
                            background:{{ $activeWidget === 'jenis' ? 'rgba(245,158,11,.08)' : 'white' }};
                            cursor:pointer;
                            text-align:left;
                            transition:all .15s ease;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <div
                                style="
                                    width:40px;
                                    height:40px;
                                    flex-shrink:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:9px;
                                    background:#ede9fe;
                                    color:#7c3aed;
                                "
                            >
                                <x-heroicon-o-computer-desktop class="h-5 w-5" />
                            </div>

                            <div style="min-width:0;">

                                <div
                                    style="
                                        font-size:14px;
                                        font-weight:600;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    Jenis Asset
                                </div>

                                <div
                                    style="
                                        margin-top:3px;
                                        font-size:12px;
                                        color:#6b7280;
                                    "
                                >
                                    Jenis asset per perusahaan
                                </div>

                            </div>

                        </div>

                    </button>


                    {{-- LOCATION --}}

                    <button
                        type="button"
                        wire:click="openWidget('location')"
                        style="
                            width:100%;
                            padding:13px;
                            border:1px solid {{ $activeWidget === 'location' ? '#f59e0b' : '#e5e7eb' }};
                            border-radius:10px;
                            background:{{ $activeWidget === 'location' ? 'rgba(245,158,11,.08)' : 'white' }};
                            cursor:pointer;
                            text-align:left;
                            transition:all .15s ease;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <div
                                style="
                                    width:40px;
                                    height:40px;
                                    flex-shrink:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:9px;
                                    background:#ffedd5;
                                    color:#ea580c;
                                "
                            >
                                <x-heroicon-o-map-pin class="h-5 w-5" />
                            </div>

                            <div style="min-width:0;">

                                <div
                                    style="
                                        font-size:14px;
                                        font-weight:600;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    Lokasi Asset
                                </div>

                                <div
                                    style="
                                        margin-top:3px;
                                        font-size:12px;
                                        color:#6b7280;
                                    "
                                >
                                    Status asset berdasarkan lokasi
                                </div>

                            </div>

                        </div>

                    </button>


                    {{-- SERVICE --}}

                    <button
                        type="button"
                        wire:click="openWidget('service')"
                        style="
                            width:100%;
                            padding:13px;
                            border:1px solid {{ $activeWidget === 'service' ? '#f59e0b' : '#e5e7eb' }};
                            border-radius:10px;
                            background:{{ $activeWidget === 'service' ? 'rgba(245,158,11,.08)' : 'white' }};
                            cursor:pointer;
                            text-align:left;
                            transition:all .15s ease;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <div
                                style="
                                    width:40px;
                                    height:40px;
                                    flex-shrink:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:9px;
                                    background:#fee2e2;
                                    color:#dc2626;
                                "
                            >
                                <x-heroicon-o-wrench-screwdriver class="h-5 w-5" />
                            </div>

                            <div style="min-width:0;">

                                <div
                                    style="
                                        font-size:14px;
                                        font-weight:600;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    Service
                                </div>

                                <div
                                    style="
                                        margin-top:3px;
                                        font-size:12px;
                                        color:#6b7280;
                                    "
                                >
                                    Statistik service per tahun
                                </div>

                            </div>

                        </div>

                    </button>


                    {{-- SOFTWARE --}}

                    <button
                        type="button"
                        wire:click="openWidget('software')"
                        style="
                            width:100%;
                            padding:13px;
                            border:1px solid {{ $activeWidget === 'software' ? '#f59e0b' : '#e5e7eb' }};
                            border-radius:10px;
                            background:{{ $activeWidget === 'software' ? 'rgba(245,158,11,.08)' : 'white' }};
                            cursor:pointer;
                            text-align:left;
                            transition:all .15s ease;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <div
                                style="
                                    width:40px;
                                    height:40px;
                                    flex-shrink:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:9px;
                                    background:#cffafe;
                                    color:#0891b2;
                                "
                            >
                                <x-heroicon-o-code-bracket class="h-5 w-5" />
                            </div>

                            <div style="min-width:0;">

                                <div
                                    style="
                                        font-size:14px;
                                        font-weight:600;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    Software Assignment
                                </div>

                                <div
                                    style="
                                        margin-top:3px;
                                        font-size:12px;
                                        color:#6b7280;
                                    "
                                >
                                    Software berdasarkan company
                                </div>

                            </div>

                        </div>

                    </button>

                    {{-- PABX --}}

<button
    type="button"
    wire:click="openWidget('pabx')"
    style="
        width:100%;
        padding:13px;
        border:1px solid {{ $activeWidget === 'pabx' ? '#f59e0b' : '#e5e7eb' }};
        border-radius:10px;
        background:{{ $activeWidget === 'pabx' ? 'rgba(245,158,11,.08)' : 'white' }};
        cursor:pointer;
        text-align:left;
        transition:all .15s ease;
    "
>
    <div
        style="
            display:flex;
            align-items:center;
            gap:12px;
        "
    >

        <div
            style="
                width:40px;
                height:40px;
                flex-shrink:0;
                display:flex;
                align-items:center;
                justify-content:center;
                border-radius:9px;
                background:#ede9fe;
                color:#7c3aed;
            "
        >
            <x-heroicon-o-phone class="h-5 w-5" />
        </div>

        <div style="min-width:0;">

            <div
                style="
                    font-size:14px;
                    font-weight:600;
                    color:#111827;
                "
                class="dark:text-white"
            >
                PABX
            </div>

            <div
                style="
                    margin-top:3px;
                    font-size:12px;
                    color:#6b7280;
                "
            >
                Distribusi PABX berdasarkan lokasi
            </div>

        </div>

    </div>

</button>



                    {{-- WARRANTY --}}

                    <button
                        type="button"
                        wire:click="openWidget('warranty')"
                        style="
                            width:100%;
                            padding:13px;
                            border:1px solid {{ $activeWidget === 'warranty' ? '#f59e0b' : '#e5e7eb' }};
                            border-radius:10px;
                            background:{{ $activeWidget === 'warranty' ? 'rgba(245,158,11,.08)' : 'white' }};
                            cursor:pointer;
                            text-align:left;
                            transition:all .15s ease;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <div
                                style="
                                    width:40px;
                                    height:40px;
                                    flex-shrink:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:9px;
                                    background:#fef9c3;
                                    color:#ca8a04;
                                "
                            >
                                <x-heroicon-o-shield-check class="h-5 w-5" />
                            </div>

                            <div style="min-width:0;">

                                <div
                                    style="
                                        font-size:14px;
                                        font-weight:600;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    Warranty
                                </div>

                                <div
                                    style="
                                        margin-top:3px;
                                        font-size:12px;
                                        color:#6b7280;
                                    "
                                >
                                    Asset yang mendekati expired
                                </div>

                            </div>

                        </div>

                    </button>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- ACTIVE WIDGET                                    --}}
            {{-- ================================================= --}}

            <div style="min-width:0;">

                @if ($this->activeWidget && $this->getWidgetClass())

                    <div
                        wire:key="dashboard-widget-{{ $this->activeWidget }}"
                        style="
                            min-width:0;
                            background:white;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:20px;
                            box-shadow:0 1px 3px rgba(0,0,0,.05);
                            overflow:hidden;
                        "
                        class="dark:bg-gray-900 dark:border-gray-700"
                    >

                        {{-- WIDGET HEADER --}}

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                justify-content:space-between;
                                gap:15px;
                                margin-bottom:18px;
                            "
                        >

                            <div style="min-width:0;">

                                <h2
                                    style="
                                        margin:0;
                                        font-size:17px;
                                        font-weight:700;
                                        color:#111827;
                                    "
                                    class="dark:text-white"
                                >
                                    {{ $this->getWidgetTitle() }}
                                </h2>

                            </div>


                            <button
                                type="button"
                                wire:click="closeWidget"
                                style="
                                    display:inline-flex;
                                    align-items:center;
                                    gap:7px;
                                    flex-shrink:0;
                                    padding:8px 12px;
                                    border:1px solid #d1d5db;
                                    border-radius:8px;
                                    background:white;
                                    color:#374151;
                                    font-size:13px;
                                    font-weight:600;
                                    cursor:pointer;
                                "
                                class="dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200"
                            >

                                <x-heroicon-o-x-mark class="h-4 w-4" />

                                Tutup

                            </button>

                        </div>


                        {{-- CHART --}}

                        @livewire(
                            $this->getWidgetClass(),
                            [],
                            key('loaded-widget-' . $this->activeWidget)
                        )

                    </div>

                @else

                    {{-- EMPTY STATE --}}

                    <div
                        style="
                            min-height:360px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            text-align:center;
                            padding:40px;
                            background:white;
                            border:1px dashed #d1d5db;
                            border-radius:14px;
                        "
                        class="dark:bg-gray-900 dark:border-gray-700"
                    >

                        <div>

                            <div
                                style="
                                    width:52px;
                                    height:52px;
                                    margin:0 auto 14px auto;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:14px;
                                    background:rgba(245,158,11,.10);
                                    color:#d97706;
                                "
                            >

                                <x-heroicon-o-chart-bar class="h-7 w-7" />

                            </div>


                            <div
                                style="
                                    font-size:16px;
                                    font-weight:700;
                                    color:#111827;
                                "
                                class="dark:text-white"
                            >
                                Pilih Analytics
                            </div>


                            <div
                                style="
                                    max-width:400px;
                                    margin:6px auto 0 auto;
                                    font-size:13px;
                                    line-height:1.6;
                                    color:#6b7280;
                                "
                            >
                                Pilih salah satu menu analytics di sebelah kiri
                                untuk menampilkan informasi dashboard.
                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- GLOBAL MODAL HOST                                         --}}
    {{-- ========================================================= --}}
    {{--
        PENTING:
        Semua modal Livewire dipasang langsung di Dashboard.

        Modal tidak perlu dimuat melalui ChartWidget.
        Listener #[On(...)] akan selalu aktif selama Dashboard hidup.
    --}}


    {{-- STATUS MODAL --}}

    @livewire(
        'asset-status-modal',
        [],
        key('dashboard-modal-status')
    )


    {{-- COMPANY MODAL --}}

    @livewire(
        'asset-company-modal',
        [],
        key('dashboard-modal-company')
    )


    {{-- DEPARTMENT MODAL --}}

    @livewire(
        'asset-department-modal',
        [],
        key('dashboard-modal-department')
    )


    {{-- JENIS COMPANY MODAL --}}

    @livewire(
        'asset-jenis-company-modal',
        [],
        key('dashboard-modal-jenis-company')
    )


    {{-- LOCATION STATUS MODAL --}}

    @livewire(
        'asset-location-status-modal',
        [],
        key('dashboard-modal-location-status')
    )


    {{-- SERVICE YEAR MODAL --}}

    @livewire(
        'service-year-modal',
        [],
        key('dashboard-modal-service-year')
    )


    {{-- SOFTWARE ASSIGNMENT MODAL --}}

    @livewire(
        'software-assignment-company-modal',
        [],
        key('dashboard-modal-software')
    )

    {{-- PABX LOCATION MODAL --}}

@livewire(
    'pabx-location-modal',
    [],
    key('dashboard-modal-pabx')
)



</x-filament-panels::page>
