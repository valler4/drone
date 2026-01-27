<x-layout>
    <x-slot:title>Create Ticket</x-slot:title>

    <div class="w-full mx-auto px-1 py-1">
        <header class="mb-8">
            <a href="{{ route('tickets.index') }}"
                class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center gap-2 mb-4 hover:text-primary transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Back to Tickets
            </a>
            <h1 class="text-4xl font-black tracking-tighter dark:text-white">Create New Ticket</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Submit a new support ticket and we'll get back to you as soon as possible.</p>
        </header>

        <form action="{{ route('tickets.store') }}" method="post" class="space-y-6">
            @csrf

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Ticket Title</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="What is this about?"
                    class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 rounded-2xl ring-primary font-medium w-full dark:text-white @error('title') ring-2 ring-error @enderror" required autofocus>
                @error('title')
                    <div class="mt-2">
                        <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Description / Subject</span>
                </label>
                <textarea name="subject" rows="6" placeholder="Please describe your issue in detail..."
                    class="textarea bg-base-200 dark:bg-slate-900 border-none focus:ring-2 rounded-2xl ring-primary font-medium w-full dark:text-white @error('subject') ring-2 ring-error @enderror" required>{{ old('subject') }}</textarea>
                @error('subject')
                    <div class="mt-2">
                        <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="pt-6 flex items-center gap-4">
                <button type="submit" class="btn btn-primary px-10 rounded-2xl shadow-lg shadow-primary/20">
                    Send Ticket
                </button>
                <a href="{{ route('tickets.index') }}" class="btn btn-ghost rounded-2xl px-10 dark:text-slate-300">Cancel</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</x-layout>
