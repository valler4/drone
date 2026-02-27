<x-layout>
    <x-slot:title>Update Email</x-slot:title>

    <div class="max-w-xl mx-auto px-1 py-1">
        <header class="mb-10">
            <a href="{{ route('settings') }}"
                class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center gap-2 mb-4 hover:text-primary transition-all dark:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Back to Settings
            </a>
            <h1 class="text-4xl font-black tracking-tighter">Update Email</h1>
            <p class="text-sm mt-1">We'll send a verification code to your new email address.</p>
        </header>

        <form id="otp-form" action="{{ route('send-email-otp') }}" method="post" class="space-y-8">
            @csrf
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-bold text-xs uppercase tracking-wider">New Email Address</span>
                </label>

                <div class="flex flex-col md:flex-row items-stretch gap-3">
                    <input type="email" id="user-email" name="email" value="{{ old('email') }}"
                        class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 rounded-2xl font-medium flex-1 dark:text-white @error('email') ring-2 ring-error @enderror"
                        placeholder="name@example.com" required>

                    <button type="submit" id="send-otp-btn"
                        class="btn btn-primary rounded-2xl px-8 shadow-lg shadow-primary/20">
                        send Code
                    </button>
                </div>

                <div class="mt-4 space-y-1">
                    @error('email')
                        <span class="p-4 bg-error/10 text-error rounded-2xl text-xs font-bold block italic">{{ $message }}</span>
                    @enderror
                    @error('otp')
                        <span class="p-4 bg-error/10 text-error rounded-2xl text-xs font-bold block italic">{{ $message }}</span>
                    @enderror
                    @error('error')
                        <span class="p-4 bg-error/10 text-error rounded-2xl text-xs font-bold block italic">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </form>

        <div class="mt-12 p-6 bg-primary/5 dark:bg-primary/10 rounded-3xl border border-primary/10 dark:border-primary/20">
            <div class="flex gap-4">
                <div class="text-primary text-xl">💡</div>
                <p class="text-xs leading-relaxed">
                    <span class="font-bold text-primary uppercase tracking-widest text-[10px]">Important:</span> Changing your email will require re-verification. You won't be able to log in with your old email after this process is complete.
                </p>
            </div>
        </div>
    </div>

</x-layout>
