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
    background:linear-gradient(135deg,#059669,#065f46);
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
Statistik license seluruh software berdasarkan perusahaan dan kategori
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
">
FILTER PERUSAHAAN
</label>


<select
wire:model.live="selectedCompany"
style="
width:100%;
margin-top:8px;
padding:12px;
border-radius:10px;
border:1px solid #d1d5db;
"
>


<option value="">
Semua Perusahaan
</option>


@foreach($companyOptions as $id=>$company)

<option value="{{ $id }}">
{{ $company }}
</option>

@endforeach


</select>


</div>






<div style="
flex:1;
">


<label style="
font-size:13px;
font-weight:700;
">
FILTER KATEGORI
</label>


<select
wire:model.live="selectedCategory"
style="
width:100%;
margin-top:8px;
padding:12px;
border-radius:10px;
border:1px solid #d1d5db;
"
>


<option value="">
Semua Kategori
</option>



@foreach($categoryOptions as $category)


<option value="{{ $category }}">
{{ $category }}
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









{{-- TOTAL CARD --}}


<div style="
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:15px;
">





<div style="
background:#ecfdf5;
border:1px solid #a7f3d0;
padding:20px;
border-radius:15px;
">


<div style="
font-size:13px;
font-weight:700;
color:#047857;
">
TOTAL LICENSE
</div>


<div style="
font-size:36px;
font-weight:800;
margin-top:8px;
">
{{ $this->getTotalLicense() }}
</div>


</div>






<div style="
background:#eff6ff;
border:1px solid #bfdbfe;
padding:20px;
border-radius:15px;
">


<div style="
font-size:13px;
font-weight:700;
color:#2563eb;
">
TOTAL SOFTWARE
</div>


<div style="
font-size:36px;
font-weight:800;
margin-top:8px;
">
{{ $this->getTotalSoftware() }}
</div>


</div>






<div style="
background:#fff7ed;
border:1px solid #fed7aa;
padding:20px;
border-radius:15px;
">


<div style="
font-size:13px;
font-weight:700;
color:#c2410c;
">
TOTAL KATEGORI
</div>


<div style="
font-size:36px;
font-weight:800;
margin-top:8px;
">
{{ $this->getTotalCategory() }}
</div>


</div>



</div>









{{-- SOFTWARE DETAIL --}}


<div style="
display:flex;
flex-direction:column;
gap:15px;
">


<div style="
font-size:18px;
font-weight:800;
">
💾 Detail Software
</div>



@forelse($summary as $row)



<div style="
background:white;
border:1px solid #e5e7eb;
border-radius:15px;
padding:20px;
">



<div style="
display:flex;
justify-content:space-between;
align-items:center;
">


<div style="
font-size:17px;
font-weight:800;
">
{{ $row['software'] }}
</div>



<span style="
background:#dcfce7;
color:#166534;
padding:6px 14px;
border-radius:999px;
font-weight:700;
font-size:12px;
">

{{ $row['total_license'] }} License

</span>



</div>







<div style="
margin-top:15px;
display:flex;
gap:8px;
flex-wrap:wrap;
">


@foreach($row['category'] as $category)


<span style="
background:#f3f4f6;
padding:6px 12px;
border-radius:999px;
font-size:12px;
">

🏷 {{ $category }}

</span>


@endforeach



</div>






<div style="
margin-top:12px;
font-size:13px;
color:#6b7280;
">


🏢

@foreach($row['company'] as $company)

{{ $company }}

@if(!$loop->last)
,
@endif

@endforeach


</div>



</div>



@empty


<div style="
padding:40px;
text-align:center;
border:1px dashed #d1d5db;
border-radius:15px;
color:#6b7280;
">

📭

<br>

Belum ada data license


</div>


@endforelse



</div>









{{-- CATEGORY BREAKDOWN --}}


<div style="
margin-top:20px;
display:flex;
flex-direction:column;
gap:15px;
">


<div style="
font-size:18px;
font-weight:800;
">
🏷 Breakdown Kategori
</div>




@foreach($categorySummary as $row)



<div style="
border:1px solid #e5e7eb;
border-radius:15px;
padding:20px;
background:#fafafa;
">



<div style="
display:flex;
justify-content:space-between;
">

<div style="
font-weight:800;
font-size:16px;
">

{{ $row['category'] }}

</div>


<div style="
font-weight:800;
">

{{ $row['total'] }} License

</div>


</div>






<div style="
margin-top:15px;
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:10px;
">


@foreach($row['company'] as $company=>$total)


<div style="
background:white;
padding:12px;
border-radius:10px;
border:1px solid #e5e7eb;
">


<div style="
font-size:12px;
color:#6b7280;
">
{{ $company }}
</div>


<div style="
font-size:22px;
font-weight:800;
margin-top:5px;
">
{{ $total }}
</div>


</div>


@endforeach



</div>



</div>



@endforeach



</div>





</div>


</x-filament::section>