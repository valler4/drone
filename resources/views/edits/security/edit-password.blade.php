<x-layout>
    <x-slot:title>Update Password</x-slot:title>

    <div class="max-w-2xl mx-auto px-1 py-1">
        <header class="mb-12">
            <a href="{{ route('profile') }}"
                class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center gap-2 mb-4 hover:text-primary transition-all dark:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Back to Profile
            </a>
            <h1 class="text-4xl font-black tracking-tighter dark:text-white">Security Settings</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Ensure your account is using a long, random password to stay secure.</p>
        </header>

        <form action="{{ route('profile.updatepassword') }}" method="post" id="passwordForm" class="space-y-8">
            @csrf
            @method('put')

            <div class="space-y-6">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Current Password</span>
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">New Password</span>
                        </label>
                        <input type="password" name="new_password"
                            class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 ring-primary rounded-2xl font-medium w-full dark:text-white"
                            required />
                        @error('new_password')
                            <div class="mt-2">
                                <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Confirm New Password</span>
                        </label>
                        <input type="password" name="new_password_confirmation"
                            class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 ring-primary rounded-2xl font-medium w-full dark:text-white"
                            required />
                        @error('new_password_confirmation')
                            <div class="mt-2">
                                <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            @error('error')
                <div class="mt-4">
                    <span class="p-4 bg-error/10 text-error rounded-2xl text-xs font-bold block italic text-center">{{ $message }}</span>
                </div>
            @enderror

            <div class="pt-10 flex items-center gap-4 border-t border-base-200 dark:border-slate-800">
                <button type="submit" class="btn btn-primary px-10 rounded-2xl shadow-lg shadow-primary/20">
                    Update Password
                </button>
                <a href="{{ route('profile') }}" class="btn btn-ghost rounded-2xl px-10 dark:text-slate-300">Cancel</a>
            </div>
        </form>
    </div>

</x-layout>
