<x-layout>
    <x-slot:title>Confirm Phone</x-slot:title>
    @php
        $user = auth()->user();
    @endphp

    <div class="max-w-md mx-auto px-1 py-1">
        <header class="mb-10 text-center md:text-left">
            <a href="{{ route('profile') }}"
                class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center justify-center md:justify-start gap-2 mb-4 hover:text-primary transition-all dark:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Back to Settings
            </a>
            <h1 class="text-4xl font-black tracking-tighter dark:text-white">Verify Phone</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">We've sent a 6-digit verification code to <strong>{{ $newphone }}</strong> via SMS.</p>
        </header>

        <form action="{{ route('update-phone') }}" method="post" id="update-form" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="form-control w-full">
                <label class="label justify-center md:justify-start">
                    <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Verification Code</span>
                </label>

                <input type="text" name="otp" maxlength="6"
                    class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 rounded-2xl text-center text-3xl font-black tracking-[0.5em] h-20 w-full dark:text-white @error('otp') ring-2 ring-error @enderror"
                    placeholder="000000" required autofocus />

                <div class="mt-4">
                    @error('otp')
                        <span class="p-4 bg-error/10 text-error rounded-2xl text-xs font-bold block italic text-center">{{ $message }}</span>
                    @enderror
                    @error('error')
                        <span class="p-4 bg-error/10 text-error rounded-2xl text-xs font-bold block italic text-center">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex flex-col gap-3">
                <button type="submit"
                    class="btn btn-success rounded-2xl h-14 text-white font-bold text-lg shadow-lg shadow-success/20 border-none">
                    Verify & Update
                </button>

                <a href="{{ route('profile') }}" class="btn btn-ghost rounded-2xl h-14 dark:text-slate-300">
                    Cancel
                </a>
            </div>
        </form>

        <div class="mt-12 flex flex-col items-center gap-4 border-t border-base-200 dark:border-slate-800 pt-8">
            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium tracking-wide">
                Didn't receive the code?
            </p>
            <form id="otp-form" action="{{ route('send-phone-otp') }}" method="post" class="m-0">
                @csrf
                <input type="tel" id="user-phone" name="phone" value="{{ $newphone }}" hidden>
                <button type="submit" id="send-otp-btn"
                    class="btn btn-ghost btn-sm text-primary font-black uppercase tracking-widest text-[10px] hover:bg-primary/5 transition-all">
                    resend Code Now
                </button>
            </form>
        </div>
    </div>

</x-layout>
