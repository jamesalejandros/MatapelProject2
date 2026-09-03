@php
    use App\Models\MstPerusahaan;
@endphp

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
        padding:20px;
    "
>

    {{-- BACKDROP --}}
    <div
        wire:click="close"
        style="
            position:absolute;
            inset:0;
            background:rgba(0,0,0,.55);
            backdrop-filter:blur(4px);
        "
    ></div>


    {{-- MODAL BOX --}}
    <div
        style="
            position:relative;
            width:90%;
            max-width:1200px;
            max-height:85vh;
            background:white;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 25px 50px rgba(0,0,0,.25);
            display:flex;
            flex-direction:column;
        "
    >


        {{-- HEADER --}}
        <div
            style="
                background:linear-gradient(
                    135deg,
                    #8B5CF6,
                    #6D28D9
                );
                color:white;
                padding:20px 25px;
                display:flex;
                justify-content:space-between;
                align-items:center;
                flex-shrink:0;
            "
        >

            <div>

                <div
                    style="
                        font-size:22px;
                        font-weight:700;
                    "
                >
                    Detail Asset
                </div>


                <div
                    style="
                        margin-top:5px;
                        opacity:.9;
                    "
                >

                    Department :
                    <b>
                        {{ $department ?? 'Tidak Diketahui' }}
                    </b>

                    |

                    Status :
                    <b>
                        {{ $statusAsset === 'all' ? 'Semua Status' : $statusAsset }}
                    </b>

                    |

                    Perusahaan :
                    <b>
                        @if($company === 'all')
                            Semua Perusahaan
                        @else
                            {{ MstPerusahaan::find($company)?->NamaPerusahaan ?? '-' }}
                        @endif
                    </b>

                    |

                    Total :
                    <b>
                        {{ $this->assets->count() }}
                    </b>

                    Asset

                </div>

            </div>


            <button
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
                    display:flex;
                    align-items:center;
                    justify-content:center;
                "
            >
                ×
            </button>

        </div>


        {{-- FILTER --}}
        <div
            style="
                padding:20px 25px 0 25px;
                background:white;
                flex-shrink:0;
            "
        >

            <div
                style="
                    display:flex;
                    align-items:center;
                    gap:12px;
                    flex-wrap:wrap;
                "
            >

                <label
                    style="
                        font-weight:600;
                        color:#374151;
                        white-space:nowrap;
                    "
                >
                    Status Asset
                </label>


                <select
                    wire:model.live="statusAsset"
                    style="
                        padding:9px 35px 9px 12px;
                        border:1px solid #d1d5db;
                        border-radius:8px;
                        background:white;
                        color:#374151;
                        min-width:180px;
                        outline:none;
                    "
                >

                    <option value="all">
                        Semua Status
                    </option>

                    <option value="Available">
                        Available
                    </option>

                    <option value="In Service">
                        In Service
                    </option>

                    <option value="Retired">
                        Retired
                    </option>

                </select>


                <label
                    style="
                        font-weight:600;
                        color:#374151;
                        white-space:nowrap;
                    "
                >
                    Perusahaan
                </label>


                <select
                    wire:model.live="company"
                    style="
                        padding:9px 35px 9px 12px;
                        border:1px solid #d1d5db;
                        border-radius:8px;
                        background:white;
                        color:#374151;
                        min-width:220px;
                        outline:none;
                    "
                >

                    <option value="all">
                        Semua Perusahaan
                    </option>

                    @foreach(
                        MstPerusahaan::query()
                            ->orderBy('NamaPerusahaan')
                            ->get()
                        as $perusahaan
                    )

                        <option value="{{ $perusahaan->IDPerusahaan }}">
                            {{ $perusahaan->NamaPerusahaan }}
                        </option>

                    @endforeach

                </select>


                <button
                    type="button"
                    wire:click="exportExcel"
                    wire:loading.attr="disabled"
                    style="
                        padding:9px 18px;
                        background:#16A34A;
                        color:white;
                        border:none;
                        border-radius:8px;
                        font-weight:600;
                        cursor:pointer;
                        display:flex;
                        align-items:center;
                        gap:8px;
                    "
                >

                    <span wire:loading.remove wire:target="exportExcel">
                        📊 Export Excel
                    </span>

                    <span wire:loading wire:target="exportExcel">
                        ⏳ Membuat Excel...
                    </span>

                </button>


            </div>

        </div>


        {{-- CONTENT --}}
        <div
            style="
                padding:25px;
                overflow:auto;
                max-height:65vh;
                flex:1;
            "
        >

            <table
                style="
                    width:100%;
                    border-collapse:collapse;
                "
            >

                <thead>

                    <tr
                        style="
                            background:#f3f4f6;
                        "
                    >

                        {{-- NO --}}
                        <th
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                            "
                        >
                            No.
                        </th>


                        {{-- NO ASSET --}}
                        <th
                            wire:click="sortBy('NoAssetIT')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            No Asset

                            @if($sortColumn === 'NoAssetIT')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>


                        {{-- NO ASSET SAP --}}
                        <th
                            wire:click="sortBy('NoAssetSAP')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            NoAssetSAP

                            @if($sortColumn === 'NoAssetSAP')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>


                        {{-- NAMA ASSET --}}
                        <th
                            wire:click="sortBy('Nama')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            Nama Asset

                            @if($sortColumn === 'Nama')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>


                        {{-- JENIS --}}
                        <th
                            wire:click="sortBy('Jenis')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            Jenis

                            @if($sortColumn === 'Jenis')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>


                        {{-- DEPARTMENT --}}
                        <th
                            wire:click="sortBy('Department')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            Department

                            @if($sortColumn === 'Department')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>


                        {{-- PEMEGANG --}}
                        <th
                            wire:click="sortBy('Pemegang')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            Pemegang

                            @if($sortColumn === 'Pemegang')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>


                        {{-- PERUSAHAAN --}}
                        <th
                            wire:click="sortBy('Perusahaan')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            Perusahaan

                            @if($sortColumn === 'Perusahaan')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>


                        {{-- LOKASI --}}
                        <th
                            wire:click="sortBy('Lokasi')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            Lokasi

                            @if($sortColumn === 'Lokasi')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>


                        {{-- STATUS --}}
                        <th
                            wire:click="sortBy('StatusAsset')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >
                            Status Asset

                            @if($sortColumn === 'StatusAsset')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @else
                                ↕
                            @endif
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($this->assets as $index => $asset)

                    <tr
                        style="
                            border-bottom:1px solid #e5e7eb;
                        "
                    >

                        <td style="padding:12px">
                            {{ $index + 1 }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->NoAssetIT }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->NoAssetSAP ?? '-' }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->Nama ?? '-' }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->Jenis ?? '-' }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->karyawan?->departemen?->NamaDept ?? 'Tidak Diketahui' }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->karyawan?->Nama ?? '-' }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->perusahaan?->NamaPerusahaan ?? '-' }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->lokasi?->NamaLokasi ?? '-' }}
                        </td>

                        <td style="padding:12px">
                            {{ $asset->StatusAsset ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="10"
                            style="
                                padding:30px;
                                text-align:center;
                                color:#6b7280;
                            "
                        >
                            Tidak ada data asset
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- FOOTER --}}
        <div
            style="
                padding:14px 25px;
                background:#f9fafb;
                border-top:1px solid #e5e7eb;
                display:flex;
                justify-content:flex-end;
                align-items:center;
                flex-shrink:0;
            "
        >

            <button
                type="button"
                wire:click="close"
                style="
                    display:inline-flex;
                    align-items:center;
                    justify-content:center;
                    gap:7px;
                    background:#374151;
                    color:white;
                    border:none;
                    padding:9px 18px;
                    border-radius:9px;
                    font-size:14px;
                    font-weight:600;
                    cursor:pointer;
                    box-shadow:0 1px 2px rgba(0,0,0,.08);
                "
            >

                <x-heroicon-o-x-mark
                    style="
                        width:17px;
                        height:17px;
                    "
                />

                Tutup

            </button>

        </div>

    </div>

</div>

@endif

</div>
