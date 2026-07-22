<div
    x-data="{ show:false }"
    style="
        padding:20px;
    "
>


    <div
        style="
            background:#111827;
            color:white;
            padding:20px;
            border-radius:12px;
        "
    >

        <div
            style="
                color:#9ca3af;
                font-size:12px;
                margin-bottom:10px;
            "
        >
            PRODUCT KEY
        </div>


        <div
            style="
                font-family:monospace;
                font-size:20px;
                letter-spacing:2px;
                word-break:break-all;
            "
        >

            <span x-show="!show">
                ••••••••••••••••••
            </span>


            <span x-show="show">
                {{ $license?->ProductKey ?? '-' }}
            </span>


        </div>


        <button
            type="button"
            x-on:click="show=!show"
            style="
                margin-top:15px;
                background:#2563eb;
                color:white;
                padding:8px 16px;
                border-radius:8px;
                border:none;
                cursor:pointer;
            "
        >

            <span x-show="!show">
                👁 Show
            </span>


            <span x-show="show">
                🙈 Hide
            </span>

        </button>


    </div>



    <div style="margin-top:20px">

        <b>License Type:</b>
        {{ $license?->TipeLisensi ?? '-' }}

        <br>

        <b>Quantity:</b>
        {{ $license?->JumlahLisensi ?? '-' }}

    </div>


</div>