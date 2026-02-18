<x-layout>
    <x-slot:title>{{ $user->name }}'s Profile</x-slot:title>

    <div class="max-w-4xl mx-auto px-6 py-12">
        <div
            class="flex flex-col md:flex-row items-center gap-8 mb-12 pb-12 border-b border-gray-200 dark:border-slate-800">
            <div class="relative">
                <img src="{{ $user->image_url }}" alt="Profile Picture"
                    class="w-32 h-32 rounded-3xl object-cover shadow-xl border-4 border-white dark:border-slate-900">
            </div>

            <div class="text-center md:text-left flex-1">
                <h1 class="text-4xl font-black text-slate-900  tracking-tighter">{{ $user->name }}</h1>
                <p class="text-primary font-bold text-lg mb-4">@ {{ $user->user_name }}</p>

                <div
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if ($user->country)
                        <span>📍 {{ $user->country }}</span>
                    @endif
                    <span>🎂 {{ $user->age ?? '??' }} years old</span>
                    <span class="capitalize">👤 {{ $user->gender }}</span>
                </div>
            </div>

            @if (auth()->id() === $user->id)
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('profile.edit') }}"
                        class="btn btn-outline border-slate-300 text-slate-700  dark:border-slate-700 rounded-2xl px-6">
                        Edit Profile
                    </a>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                <section>
                    <p class="text-xl leading-relaxed text-slate-800 italic">
                        "{{ $user->bio ?? 'This user hasn\'t shared a story yet.' }}"
                    </p>
                </section>
            </div>

            <div class="space-y-6">
                @if (auth()->id() === $user->id)
                    <div class="bg-gray-50 dark:bg-slate-950 border border-gray-200 p-6 rounded-3xl">
                        <h3 class="text-xs font-bold uppercase text-amber-50 tracking-widest text-primary mb-6">Private
                            Info</h3>

                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Balance</p>
                                <p class="text-2xl font-black text-slate-900 dark:text-white">
                                    ${{ number_format($user->balance, 2) }}</p>
                            </div>

                            <div class="pt-4 border-t border-gray-100 dark:border-slate-800">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Contact</p>
                                <p class="text-sm text-slate-700 dark:text-slate-300">{{ $user->email }}</p>
                                <p class="text-sm text-slate-700 dark:text-slate-300 mt-1">
                                    {{ $user->phone ?? 'No phone' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-6 rounded-3xl border border-gray-100 dark:border-slate-800 text-center">
                        <p class="text-xs text-slate-400 dark:text-slate-500 italic uppercase">
                            Member since {{ $user->created_at->format('M Y') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
