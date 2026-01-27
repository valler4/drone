<x-layout>
    <x-slot:title>
        profile
    </x-slot:title>
    <main>
        <div class="w-full mx-auto px-1 py-1">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <a href="{{ route('home') }}"
                        class="text-sm font-bold uppercase tracking-widest text-primary flex items-center gap-2 mb-2 hover:gap-3 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                        </svg>
                        Back
                    </a>
                    <h1 class="text-4xl font-black tracking-tighter">My Profile</h1>
                </div>

                <div
                    class="w-24 h-24 rounded-full bg-base-300 shadow-2xl rotate-6 hover:rotate-0 transition-all duration-500 overflow-hidden border-2 border-primary/20">
                    <img src="{{ auth()->user()->image_url }}" alt="profile image" class="w-full h-full object-cover">
                </div>
            </div>

        @if (session('success'))
            <div id="toast-success"
                class="alert alert-success rounded-2xl mb-8 shadow-lg shadow-success/10 border-none bg-success/10 text-success font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

                <div class="space-y-8">
                    <h2
                        class="text-lg font-bold text-primary/50 uppercase tracking-widest border-b border-base-300 pb-2">
                        Account Details</h2>

                    <div class="info-group">
                        <label class="block text-xs font-bold text-slate-400 uppercase">Deisplay Name</label>
                        <p class="text-xl font-medium text-slate-800">{{ auth()->user()->name }}</p>
                    </div>

                    <div class="info-group">
                        <label class="block text-xs font-bold text-slate-400 uppercase">Username</label>
                        <p class="text-xl font-medium text-slate-800">{{ auth()->user()->user_name }}</p>
                    </div>

                    <div class="info-group">
                        <label class="block text-xs font-bold text-slate-400 uppercase">age</label>
                        <p class="text-xl font-medium text-slate-800">{{ auth()->user()->age ?? 'not set' }}</p>
                    </div>

                    <div class="info-group">
                        <label class="block text-xs font-bold text-slate-400 uppercase">id</label>
                        <p class="text-xl font-medium text-slate-800">{{ auth()->user()->id }}</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <h2
                        class="text-lg font-bold text-primary/50 uppercase tracking-widest border-b border-base-300 pb-2">
                        Contact & Security</h2>

                    <div class="flex justify-start gap-10 items-center group">
                        <div class="info-group">
                            <label class="block text-xs font-bold text-slate-400 uppercase">Email Address</label>
                            <p class="text-xl font-medium text-slate-800">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('edit-email') }}"
                            class="btn btn-ghost btn-xs text-primary underline opacity-0 group-hover:opacity-100 transition">edit</a>
                    </div>

                    <div class="flex justify-start gap-10 items-center group">
                        <div class="info-group">
                            <label class="block text-xs font-bold text-slate-400 uppercase">Phone</label>
                            <p class="text-xl font-medium text-slate-800">{{ auth()->user()->phone ?? 'Not set' }}</p>
                        </div>
                        <a href="{{ route('edit-phone') }}"
                            class="btn btn-ghost btn-xs text-primary underline opacity-0 group-hover:opacity-100 transition">edit</a>
                    </div>

                    <div class="flex justify-start gap-10 items-center group">
                        <div class="info-group">
                            <label class="block text-xs font-bold text-slate-400 uppercase">password</label>
                            <p class="text-xl font-medium text-slate-800">••••••••</p>
                        </div>
                        <a href="{{ route('edit.password') }}"
                            class="btn btn-ghost btn-xs text-primary underline opacity-0 group-hover:opacity-100 transition">edit</a>
                    </div>

                    <div class="flex justify-start gap-10 items-center group">
                        <div class="info-group">
                            <label class="block text-xs font-bold text-slate-400 uppercase">pin code</label>
                            <p class="text-xl font-medium text-slate-800">••••</p>
                        </div>
                        <a href="{{ route('edit.pin-code') }}"
                            class="btn btn-ghost btn-xs text-primary underline opacity-0 group-hover:opacity-100 transition">edit</a>
                    </div>

                    <a href="#confirm-popup" class="open-btn delete-button">Delete Account</a>

                    <div id="confirm-popup" class="modal-overlay">
                        <div class="modal-content">
                            <h3>Are you sure?</h3>
                            <p>Please enter your password to confirm.</p>

                            <form action="{{ route('delete-account') }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="password" name="password" class="password-input"
                                    placeholder="Enter Password" required autofocus>

                                <div class="flex flex-col gap-2">
                                    <button type="submit"
                                        class="btn btn-error rounded-2xl text-white shadow-lg shadow-error/20">confirm & delete</button>
                                    <a href="#" class="btn btn-ghost rounded-2xl dark:text-slate-300">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    @error('password')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-16 pt-8 border-t border-base-300 flex flex-col md:flex-row gap-4">
                <a href="{{ route('edit.profile') }}"
                    class="btn btn-primary btn-lg grow rounded-2xl shadow-lg shadow-primary/20">Edit Profile</a>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/main.js') }}"></script>
</x-layout>
