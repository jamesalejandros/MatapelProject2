<section class="space-y-6">
{{-- =========================================================
    PROFILE INFORMATION HEADER
========================================================== --}}

<div>
    <div class="flex items-start gap-3">

        {{-- ICON --}}

        <div
            class="
                flex
                h-10
                w-10
                shrink-0
                items-center
                justify-center
                rounded-xl
                bg-blue-100
                text-blue-600
            "
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                />
            </svg>

        </div>

        {{-- TITLE --}}

        <div class="min-w-0">

            <h2
                class="
                    text-lg
                    font-semibold
                    text-slate-900
                "
            >
                {{ __('Profile Information') }}
            </h2>

            <p
                class="
                    mt-1
                    text-sm
                    leading-6
                    text-slate-500
                "
            >
                {{ __("Informasi nama dan email akun Anda.") }}
            </p>

        </div>

    </div>
</div>

{{-- =========================================================
    PROFILE CARD
========================================================== --}}

<div
    class="
        overflow-hidden
        rounded-2xl
        border
        border-slate-200
        bg-white
        shadow-sm
    "
>

    {{-- =====================================================
        CARD HEADER
    ====================================================== --}}

    <div
        class="
            border-b
            border-slate-200
            bg-slate-50/70
            px-5
            py-4
            sm:px-6
        "
    >

        <div class="flex items-start gap-3">

            <div
                class="
                    mt-0.5
                    flex
                    h-8
                    w-8
                    shrink-0
                    items-center
                    justify-center
                    rounded-lg
                    bg-slate-100
                    text-slate-500
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 6.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12 12.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12 18.75a.75.75 0 100-1.5.75.75 0 000 1.5z"
                    />
                </svg>

            </div>

            <div>

                <h3
                    class="
                        text-sm
                        font-semibold
                        text-slate-900
                    "
                >
                    Informasi Akun
                </h3>

                <p
                    class="
                        mt-0.5
                        text-xs
                        leading-5
                        text-slate-500
                    "
                >
                    Nama dan email diambil dari data akun yang terdaftar.
                </p>

            </div>

        </div>

    </div>

    {{-- =====================================================
        PROFILE CONTENT
    ====================================================== --}}

    <div
        class="
            space-y-6
            p-5
            sm:p-6
        "
    >

        {{-- =================================================
            NAME
        ================================================== --}}

        <div>

            <x-input-label
                for="name"
                :value="__('Name')"
                class="text-sm font-medium text-slate-700"
            />

            <div class="relative mt-2">

                <div
                    class="
                        pointer-events-none
                        absolute
                        inset-y-0
                        left-0
                        flex
                        items-center
                        pl-3.5
                        text-slate-400
                    "
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                        />
                    </svg>

                </div>

                <input
                    id="name"
                    type="text"
                    value="{{ $user->name }}"
                    readonly
                    aria-readonly="true"
                    autocomplete="name"
                    class="
                        block
                        w-full
                        rounded-xl
                        border
                        border-slate-200
                        bg-slate-50
                        py-2.5
                        pl-11
                        pr-11
                        text-sm
                        font-medium
                        text-slate-700
                        shadow-sm
                        outline-none
                        cursor-not-allowed
                    "
                />

                {{-- READONLY ICON --}}

                <div
                    class="
                        pointer-events-none
                        absolute
                        inset-y-0
                        right-0
                        flex
                        items-center
                        pr-3.5
                        text-slate-400
                    "
                    title="Tidak dapat diubah"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 10.5V7.75a4.5 4.5 0 00-9 0v2.75m-.75 0h10.5A1.75 1.75 0 0119 12.25v6A1.75 1.75 0 0117.25 20H6.75A1.75 1.75 0 015 18.25v-6a1.75 1.75 0 011.75-1.75z"
                        />
                    </svg>

                </div>

            </div>

            <p
                class="
                    mt-2
                    text-xs
                    text-slate-400
                "
            >
                Nama akun tidak dapat diubah melalui halaman ini.
            </p>

        </div>

        {{-- =================================================
            EMAIL
        ================================================== --}}

        <div>

            <x-input-label
                for="email"
                :value="__('Email')"
                class="text-sm font-medium text-slate-700"
            />

            <div class="relative mt-2">

                <div
                    class="
                        pointer-events-none
                        absolute
                        inset-y-0
                        left-0
                        flex
                        items-center
                        pl-3.5
                        text-slate-400
                    "
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.92l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615a2.25 2.25 0 01-1.07-1.92V6.75"
                        />
                    </svg>

                </div>

                <input
                    id="email"
                    type="email"
                    value="{{ $user->email }}"
                    readonly
                    aria-readonly="true"
                    autocomplete="username"
                    class="
                        block
                        w-full
                        rounded-xl
                        border
                        border-slate-200
                        bg-slate-50
                        py-2.5
                        pl-11
                        pr-11
                        text-sm
                        font-medium
                        text-slate-700
                        shadow-sm
                        outline-none
                        cursor-not-allowed
                    "
                />

                {{-- READONLY ICON --}}

                <div
                    class="
                        pointer-events-none
                        absolute
                        inset-y-0
                        right-0
                        flex
                        items-center
                        pr-3.5
                        text-slate-400
                    "
                    title="Tidak dapat diubah"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 10.5V7.75a4.5 4.5 0 00-9 0v2.75m-.75 0h10.5A1.75 1.75 0 0119 12.25v6A1.75 1.75 0 0117.25 20H6.75A1.75 1.75 0 015 18.25v-6a1.75 1.75 0 011.75-1.75z"
                        />
                    </svg>

                </div>

            </div>

            <p
                class="
                    mt-2
                    text-xs
                    text-slate-400
                "
            >
                Email akun tidak dapat diubah melalui halaman ini.
            </p>

            {{-- =================================================
                EMAIL VERIFICATION
            ================================================== --}}

            @if (
                $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                &&
                ! $user->hasVerifiedEmail()
            )

                <div
                    class="
                        mt-4
                        rounded-xl
                        border
                        border-amber-200
                        bg-amber-50
                        p-4
                    "
                >

                    <div
                        class="
                            flex
                            items-start
                            gap-3
                        "
                    >

                        {{-- WARNING ICON --}}

                        <div
                            class="
                                mt-0.5
                                flex
                                h-9
                                w-9
                                shrink-0
                                items-center
                                justify-center
                                rounded-lg
                                bg-amber-100
                                text-amber-600
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.007M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>

                        </div>

                        <div class="min-w-0">

                            <p
                                class="
                                    text-sm
                                    font-semibold
                                    text-amber-900
                                "
                            >
                                {{ __('Your email address is unverified.') }}
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-sm
                                    leading-6
                                    text-amber-800
                                "
                            >
                                Silakan verifikasi alamat email Anda untuk
                                menyelesaikan proses aktivasi akun.
                            </p>

                            {{-- RESEND VERIFICATION --}}

                            <form
                                id="send-verification"
                                method="post"
                                action="{{ route('verification.send') }}"
                                class="mt-3"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="
                                        inline-flex
                                        items-center
                                        gap-2
                                        rounded-lg
                                        bg-amber-600
                                        px-3.5
                                        py-2
                                        text-sm
                                        font-semibold
                                        text-white
                                        shadow-sm
                                        transition
                                        hover:bg-amber-700
                                        focus:outline-none
                                        focus:ring-2
                                        focus:ring-amber-500
                                        focus:ring-offset-2
                                    "
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.92l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615a2.25 2.25 0 01-1.07-1.92V6.75"
                                        />
                                    </svg>

                                    {{ __('Kirim Ulang Email Verifikasi') }}

                                </button>

                            </form>

                            {{-- VERIFICATION SUCCESS --}}

                            @if (session('status') === 'verification-link-sent')

                                <div
                                    class="
                                        mt-3
                                        flex
                                        items-start
                                        gap-2
                                        text-sm
                                        font-medium
                                        text-emerald-700
                                    "
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="mt-0.5 h-4 w-4 shrink-0"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>

                                    <span>
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            @else

                {{-- VERIFIED STATUS --}}

                <div
                    class="
                        mt-4
                        flex
                        items-center
                        gap-2
                        rounded-xl
                        border
                        border-emerald-200
                        bg-emerald-50
                        px-4
                        py-3
                        text-sm
                        font-medium
                        text-emerald-700
                    "
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                    <span>
                        Email sudah terverifikasi.
                    </span>

                </div>

            @endif

        </div>

    </div>

    {{-- =====================================================
        CARD FOOTER
    ====================================================== --}}

    <div
        class="
            border-t
            border-slate-200
            bg-slate-50/50
            px-5
            py-4
            sm:px-6
        "
    >

        <div
            class="
                flex
                items-start
                gap-3
            "
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="
                    mt-0.5
                    h-4
                    w-4
                    shrink-0
                    text-slate-400
                "
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.007M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>

            <p
                class="
                    text-xs
                    leading-5
                    text-slate-500
                "
            >
                Informasi nama dan email bersifat read-only dan
                dikelola oleh sistem. Tidak diperlukan tombol
                <span class="font-semibold text-slate-600">Save</span>
                karena tidak ada perubahan yang dapat disimpan
                dari halaman ini.
            </p>

        </div>

    </div>

</div>

</section>