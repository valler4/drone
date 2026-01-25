<x-layout>
    <x-slot:title>Edit Profile</x-slot:title>

    <div class="w-full mx-auto px-1 py-1">

        <header class="mb-8">
            <a href="{{ route('profile') }}"
                class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center gap-2 mb-4 hover:text-primary transition-all dark:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Back to Profile
            </a>
            <h1 class="text-4xl font-black tracking-tighter dark:text-white">Edit Profile</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Update your public information and profile picture.</p>
        </header>

        <form action="{{ route('profile.update') }}" method="post" id="editForm" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('put')

            <section class="space-y-6">
                <div class="flex items-center gap-8">
                    <div class="avatar">
                        <div
                            class="w-24 h-24 rounded-full bg-base-300 shadow-2xl rotate-6 hover:rotate-0 transition-all duration-500 overflow-hidden border-2 border-primary/20 dark:border-primary/40">
                            <img src="{{ auth()->user()->image_url }}" id="preview" alt="profile image" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="space-y-3">
                        <input type="file" name="profile_image" id="file-input" class="hidden"
                            onchange="previewImage(event)" />
                        <label for="file-input" class="btn btn-sm rounded-xl px-6 capitalize font-bold">
                            Change Photo
                        </label>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold tracking-wider uppercase">JPG, PNG or GIF. Max 2MB.</p>
                        
                        @error('profile_image')
                            <div class="mt-2">
                                <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Display Name</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 ring-primary rounded-2xl font-medium dark:text-white" placeholder="Enter your name" />
                        @error('name')
                            <div class="mt-2">
                                <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Username</span>
                        </label>
                        <input type="text" name="user_name" value="{{ old('user_name', auth()->user()->user_name) }}"
                            class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 ring-primary rounded-2xl font-medium dark:text-white" placeholder="username" />
                        @error('user_name')
                            <div class="mt-2">
                                <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Age</span>
                        </label>
                        <input type="number" name="age" value="{{ old('age', auth()->user()->age) }}"
                            class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 ring-primary rounded-2xl font-medium dark:text-white" placeholder="25" />
                        @error('age')
                            <div class="mt-2">
                                <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>
            </section>

            <div class="pt-10 flex items-center gap-4">
                <button type="submit" class="btn btn-primary px-10 rounded-2xl shadow-lg shadow-primary/20">
                    Save Changes
                </button>
                <a href="{{ route('profile') }}" class="btn btn-ghost rounded-2xl px-10 dark:text-slate-300">Cancel</a>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</x-layout>
