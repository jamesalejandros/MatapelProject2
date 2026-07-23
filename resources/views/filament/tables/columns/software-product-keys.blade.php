<div style="display:flex; flex-direction:column; gap:24px;">

@forelse($licenses->sortByDesc('IDLicense') as $license)

<div style="
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:24px;
    background:white;
">

    {{-- HEADER --}}
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    ">

        <div style="
            font-size:18px;
            font-weight:700;
        ">
            🔑 Product Key
        </div>


        @php
            $status = $license->StatusLisensi;
        @endphp


        <span style="
            padding:6px 14px;
            border-radius:999px;
            font-size:12px;
            font-weight:600;

            @if($status == 'Active')
                background:#dcfce7;
                color:#166534;

            @elseif($status == 'Expired')
                background:#fef3c7;
                color:#92400e;

            @else
                background:#fee2e2;
                color:#991b1b;
            @endif
        ">
            {{ $status }}
        </span>


    </div>


    {{-- ID LICENSE BOX --}}
    <div style="
        background:#eff6ff;
        border:1px solid #bfdbfe;
        padding:18px;
        border-radius:10px;
        margin-bottom:20px;
    ">

        <div style="
            font-size:11px;
            color:#2563eb;
            margin-bottom:8px;
            font-weight:600;
        ">
            ID LICENSE
        </div>


        <div style="
            font-family:monospace;
            font-size:18px;
            font-weight:700;
            letter-spacing:2px;
            word-break:break-all;
            color:#1e3a8a;
        ">
            {{ $license->IDLicense ?: '-' }}
        </div>

    </div>



    {{-- PRODUCT KEY BOX --}}
<div
    x-data="{ show: false }"
    style="
        background:#111827;
        color:white;
        padding:18px;
        border-radius:10px;
        margin-bottom:25px;
    "
>

    <div style="
        font-size:11px;
        color:#9ca3af;
        margin-bottom:8px;
    ">
        PRODUCT KEY
    </div>


    <div style="
        font-family:monospace;
        font-size:18px;
        letter-spacing:2px;
        word-break:break-all;
    ">

        <span x-show="!show">
            ••••••••••••••••••••••••••••••••••
        </span>

        <span x-show="show" x-cloak>
            {{ $license->ProductKey ?: '-' }}
        </span>

    </div>


    <button
        type="button"
        x-on:click="show = !show"
        style="
            margin-top:15px;
            background:#2563eb;
            color:white;
            padding:8px 16px;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-size:13px;
            font-weight:600;
        "
    >

        <span x-show="!show">
            👁 Show Product Key
        </span>

        <span x-show="show" x-cloak>
            🙈 Hide Product Key
        </span>

    </button>

</div>


    {{-- KETERANGAN --}}
    @if($license->Keterangan)
    <div style="
        background:#f9fafb;
        border:1px solid #e5e7eb;
        padding:18px;
        border-radius:10px;
        margin-bottom:25px;
    ">

        <div style="
            font-size:11px;
            color:#6b7280;
            margin-bottom:8px;
            font-weight:600;
            letter-spacing:.5px;
        ">
            KETERANGAN
        </div>

        <div style="
            color:#374151;
            line-height:1.7;
            white-space:pre-wrap;
            word-break:break-word;
        ">
            {{ $license->Keterangan }}
        </div>

    </div>
    @endif




    {{-- DETAIL GRID --}}
    <div style="
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:20px;
    ">


        <div>
            <div style="
                color:#6b7280;
                font-size:12px;
                margin-bottom:5px;
            ">
                LICENSE TYPE
            </div>

            <div style="font-weight:600;">
                {{ $license->TipeLisensi ?: '-' }}
            </div>
        </div>



        <div>
            <div style="
                color:#6b7280;
                font-size:12px;
                margin-bottom:5px;
            ">
                QUANTITY
            </div>

            <div style="font-weight:600;">
                {{ $license->JumlahLisensi }}
            </div>
        </div>




        <div>
            <div style="
                color:#6b7280;
                font-size:12px;
                margin-bottom:5px;
            ">
                COMPANY
            </div>

            <div style="font-weight:600;">
                {{ $license->perusahaan?->NamaPerusahaan ?? '-' }}
            </div>
        </div>




        <div>
            <div style="
                color:#6b7280;
                font-size:12px;
                margin-bottom:5px;
            ">
                DVD INSTALLER
            </div>

            <div style="font-weight:600;">
                {{ $license->HasDVD ? '✅ Yes' : '❌ No' }}
            </div>
        </div>




        <div>
            <div style="
                color:#6b7280;
                font-size:12px;
                margin-bottom:5px;
            ">
                BARCODE
            </div>

            <div style="font-weight:600;">
                {{ $license->Barcode ?: '-' }}
            </div>
        </div>



        <div>
            <div style="
                color:#6b7280;
                font-size:12px;
                margin-bottom:5px;
            ">
                STORAGE
            </div>

            <div style="font-weight:600;">
                {{ $license->LokasiSimpan ?: '-' }}
            </div>
        </div>


    </div>


</div>


@empty

<div style="
    padding:30px;
    text-align:center;
    color:#6b7280;
">
    Belum ada Product Key.
</div>

@endforelse

</div>