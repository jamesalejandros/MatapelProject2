<details open>

    <summary style="
        cursor:pointer;
        list-style:none;
        padding:18px 20px;
        border-radius:16px;
        background:white;
        border:1px solid #e5e7eb;
        font-size:18px;
        font-weight:800;
        display:flex;
        align-items:center;
        justify-content:space-between;
        user-select:none;
    ">

        <span>
            📊 Software Summary
        </span>


        <span style="
            font-size:13px;
            color:#6b7280;
            font-weight:600;
        ">
            Klik untuk buka/tutup
        </span>


    </summary>





<div style="
    margin-top:15px;
    padding:20px;
    border-radius:16px;
    background:white;
    border:1px solid #e5e7eb;
">



@php


$totalSoftware = $records->count();



$totalLicense = $records

    ->sum(function ($software) {

        return $software->license->sum(
            'JumlahLisensi'
        );

    });



$categories = $records

    ->groupBy('SoftCategory')

    ->map(function ($items) {

        return [

            'software'=>$items->count(),


            'license'=>$items->sum(function ($software){

                return $software->license->sum(
                    'JumlahLisensi'
                );

            })

        ];

    });



$companies=[];



foreach($records as $software){


    foreach($software->license as $license){


        if($license->perusahaan){


            $name =
                $license->perusahaan->NamaPerusahaan;



            if(!isset($companies[$name])){


                $companies[$name]=[

                    'software'=>0,

                    'license'=>0

                ];

            }



            $companies[$name]['software']++;


            $companies[$name]['license']
                += (int)$license->JumlahLisensi;


        }


    }


}



@endphp







{{-- TOTAL CARD --}}

<div style="
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:15px;
">



<div style="
padding:18px;
border-radius:12px;
background:#eff6ff;
border:1px solid #bfdbfe;
">

<div style="
font-size:12px;
font-weight:700;
color:#2563eb;
">
TOTAL SOFTWARE
</div>


<div style="
font-size:30px;
font-weight:800;
margin-top:8px;
">
{{ $totalSoftware }}
</div>


</div>






<div style="
padding:18px;
border-radius:12px;
background:#ecfdf5;
border:1px solid #bbf7d0;
">

<div style="
font-size:12px;
font-weight:700;
color:#059669;
">
TOTAL LICENSE
</div>


<div style="
font-size:30px;
font-weight:800;
margin-top:8px;
">
{{ $totalLicense }}
</div>


</div>







<div style="
padding:18px;
border-radius:12px;
background:#fef3c7;
border:1px solid #fde68a;
">

<div style="
font-size:12px;
font-weight:700;
color:#d97706;
">
TOTAL KATEGORI
</div>


<div style="
font-size:30px;
font-weight:800;
margin-top:8px;
">
{{ $categories->count() }}
</div>


</div>


</div>









{{-- CATEGORY --}}

<div style="
margin-top:25px;
font-size:15px;
font-weight:800;
">
📂 Berdasarkan Kategori
</div>




<div style="
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:12px;
margin-top:12px;
">


@foreach($categories as $category=>$data)


<div style="
padding:15px;
border-radius:12px;
background:#f9fafb;
border:1px solid #e5e7eb;
">


<div style="
font-size:13px;
font-weight:700;
color:#6b7280;
">

{{ $category ?: 'Tidak Ada Kategori' }}

</div>



<div style="
margin-top:8px;
font-size:22px;
font-weight:800;
">

{{ $data['software'] }}

<span style="
font-size:12px;
font-weight:500;
color:#6b7280;
">
Software
</span>


</div>



<div style="
margin-top:5px;
font-size:14px;
color:#2563eb;
font-weight:700;
">

{{ $data['license'] }} License

</div>



</div>


@endforeach


</div>









{{-- COMPANY --}}

<div style="
margin-top:25px;
font-size:15px;
font-weight:800;
">
🏢 Berdasarkan Perusahaan
</div>




<div style="
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:12px;
margin-top:12px;
">



@foreach($companies as $company=>$data)



<div style="
padding:15px;
border-radius:12px;
background:white;
border:1px solid #e5e7eb;
">


<div style="
font-size:13px;
font-weight:700;
color:#374151;
">

{{ $company }}

</div>



<div style="
margin-top:8px;
font-size:22px;
font-weight:800;
">

{{ $data['license'] }}

</div>



<div style="
font-size:12px;
color:#6b7280;
">

License

</div>


</div>



@endforeach



</div>





</div>


</details>