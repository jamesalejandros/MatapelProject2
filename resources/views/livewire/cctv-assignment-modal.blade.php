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
                max-width:1500px;
                max-height:88vh;
                background:white;
                border-radius:18px;
                overflow:hidden;
                box-shadow:0 25px 50px rgba(0,0,0,.25);
                display:flex;
                flex-direction:column;
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
                        #2563eb,
                        #1d4ed8
                    );
                    color:white;
                    padding:20px 25px;
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:20px;
                    flex-shrink:0;
                "
            >

                <div>

                    {{-- TITLE --}}

                    <div
                        style="
                            font-size:22px;
                            font-weight:700;
                        "
                    >
                        Detail CCTV
                    </div>

                    {{-- LOCATION INFO --}}

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

                        Total :
                        <b>
                            {{ $this->total }}
                        </b>

                        CCTV

                    </div>

                </div>

                {{-- ================================================== --}}
                {{-- CLOSE BUTTON                                       --}}
                {{-- ================================================== --}}

                <button
                    type="button"
                    wire:click="close"
                    aria-label="Tutup"
                    style="
                        background:rgba(255,255,255,.2);
                        border:none;
                        color:white;
                        width:40px;
                        height:40px;
                        border-radius:50%;
                        font-size:22px;
                        line-height:1;
                        cursor:pointer;
                        flex-shrink:0;
                        display:flex;
                        align-items:center;
                        justify-content:center;
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
                    flex:1;
                "
            >

                <table
                    style="
                        width:100%;
                        border-collapse:collapse;
                        min-width:1250px;
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

                            {{-- NO --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                No.
                            </th>

                            {{-- NO ASSET --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                No Asset
                            </th>

                            {{-- NAMA ASSET --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                Nama Asset
                            </th>

                            {{-- LOKASI --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                Lokasi
                            </th>

                            {{-- JENIS CCTV --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                Jenis CCTV
                            </th>

                            {{-- CHANNEL --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                Channel
                            </th>

                            {{-- TANGGAL PASANG --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                Tanggal Pasang
                            </th>

                            {{-- TIPE --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                Tipe
                            </th>

                            {{-- KONDISI --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                Kondisi
                            </th>

                            {{-- KETERANGAN --}}

                            <th
                                style="
                                    padding:12px;
                                    text-align:left;
                                    white-space:nowrap;
                                    font-weight:700;
                                "
                            >
                                Keterangan
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

                                {{-- ================================================== --}}
                                {{-- NO                                                     --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                    "
                                >
                                    {{ $index + 1 }}
                                </td>

                                {{-- ================================================== --}}
                                {{-- NO ASSET                                                --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                        font-weight:600;
                                    "
                                >
                                    {{ $assignment->NoAssetIT ?? '-' }}
                                </td>

                                {{-- ================================================== --}}
                                {{-- NAMA ASSET                                              --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                    "
                                >
                                    {{ $assignment->asset?->Nama ?? '-' }}
                                </td>

                                {{-- ================================================== --}}
                                {{-- LOKASI                                                  --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                    "
                                >
                                    {{ $assignment->asset?->lokasi?->NamaLokasi ?? $this->locationName ?? '-' }}
                                </td>

                                {{-- ================================================== --}}
                                {{-- JENIS CCTV                                              --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                    "
                                >

                                    @if(
                                        isset($assignment->Jenis) &&
                                        trim((string) $assignment->Jenis) !== ''
                                    )

                                        <span
                                            style="
                                                display:inline-block;
                                                padding:5px 9px;
                                                border-radius:7px;
                                                background:#dbeafe;
                                                color:#1d4ed8;
                                                font-size:12px;
                                                font-weight:600;
                                            "
                                        >
                                            {{ $assignment->Jenis }}
                                        </span>

                                    @else

                                        <span style="color:#9ca3af;">
                                            -
                                        </span>

                                    @endif

                                </td>

                                {{-- ================================================== --}}
                                {{-- CHANNEL                                                --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                        font-weight:600;
                                        color:#7c3aed;
                                    "
                                >
                                    {{ $assignment->Channel ?? '-' }}
                                </td>

                                {{-- ================================================== --}}
                                {{-- TANGGAL PASANG                                          --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                    "
                                >

                                    @if($assignment->TanggalPasang)

                                        @php
                                            try {
                                                $tanggalPasang = \Carbon\Carbon::parse(
                                                    $assignment->TanggalPasang
                                                )->format('d-m-Y');
                                            } catch (\Throwable $e) {
                                                $tanggalPasang = $assignment->TanggalPasang;
                                            }
                                        @endphp

                                        {{ $tanggalPasang }}

                                    @else

                                        <span style="color:#9ca3af;">
                                            -
                                        </span>

                                    @endif

                                </td>

                                {{-- ================================================== --}}
                                {{-- TIPE                                                     --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                    "
                                >

                                    @if(
                                        isset($assignment->Tipe) &&
                                        trim((string) $assignment->Tipe) !== ''
                                    )

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
                                            {{ $assignment->Tipe }}
                                        </span>

                                    @else

                                        <span style="color:#9ca3af;">
                                            -
                                        </span>

                                    @endif

                                </td>

                                {{-- ================================================== --}}
                                {{-- KONDISI                                                  --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        white-space:nowrap;
                                    "
                                >

                                    @php

                                        $kondisi = strtolower(
                                            trim(
                                                (string) (
                                                    $assignment->Kondisi ?? ''
                                                )
                                            )
                                        );

                                    @endphp

                                    @if($kondisi !== '')

                                        {{-- ========================================== --}}
                                        {{-- BAIK / NORMAL / AKTIF                       --}}
                                        {{-- ========================================== --}}

                                        @if(
                                            in_array(
                                                $kondisi,
                                                [
                                                    'baik',
                                                    'normal',
                                                    'aktif',
                                                    'good'
                                                ],
                                                true
                                            )
                                        )

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
                                                {{ $assignment->Kondisi }}
                                            </span>

                                        {{-- ========================================== --}}
                                        {{-- RUSAK / MATI                               --}}
                                        {{-- ========================================== --}}

                                        @elseif(
                                            in_array(
                                                $kondisi,
                                                [
                                                    'rusak',
                                                    'mati',
                                                    'damage',
                                                    'damaged'
                                                ],
                                                true
                                            )
                                        )

                                            <span
                                                style="
                                                    display:inline-block;
                                                    padding:5px 9px;
                                                    border-radius:7px;
                                                    background:#fee2e2;
                                                    color:#b91c1c;
                                                    font-size:12px;
                                                    font-weight:600;
                                                "
                                            >
                                                {{ $assignment->Kondisi }}
                                            </span>

                                        {{-- ========================================== --}}
                                        {{-- KONDISI LAIN                               --}}
                                        {{-- ========================================== --}}

                                        @else

                                            <span
                                                style="
                                                    display:inline-block;
                                                    padding:5px 9px;
                                                    border-radius:7px;
                                                    background:#fef3c7;
                                                    color:#b45309;
                                                    font-size:12px;
                                                    font-weight:600;
                                                "
                                            >
                                                {{ $assignment->Kondisi }}
                                            </span>

                                        @endif

                                    @else

                                        <span style="color:#9ca3af;">
                                            -
                                        </span>

                                    @endif

                                </td>

                                {{-- ================================================== --}}
                                {{-- KETERANGAN                                             --}}
                                {{-- ================================================== --}}

                                <td
                                    style="
                                        padding:12px;
                                        min-width:220px;
                                        max-width:400px;
                                    "
                                >
                                    {{ $assignment->Keterangan ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            {{-- ================================================== --}}
                            {{-- EMPTY STATE                                             --}}
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
                                        Tidak ada data CCTV
                                    </div>

                                    <div
                                        style="
                                            margin-top:5px;
                                            font-size:13px;
                                        "
                                    >
                                        Tidak ditemukan assignment CCTV
                                        pada lokasi
                                        <b>
                                            {{ $this->locationName }}
                                        </b>.
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
                    flex-shrink:0;
                    border-top:1px solid #e5e7eb;
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