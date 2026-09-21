<section class="space-y-6">
{{-- =========================================================
    UPDATE PASSWORD CARD
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
                        d="M16.5 10.5V7.75a4.5 4.5 0 00-9 0v2.75m-.75 0h10.5A1.75 1.75 0 0119 12.25v6A1.75 1.75 0 0117.25 20H6.75A1.75 1.75 0 015 18.25v-6a1.75 1.75 0 011.75-1.75z"
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
                    {{ __('Update Password') }}
                </h2>

                <p
                    class="
                        mt-1
                        text-sm
                        leading-6
                        text-slate-500
                    "
                >
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>

            </div>

        </div>

    </div>

    {{-- =====================================================
        PASSWORD FORM
    ====================================================== --}}

    <form
        method="post"
        action="{{ route('password.update') }}"
    >

        @csrf
        @method('put')

        <div
            class="
                space-y-6
                p-5
                sm:p-6
            "
        >

            {{-- =================================================
                CURRENT PASSWORD
            ================================================== --}}

            <div>

                <x-input-label
                    for="update_password_current_password"
                    :value="__('Current Password')"
                    class="text-sm font-medium text-slate-700"
                />

                <div class="relative mt-2">

                    {{-- LOCK ICON --}}

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

                    <x-text-input
                        id="update_password_current_password"
                        name="current_password"
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
                            focus:border-blue-500
                            focus:ring-2
                            focus:ring-blue-500/20
                        "
                        autocomplete="current-password"
                        placeholder="{{ __('Current Password') }}"
                    />

                </div>

                <x-input-error
                    :messages="$errors->updatePassword->get('current_password')"
                    class="mt-2"
                />

            </div>

            {{-- =================================================
                NEW PASSWORD
            ================================================== --}}

            <div>

                <x-input-label
                    for="update_password_password"
                    :value="__('New Password')"
                    class="text-sm font-medium text-slate-700"
                />

                <div class="relative mt-2">

                    {{-- KEY ICON --}}

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
                                d="M15.75 5.25a3 3 0 11-5.659 1.397L5.25 11.488V15h3v3h3v-3h2.512l4.841-4.841A3 3 0 0015.75 5.25z"
                            />
                        </svg>

                    </div>

                    <x-text-input
                        id="update_password_password"
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
                            focus:border-blue-500
                            focus:ring-2
                            focus:ring-blue-500/20
                        "
                        autocomplete="new-password"
                        placeholder="{{ __('New Password') }}"
                    />

                </div>

                <x-input-error
                    :messages="$errors->updatePassword->get('password')"
                    class="mt-2"
                />

            </div>

            {{-- =================================================
                CONFIRM PASSWORD
            ================================================== --}}

            <div>

                <x-input-label
                    for="update_password_password_confirmation"
                    :value="__('Confirm Password')"
                    class="text-sm font-medium text-slate-700"
                />

                <div class="relative mt-2">

                    {{-- CHECK ICON --}}

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
                                d="M9 12.75L11.25 15 15 9.75"
                            />
                        </svg>

                    </div>

                    <x-text-input
                        id="update_password_password_confirmation"
                        name="password_confirmation"
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
                            focus:border-blue-500
                            focus:ring-2
                            focus:ring-blue-500/20
                        "
                        autocomplete="new-password"
                        placeholder="{{ __('Confirm Password') }}"
                    />

                </div>

                <x-input-error
                    :messages="$errors->updatePassword->get('password_confirmation')"
                    class="mt-2"
                />

            </div>

        </div>

        {{-- =====================================================
            FORM FOOTER
        ====================================================== --}}

        <div
            class="
                flex
                flex-col
                gap-3
                border-t
                border-slate-200
                bg-slate-50/50
                px-5
                py-4
                sm:flex-row
                sm:items-center
                sm:px-6
            "
        >

            {{-- SAVE BUTTON --}}

            <button
                type="submit"
                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    rounded-xl
                    bg-blue-600
                    px-4
                    py-2.5
                    text-sm
                    font-semibold
                    text-white
                    shadow-sm
                    transition
                    hover:bg-blue-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-blue-500
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
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                {{ __('Update Password') }}

            </button>

            {{-- SUCCESS MESSAGE --}}

            @if (session('status') === 'password-updated')

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="
                        flex
                        items-center
                        gap-2
                        text-sm
                        font-medium
                        text-emerald-600
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
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                    {{ __('Password updated successfully.') }}

                </p>

            @endif

        </div>

    </form>

</div>

</section>