<x-filament::section
    collapsible
>

<div style="
    display:flex;
    flex-direction:column;
    gap:24px;
">


{{-- HEADER --}}
<div style="
    background:linear-gradient(135deg,#2563eb,#1e40af);
    border-radius:16px;
    padding:24px;
    color:white;
">

<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
">

<div>

<div style="
    font-size:22px;
    font-weight:800;
">
📊 Software License Overview
</div>


<div style="
    margin-top:6px;
    opacity:.85;
    font-size:14px;
">
Statistik license berdasarkan kategori dan perusahaan
</div>


</div>


<div style="
    font-size:42px;
">
💻
</div>


</div>

</div>






{{-- FILTER --}}
<div style="
    display:flex;
    gap:15px;
    align-items:end;
">


<div style="
    flex:1;
">


<label style="
    font-size:13px;
    font-weight:700;
    color:#374151;
">
FILTER PERUSAHAAN
</label>


<select
wire:model.live="selectedCompany"
style="
width:100%;
margin-top:8px;
border-radius:10px;
padding:12px;
border:1px solid #d1d5db;
background:white;
"
>


<option value="">
Semua Perusahaan
</option>


@foreach($this->getCompanyOptions() as $id=>$company)

<option value="{{ $id }}">
{{ $company }}
</option>

@endforeach


</select>


</div>



<button
wire:click="resetFilter"
style="
height:46px;
padding:0 20px;
border-radius:10px;
background:#f3f4f6;
border:1px solid #d1d5db;
font-weight:700;
"
>
↻ Reset
</button>


</div>








{{-- TOTAL LICENSE --}}
<div style="
display:grid;
grid-template-columns:repeat(2,minmax(0,1fr));
gap:20px;
">



<div style="
padding:22px;
border-radius:16px;
background:#eff6ff;
border:1px solid #bfdbfe;
">


<div style="
color:#2563eb;
font-size:13px;
font-weight:700;
">
TOTAL LICENSE
</div>


<div style="
margin-top:10px;
font-size:38px;
font-weight:800;
color:#1d4ed8;
">
{{ $this->getTotalLicense() }}
</div>


</div>




<div style="
padding:22px;
border-radius:16px;
background:#f9fafb;
border:1px solid #e5e7eb;
">


<div style="
color:#6b7280;
font-size:13px;
font-weight:700;
">
TOTAL KATEGORI
</div>


<div style="
margin-top:10px;
font-size:38px;
font-weight:800;
">
{{ count($this->getLicenseCategories()) }}
</div>


</div>


</div>








{{-- CATEGORY CARD --}}

<div style="
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:15px;
">


@foreach($this->getLicenseCategories() as $category=>$total)


<div style="
padding:18px;
border-radius:14px;
background:white;
border:1px solid #e5e7eb;
">


<div style="
font-size:13px;
font-weight:700;
color:#6b7280;
">
{{ strtoupper($category) }}
</div>


<div style="
margin-top:8px;
font-size:30px;
font-weight:800;
color:#111827;
">
{{ $total }}
</div>


<div style="
font-size:12px;
color:#9ca3af;
">
License
</div>


</div>


@endforeach


</div>








{{-- DETAIL COMPANY --}}

<div style="
display:flex;
flex-direction:column;
gap:18px;
">


@forelse($summary as $row)



<div style="
border:1px solid #e5e7eb;
border-radius:16px;
padding:22px;
background:white;
">



<div style="
display:flex;
justify-content:space-between;
align-items:center;
">


<div style="
font-size:18px;
font-weight:800;
">
🏢 {{ $row['company'] }}
</div>



<span style="
background:#dbeafe;
color:#1e40af;
padding:6px 14px;
border-radius:999px;
font-size:12px;
font-weight:700;
">

{{ $row['total_license'] }} License

</span>


</div>







{{-- CATEGORY DETAIL --}}

<div style="
margin-top:20px;
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:15px;
">


@foreach($row['categories'] as $category=>$total)


<div style="
background:#f9fafb;
padding:15px;
border-radius:12px;
">


<div style="
font-size:12px;
color:#6b7280;
font-weight:600;
">
{{ strtoupper($category) }}
</div>


<div style="
font-size:26px;
font-weight:800;
margin-top:5px;
">
{{ $total }}
</div>


<div style="
font-size:12px;
color:#9ca3af;
">
License
</div>


</div>


@endforeach


</div>








{{-- BAR --}}

@php

$total = max($this->getTotalLicense(),1);

$percent =
round(
($row['total_license']/$total)*100
);

@endphp



<div style="
margin-top:20px;
">


<div style="
display:flex;
justify-content:space-between;
font-size:12px;
margin-bottom:6px;
">

<span>
Kontribusi License
</span>


<strong>
{{ $percent }}%
</strong>


</div>




<div style="
height:10px;
background:#e5e7eb;
border-radius:999px;
overflow:hidden;
">


<div style="
height:100%;
width:{{ $percent }}%;
background:linear-gradient(90deg,#2563eb,#06b6d4);
border-radius:999px;
">
</div>


</div>


</div>





</div>





@empty


<div style="
padding:40px;
text-align:center;
color:#6b7280;
border:1px dashed #d1d5db;
border-radius:15px;
">


<div style="
font-size:40px;
">
📭
</div>


<div style="
margin-top:10px;
font-weight:600;
">
Belum ada data license
</div>


</div>


@endforelse


</div>



</div>

</x-filament::section>