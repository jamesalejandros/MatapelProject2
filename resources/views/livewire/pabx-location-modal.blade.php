<div>
@if($show)

<div
    style="
        position:fixed;
        inset:0;
        z-index:9999;
        display:flex;
        align-items:center;
        justify-content:center;
    "
>

    {{-- ====================================================== --}}
    {{-- BACKDROP                                               --}}
    {{-- ====================================================== --}}

    <div
        wire:click="close"
        style="
            position:absolute;
            inset:0;
            background:rgba(0,0,0,.55);
            backdrop-filter:blur(4px);
        "
    ></div>

    {{-- ====================================================== --}}
    {{-- MODAL                                                  --}}
    {{-- ====================================================== --}}

    <div
        style="
            position:relative;
            width:95%;
            max-width:1400px;
            max-height:88vh;
            background:white;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 25px 50px rgba(0,0,0,.25);
        "
        class="dark:bg-gray-900"
    >

        {{-- ================================================== --}}
        {{-- HEADER                                             --}}
        {{-- ================================================== --}}

        <div
            style="
                background:linear-gradient(
                    135deg,
                    #7c3aed,
                    #4f46e5
                );
                color:white;
                padding:20px 25px;
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:20px;
            "
        >

            <div>

                <div
                    style="
                        font-size:22px;
                        font-weight:700;
                    "
                >
                    Detail PABX
                </div>

                <div
                    style="
                        margin-top:6px;
                        opacity:.9;
                        font-size:14px;
                    "
                >

                    Lokasi :
                    <b>
                        {{ $this->locationName }}
                    </b>

                    &nbsp; | &nbsp;

                    Jenis :
                    <b>
                        {{ $this->jenisName }}
                    </b>

                    &nbsp; | &nbsp;

                    Total :
                    <b>
                        {{ $this->total }}
                    </b>

                    PABX

                </div>

            </div>

            {{-- ================================================== --}}
            {{-- CLOSE BUTTON                                       --}}
            {{-- ================================================== --}}

            <button
                type="button"
                wire:click="close"
                style="
                    background:rgba(255,255,255,.2);
                    border:none;
                    color:white;
                    width:40px;
                    height:40px;
                    border-radius:50%;
                    font-size:22px;
                    cursor:pointer;
                    flex-shrink:0;
                "
            >
                ×
            </button>

        </div>

        {{-- ================================================== --}}
        {{-- CONTENT                                             --}}
        {{-- ================================================== --}}

        <div
            style="
                padding:25px;
                overflow:auto;
                max-height:68vh;
            "
        >

            <table
                style="
                    width:100%;
                    border-collapse:collapse;
                    min-width:1100px;
                "
            >

                {{-- ================================================== --}}
                {{-- TABLE HEADER                                         --}}
                {{-- ================================================== --}}

                <thead>

                    <tr
                        style="
                            background:#f3f4f6;
                        "
                        class="dark:bg-gray-800"
                    >

                        {{-- ================================================= --}}
                        {{-- NO.                                                --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >
                            No.
                        </th>

                        {{-- ================================================= --}}
                        {{-- NO ASSET                                           --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('NoAssetIT')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                No Asset

                                @if($sortField === 'NoAssetIT')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                        {{-- ================================================= --}}
                        {{-- NAMA ASSET                                         --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('asset.Nama')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                Nama Asset

                                @if($sortField === 'asset.Nama')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                        {{-- ================================================= --}}
{{-- LOKASI                                            --}}
{{-- ================================================= --}}

<th
    style="
        padding:0;
        text-align:left;
        white-space:nowrap;
    "
>

    <button
        type="button"
        wire:click="sortBy('location.NamaLokasi')"
        style="
            width:100%;
            padding:12px;
            border:none;
            background:transparent;
            text-align:left;
            font-weight:700;
            cursor:pointer;
            color:inherit;
        "
    >
        Lokasi

        @if($sortField === 'location.NamaLokasi')

            @if($sortDirection === 'asc')
                <span style="margin-left:5px;">↑</span>
            @else
                <span style="margin-left:5px;">↓</span>
            @endif

        @else

            <span
                style="
                    margin-left:5px;
                    color:#9ca3af;
                "
            >
                ↕
            </span>

        @endif

    </button>

</th>


                        {{-- ================================================= --}}
                        {{-- JENIS PABX                                         --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('Jenis')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                Jenis PABX

                                @if($sortField === 'Jenis')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                        {{-- ================================================= --}}
                        {{-- EXTENSION                                          --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('NoExt')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                Extension

                                @if($sortField === 'NoExt')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                        {{-- ================================================= --}}
                        {{-- KARYAWAN                                           --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('karyawan.Nama')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                Karyawan

                                @if($sortField === 'karyawan.Nama')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                        {{-- ================================================= --}}
                        {{-- RUANGAN                                            --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('ruangan.NamaRuangan')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                Ruangan

                                @if($sortField === 'ruangan.NamaRuangan')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                        {{-- ================================================= --}}
                        {{-- SAMBUNGAN                                          --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('sambungan.Rule')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                Sambungan

                                @if($sortField === 'sambungan.Rule')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                        {{-- ================================================= --}}
                        {{-- PIN                                                --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('Pin')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                PIN

                                @if($sortField === 'Pin')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                        {{-- ================================================= --}}
                        {{-- KETERANGAN                                         --}}
                        {{-- ================================================= --}}

                        <th
                            style="
                                padding:0;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >

                            <button
                                type="button"
                                wire:click="sortBy('Keterangan')"
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:none;
                                    background:transparent;
                                    text-align:left;
                                    font-weight:700;
                                    cursor:pointer;
                                    color:inherit;
                                "
                            >
                                Keterangan

                                @if($sortField === 'Keterangan')

                                    @if($sortDirection === 'asc')
                                        <span style="margin-left:5px;">↑</span>
                                    @else
                                        <span style="margin-left:5px;">↓</span>
                                    @endif

                                @else

                                    <span
                                        style="
                                            margin-left:5px;
                                            color:#9ca3af;
                                        "
                                    >
                                        ↕
                                    </span>

                                @endif
                            </button>

                        </th>

                    </tr>

                </thead>

                {{-- ================================================== --}}
                {{-- TABLE BODY                                           --}}
                {{-- ================================================== --}}

                <tbody>

                    @forelse($this->assignments as $index => $assignment)

                        <tr
                            style="
                                border-bottom:1px solid #e5e7eb;
                            "
                            class="dark:border-gray-700"
                        >

                            {{-- ================================================= --}}
                            {{-- NO.                                                --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                "
                            >
                                {{ $index + 1 }}
                            </td>

                            {{-- ================================================= --}}
                            {{-- NO ASSET                                           --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                    font-weight:600;
                                "
                            >
                                {{ $assignment->NoAssetIT ?? '-' }}
                            </td>

                            {{-- ================================================= --}}
                            {{-- NAMA ASSET                                         --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                "
                            >
                                {{ $assignment->asset?->Nama ?? '-' }}
                            </td>

                            {{-- ================================================= --}}
{{-- LOKASI                                            --}}
{{-- ================================================= --}}

<td
    style="
        padding:12px;
        white-space:nowrap;
    "
>
    {{ $assignment->asset?->lokasi?->NamaLokasi ?? '-' }}
</td>


                            {{-- ================================================= --}}
                            {{-- JENIS PABX                                         --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                "
                            >

                                <span
                                    style="
                                        display:inline-block;
                                        padding:5px 9px;
                                        border-radius:7px;
                                        background:#ede9fe;
                                        color:#6d28d9;
                                        font-size:12px;
                                        font-weight:600;
                                    "
                                >
                                    {{ $assignment->Jenis ?? '-' }}
                                </span>

                            </td>

                            {{-- ================================================= --}}
                            {{-- EXTENSION                                          --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                    font-weight:600;
                                    color:#2563eb;
                                "
                            >
                                {{ $assignment->NoExt ?? '-' }}
                            </td>

                            {{-- ================================================= --}}
                            {{-- KARYAWAN                                           --}}
                            {{-- ================================================= --}}
                            {{--                                                   --}}
                            {{-- SUMBER KARYAWAN:                                  --}}
                            {{-- trxpabxassignment.NIK                              --}}
                            {{--        -> mstkaryawan.NIK                         --}}
                            {{--                                                   --}}
                            {{-- TIDAK menggunakan asset.karyawan.                --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                "
                            >
                                {{ $assignment->karyawan?->Nama ?? '-' }}
                            </td>

                            {{-- ================================================= --}}
                            {{-- RUANGAN                                            --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                "
                            >
                                {{ $assignment->ruangan?->NamaRuangan ?? '-' }}
                            </td>

                            {{-- ================================================= --}}
                            {{-- SAMBUNGAN                                          --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                "
                            >

                                @if($assignment->sambungan)

                                    <span
                                        style="
                                            display:inline-block;
                                            padding:5px 9px;
                                            border-radius:7px;
                                            background:#dcfce7;
                                            color:#15803d;
                                            font-size:12px;
                                            font-weight:600;
                                        "
                                    >
                                        {{ $assignment->sambungan->Rule ?? '-' }}
                                    </span>

                                @else

                                    <span
                                        style="
                                            color:#9ca3af;
                                        "
                                    >
                                        -
                                    </span>

                                @endif

                            </td>

                            {{-- ================================================= --}}
                            {{-- PIN                                                --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    white-space:nowrap;
                                "
                            >
                                {{ $assignment->Pin ?? '-' }}
                            </td>

                            {{-- ================================================= --}}
                            {{-- KETERANGAN                                         --}}
                            {{-- ================================================= --}}

                            <td
                                style="
                                    padding:12px;
                                    min-width:180px;
                                "
                            >
                                {{ $assignment->Keterangan ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        {{-- ================================================== --}}
                        {{-- EMPTY STATE                                         --}}
                        {{-- ================================================== --}}

                        <tr>

                            <td
                                colspan="10"
                                style="
                                    padding:40px;
                                    text-align:center;
                                    color:#6b7280;
                                "
                            >

                                <div
                                    style="
                                        font-size:15px;
                                        font-weight:600;
                                    "
                                >
                                    Tidak ada data PABX
                                </div>

                                <div
                                    style="
                                        margin-top:5px;
                                        font-size:13px;
                                    "
                                >
                                    Tidak ditemukan assignment PABX
                                    pada lokasi dan jenis yang dipilih.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- ================================================== --}}
        {{-- FOOTER                                             --}}
        {{-- ================================================== --}}

        <div
            style="
                padding:15px 25px;
                background:#f9fafb;
                text-align:right;
            "
            class="dark:bg-gray-800"
        >

            <button
                type="button"
                wire:click="close"
                style="
                    background:#374151;
                    color:white;
                    border:none;
                    padding:10px 20px;
                    border-radius:10px;
                    cursor:pointer;
                    font-weight:600;
                "
            >
                Tutup
            </button>

        </div>

    </div>

</div>

@endif

</div>