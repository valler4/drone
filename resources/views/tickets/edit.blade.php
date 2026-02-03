<x-layout>
    <x-slot:title>Edit Ticket: {{ Str::limit($ticket->title, 30) }}</x-slot:title>

    <div class="w-full mx-auto px-1 py-1">
        <header class="mb-8">
            <a href="{{ route('tickets.show', $ticket) }}"
                class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center gap-2 mb-4 hover:text-primary transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Back to Ticket
            </a>
            <h1 class="text-4xl font-black tracking-tighter dark:text-white">Edit Ticket</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Update the details of your support ticket #{{ $ticket->id }}.</p>
        </header>

        <form action="{{ route('tickets.update', $ticket->id) }}" method="post" class="space-y-6">
            @csrf
            @method('put')

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Ticket Title</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $ticket->title) }}" placeholder="What is this about?"
                    class="input bg-base-200 dark:bg-slate-900 border-none focus:ring-2 rounded-2xl font-medium w-full dark:text-white @error('title') ring-2 ring-error @enderror" required autofocus>
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
                    class="textarea bg-base-200 dark:bg-slate-900 border-none focus:ring-2 rounded-2xl font-medium w-full min-h-37.5 dark:text-white @error('subject') ring-2 ring-error @enderror" required>{{ old('subject', $ticket->subject) }}</textarea>
                @error('subject')
                    <div class="mt-2">
                        <span class="p-2 bg-error/10 text-error rounded-xl text-xs font-bold block italic">{{ $message }}</span>
                    </div>
                @enderror
            </div>
            @if ($ticket->status === 'open')
            <div class="pt-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <button type="submit" class="btn btn-primary px-10 rounded-2xl shadow-lg shadow-primary/20">
                        Update Ticket
                    </button>
                    <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-ghost rounded-2xl px-10 dark:text-slate-300">Cancel</a>
                </div>

                <a href="#confirm-delete" class="btn btn-ghost text-error font-bold btn-sm text-sm uppercase rounded-xl tracking-widest hover:bg-error/10">close Ticket</a>
            </div>
        </form>

        <div id="confirm-delete" class="modal-overlay">
            <div class="modal-content rounded-3xl p-8 max-w-sm text-center dark:bg-slate-900">
                <div class="bg-error/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="text-error" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black tracking-tighter mb-2 text-slate-800 dark:text-white">close Ticket?</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-8 text-sm">Are you sure you want to close this ticket?</p>

                <form action="{{ route('tickets.close', $ticket->id) }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="btn btn-error rounded-2xl text-white shadow-lg shadow-error/20">Yes, Close Ticket</button>
                        <a href="#" class="btn btn-ghost rounded-2xl dark:text-slate-300">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        @else
            <div class="mt-6">
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">This ticket is closed and cannot be edited.</span>
            </div>
        @endif
    </div>


</x-layout>
