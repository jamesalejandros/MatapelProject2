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

    {{-- ===================================================== --}}
    {{-- BACKDROP --}}
    {{-- ===================================================== --}}

    <div
        wire:click="close"
        style="
            position:absolute;
            inset:0;
            background:rgba(0,0,0,.55);
            backdrop-filter:blur(4px);
        "
    ></div>


    {{-- ===================================================== --}}
    {{-- MODAL BOX --}}
    {{-- ===================================================== --}}

    <div
        style="
            position:relative;
            width:95%;
            max-width:1400px;
            max-height:90vh;
            background:white;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 25px 50px rgba(0,0,0,.25);
            display:flex;
            flex-direction:column;
        "
    >


        {{-- ================================================= --}}
        {{-- HEADER --}}
        {{-- ================================================= --}}

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
                    Detail Software Assignment
                </div>


                <div
                    style="
                        margin-top:5px;
                        opacity:.9;
                    "
                >

                    Software :
                    <b>
                        {{ $software }}
                    </b>

                    |

                    Status :
                    <b>
                        {{ $statusAssignment === 'all'
                            ? 'Semua Status'
                            : $statusAssignment
                        }}
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

                    Total Pemakai :
                    <b>
                        {{ $this->total }}
                    </b>

                </div>

            </div>


            {{-- CLOSE BUTTON --}}

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
                    display:flex;
                    align-items:center;
                    justify-content:center;
                "
            >
                ×
            </button>

        </div>


        {{-- ================================================= --}}
        {{-- FILTER --}}
        {{-- ================================================= --}}

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


                {{-- STATUS ASSIGNMENT --}}

                <label
                    style="
                        font-weight:600;
                        color:#374151;
                        white-space:nowrap;
                    "
                >
                    Status Assignment
                </label>


                <select
                    wire:model.live="statusAssignment"
                    style="
                        padding:9px 35px 9px 12px;
                        border:1px solid #d1d5db;
                        border-radius:8px;
                        background:white;
                        color:#374151;
                        min-width:200px;
                        outline:none;
                    "
                >

                    <option value="all">
                        Semua Status
                    </option>

                    <option value="Installed">
                        Installed
                    </option>

                    <option value="Revoked">
                        Revoked
                    </option>

                </select>


                {{-- PERUSAHAAN --}}

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

                        <option
                            value="{{ $perusahaan->IDPerusahaan }}"
                        >
                            {{ $perusahaan->NamaPerusahaan }}
                        </option>

                    @endforeach

                </select>


                {{-- EXPORT --}}

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

                    <span
                        wire:loading.remove
                        wire:target="exportExcel"
                    >
                        📊 Export Excel
                    </span>


                    <span
                        wire:loading
                        wire:target="exportExcel"
                    >
                        ⏳ Membuat Excel...
                    </span>

                </button>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- CONTENT --}}
        {{-- ================================================= --}}

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
                    min-width:1250px;
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


                        {{-- SOFTWARE --}}

                        <th
                            wire:click="sortBy('Software')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            Software

                            @if($sortColumn === 'Software')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>


                        {{-- VERSION --}}

                        <th
                            wire:click="sortBy('Version')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            Version

                            @if($sortColumn === 'Version')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>


                        {{-- ID LICENSE --}}

                        <th
                            wire:click="sortBy('IDLicense')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            ID License

                            @if($sortColumn === 'IDLicense')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>


                        {{-- NIK --}}

                        <th
                            wire:click="sortBy('NIK')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            NIK

                            @if($sortColumn === 'NIK')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>


                        {{-- NAMA PEMAKAI --}}

                        <th
                            wire:click="sortBy('NamaPemakai')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            Nama Pemakai

                            @if($sortColumn === 'NamaPemakai')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

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

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>


                        {{-- NAMA ASSET --}}

                        <th
                            wire:click="sortBy('NamaAsset')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            Nama Asset

                            @if($sortColumn === 'NamaAsset')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>


                        {{-- COMPUTER NAME --}}

                        <th
                            wire:click="sortBy('ComputerName')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            Computer Name

                            @if($sortColumn === 'ComputerName')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

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

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>


                        {{-- TANGGAL ASSIGN --}}

                        <th
                            wire:click="sortBy('TanggalAssign')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            Tanggal Assign

                            @if($sortColumn === 'TanggalAssign')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>


                        {{-- STATUS --}}

                        <th
                            wire:click="sortBy('StatusAssignment')"
                            style="
                                padding:12px;
                                text-align:left;
                                white-space:nowrap;
                                cursor:pointer;
                                user-select:none;
                            "
                        >

                            Status

                            @if($sortColumn === 'StatusAssignment')

                                {{ $sortDirection === 'asc'
                                    ? '↑'
                                    : '↓'
                                }}

                            @else

                                ↕

                            @endif

                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse(
                    $this->assignments
                    as $index => $assignment
                )

                    <tr
                        style="
                            border-bottom:1px solid #e5e7eb;
                        "
                    >

                        <td style="padding:12px">
                            {{ $index + 1 }}
                        </td>


                        <td style="padding:12px">
                            {{ $assignment->NamaSoftware }}
                        </td>


                        <td style="padding:12px">
                            {{ $assignment->Version ?? '-' }}
                        </td>


                        <td style="padding:12px">
                            {{ $assignment->IDLicense ?? '-' }}
                        </td>


                        <td style="padding:12px">
                            {{ $assignment->NIK ?? '-' }}
                        </td>


                        <td
                            style="
                                padding:12px;
                                font-weight:600;
                            "
                        >
                            {{ $assignment->NamaPemakai
                                ?? 'Belum Ada Pemakai'
                            }}
                        </td>


                        <td style="padding:12px">
                            {{ $assignment->NoAssetIT ?? '-' }}
                        </td>


                        <td style="padding:12px">
                            {{ $assignment->NamaAsset ?? '-' }}
                        </td>


                        <td style="padding:12px">
                            {{ $assignment->ComputerName ?? '-' }}
                        </td>


                        <td style="padding:12px">
                            {{ $assignment->NamaPerusahaan ?? '-' }}
                        </td>


                        <td style="padding:12px">

                            {{ $assignment->TanggalAssign
                                ? \Carbon\Carbon::parse(
                                    $assignment->TanggalAssign
                                )->format('d/m/Y H:i')
                                : '-'
                            }}

                        </td>


                        <td style="padding:12px">

                            <span
                                style="
                                    display:inline-block;
                                    padding:5px 10px;
                                    border-radius:999px;
                                    background:
                                        {{ $assignment->StatusAssignment === 'Installed'
                                            ? '#DCFCE7'
                                            : '#FEE2E2'
                                        }};
                                    color:
                                        {{ $assignment->StatusAssignment === 'Installed'
                                            ? '#166534'
                                            : '#991B1B'
                                        }};
                                    font-size:12px;
                                    font-weight:600;
                                "
                            >

                                {{ $assignment->StatusAssignment }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="12"
                            style="
                                padding:30px;
                                text-align:center;
                                color:#6b7280;
                            "
                        >
                            Tidak ada data software assignment.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- ================================================= --}}
        {{-- FOOTER --}}
        {{-- ================================================= --}}

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
