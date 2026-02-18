<x-layout>
    <x-slot:title>Update Pin Code</x-slot:title>

    <div class="max-w-2xl mx-auto px-1 py-1">
        <header class="mb-12">
            <a href="{{ route('settings') }}"
                class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center gap-2 mb-4 hover:text-primary transition-all dark:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Back to settings
            </a>
            <h1 class="text-4xl font-black tracking-tighter">Pin Security</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Your PIN code adds an extra layer of protection for sensitive actions.</p>
        </header>

        <form action="{{ route('profile.updatePinCode') }}" method="post" id="pinForm" class="space-y-10">
            @csrf
            @method('put')

            <div class="space-y-8">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Confirm Current Password</span>
                    </label>
                    <input type="password" name="password"
                        class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 ring-primary rounded-2xl font-medium w-full dark:text-white"
                        autofocus required />
                    @error('password')
                        <div class="mt-2">
                            <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">New 4-Digit PIN</span>
                    </label>
                    <input type="password" name="pin_code" maxlength="4"
                        class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 ring-primary rounded-2xl font-black text-center text-3xl tracking-[1em] w-full dark:text-white h-16"
                        placeholder="0000" required />
                    @error('pin_code')
                        <div class="mt-2">
                            <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>

            @error('error')
                <div class="mt-4">
                    <span class="p-4 bg-error/10 text-error rounded-2xl text-xs font-bold block italic text-center">{{ $message }}</span>
                </div>
            @enderror

            <div class="pt-6 flex items-center gap-4">
                <button type="submit" class="btn btn-primary px-10 rounded-2xl shadow-lg shadow-primary/20">
                    Update PIN Code
                </button>
                <a href="{{ route('settings') }}" class="btn btn-ghost rounded-2xl px-10">Cancel</a>
            </div>
        </form>
    </div>

</x-layout>
