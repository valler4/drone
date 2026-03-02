@if(auth()->user()->password)
    <p>You have already set a password for your account.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
@else
<x-layout>
    <x-slot:title>Add Password</x-slot:title>

    <div class="max-w-2xl mx-auto px-1 py-1">
        <header class="mb-12">
            <p class="text-slate-500 mt-2">Ensure your account is using a long, random password to stay secure.</p>
        </header>

        <form action="{{ route('password.setPassword') }}" method="post" id="passwordForm" class="space-y-8">
            @csrf
            @method('put')

            <div class="space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-xs uppercase tracking-wider">New Password</span>
                        </label>
                        <input type="password" name="new_password"
                            class="input bg-base-200 border-none focus:ring-2 ring-primary rounded-2xl font-medium w-full"
                            required />
                        @error('new_password')
                            <div class="mt-2">
                                <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-xs uppercase tracking-wider">Confirm New Password</span>
                        </label>
                        <input type="password" name="new_password_confirmation"
                            class="input bg-base-200 border-none focus:ring-2 ring-primary rounded-2xl font-medium w-full"
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
                    Add Password
                </button>
            </div>
        </form>
    </div>

</x-layout>
@endif
