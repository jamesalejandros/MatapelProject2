<section class="space-y-6">
{{-- =========================================================
    DELETE ACCOUNT CARD
========================================================== --}}

<div
    class="
        overflow-hidden
        rounded-2xl
        border
        border-red-200
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
            border-red-100
            bg-red-50/60
            px-5
            py-4
            sm:px-6
        "
    >

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
                    bg-red-100
                    text-red-600
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
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.576 0a48.11 48.11 0 013.478-.397m7.5 0V4.5c0-.621-.504-1.125-1.125-1.125h-3.75c-.621 0-1.125.504-1.125 1.125v.893m7.5 0a48.667 48.667 0 00-7.5 0"
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
                    {{ __('Delete Account') }}
                </h2>

                <p
                    class="
                        mt-1
                        text-sm
                        leading-6
                        text-slate-500
                    "
                >
                    {{ __('Hapus akun dan seluruh data yang terkait dengan akun Anda.') }}
                </p>

            </div>

        </div>

    </div>

    {{-- =====================================================
        CARD CONTENT
    ====================================================== --}}

    <div class="p-5 sm:p-6">

        {{-- WARNING --}}

        <div
            class="
                flex
                items-start
                gap-3
                rounded-xl
                border
                border-amber-200
                bg-amber-50
                p-4
            "
        >

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
                    bg-amber-100
                    text-amber-600
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
                    Perhatian
                </p>

                <p
                    class="
                        mt-1
                        text-sm
                        leading-6
                        text-amber-800
                    "
                >
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>

            </div>

        </div>

        {{-- =================================================
            DELETE BUTTON
        ================================================== --}}

        <div class="mt-5">

            <button
                type="button"
                x-data
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    rounded-xl
                    bg-red-600
                    px-4
                    py-2.5
                    text-sm
                    font-semibold
                    text-white
                    shadow-sm
                    transition
                    hover:bg-red-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-red-500
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
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.576 0a48.11 48.11 0 013.478-.397m7.5 0V4.5c0-.621-.504-1.125-1.125-1.125h-3.75c-.621 0-1.125.504-1.125 1.125v.893m7.5 0a48.667 48.667 0 00-7.5 0"
                    />
                </svg>

                {{ __('Delete Account') }}

            </button>

        </div>

    </div>

    {{-- =====================================================
        CARD FOOTER
    ====================================================== --}}

    <div
        class="
            border-t
            border-red-100
            bg-red-50/30
            px-5
            py-4
            sm:px-6
        "
    >

        <div class="flex items-start gap-2">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="
                    mt-0.5
                    h-4
                    w-4
                    shrink-0
                    text-red-400
                "
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

            <p
                class="
                    text-xs
                    leading-5
                    text-red-700
                "
            >
                Penghapusan akun bersifat permanen dan tidak dapat
                dibatalkan setelah berhasil diproses.
            </p>

        </div>

    </div>

</div>

{{-- =========================================================
    DELETE CONFIRMATION MODAL
========================================================== --}}

<x-modal
    name="confirm-user-deletion"
    :show="$errors->userDeletion->isNotEmpty()"
    focusable
>

    <form
        method="post"
        action="{{ route('profile.destroy') }}"
        class="p-5 sm:p-6"
    >

        @csrf
        @method('delete')

        {{-- =================================================
            MODAL HEADER
        ================================================== --}}

        <div class="flex items-start gap-3">

            <div
                class="
                    flex
                    h-10
                    w-10
                    shrink-0
                    items-center
                    justify-center
                    rounded-xl
                    bg-red-100
                    text-red-600
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

                <h2
                    class="
                        text-lg
                        font-semibold
                        text-slate-900
                    "
                >
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p
                    class="
                        mt-1
                        text-sm
                        leading-6
                        text-slate-500
                    "
                >
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

            </div>

        </div>

        {{-- =================================================
            PASSWORD
        ================================================== --}}

        <div class="mt-6">

            <x-input-label
                for="password"
                value="{{ __('Password') }}"
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
                            d="M16.5 10.5V7.75a4.5 4.5 0 00-9 0v2.75m-.75 0h10.5A1.75 1.75 0 0119 12.25v6A1.75 1.75 0 0117.25 20H6.75A1.75 1.75 0 015 18.25v-6a1.75 1.75 0 011.75-1.75z"
                        />
                    </svg>

                </div>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="
                        block
                        w-full
                        rounded-xl
                        border
                        border-slate-200
                        bg-white
                        py-2.5
                        pl-11
                        pr-4
                        text-sm
                        text-slate-700
                        shadow-sm
                        outline-none
                        transition
                        placeholder:text-slate-400
                        focus:border-red-500
                        focus:ring-2
                        focus:ring-red-500/20
                    "
                    placeholder="{{ __('Password') }}"
                    autocomplete="current-password"
                />

            </div>

            <x-input-error
                :messages="$errors->userDeletion->get('password')"
                class="mt-2"
            />

        </div>

        {{-- =================================================
            MODAL ACTIONS
        ================================================== --}}

        <div
            class="
                mt-6
                flex
                flex-col-reverse
                gap-2
                sm:flex-row
                sm:justify-end
            "
        >

            {{-- CANCEL --}}

            <button
                type="button"
                x-on:click="$dispatch('close')"
                class="
                    inline-flex
                    items-center
                    justify-center
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    px-4
                    py-2.5
                    text-sm
                    font-semibold
                    text-slate-700
                    shadow-sm
                    transition
                    hover:bg-slate-50
                    focus:outline-none
                    focus:ring-2
                    focus:ring-slate-400
                    focus:ring-offset-2
                "
            >
                {{ __('Cancel') }}
            </button>

            {{-- DELETE --}}

            <button
                type="submit"
                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    rounded-xl
                    bg-red-600
                    px-4
                    py-2.5
                    text-sm
                    font-semibold
                    text-white
                    shadow-sm
                    transition
                    hover:bg-red-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-red-500
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
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.576 0a48.11 48.11 0 013.478-.397m7.5 0V4.5c0-.621-.504-1.125-1.125-1.125h-3.75c-.621 0-1.125.504-1.125 1.125v.893m7.5 0a48.667 48.667 0 00-7.5 0"
                    />
                </svg>

                {{ __('Delete Account') }}

            </button>

        </div>

    </form>

</x-modal>

</section>