<x-layout>
    <x-slot:title>Ticket: {{ Str::limit($ticket->title, 30) }}</x-slot:title>

    <div class="w-full mx-auto px-1 py-1">
        <header class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('tickets.index') }}"
                    class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center gap-2 hover:text-primary transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg>
                    Back to Tickets
                </a>

                <div class="flex items-center gap-2">
                    <span @class([
                        'text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full',
                        'bg-success/10 text-success' => $ticket->status === 'open',
                        'bg-slate-100 text-slate-400' => $ticket->status !== 'open',
                    ])>
                        {{ $ticket->status }}
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full bg-base-200 text-slate-500">
                        #{{ $ticket->id }}
                    </span>
                </div>
            </div>

            <h1 class="text-4xl font-black tracking-tighter dark:text-white">{{ $ticket->title }}</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Submitted on {{ $ticket->created_at->format('M d, Y \a\t H:i') }}</p>
        </header>

        <div class="bg-base-100 dark:bg-slate-900 rounded-3xl border border-base-300 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="p-8 space-y-6">
                <div class="space-y-2">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Description</h2>
                    <div class="text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-wrap text-lg">
                        {{ $ticket->subject }}
                    </div>
                </div>

                <div class="pt-8 border-t border-base-200 dark:border-slate-800 flex flex-wrap items-center gap-4">
                    @if ($ticket->status === 'open')
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-primary px-8 rounded-2xl shadow-lg shadow-primary/20">
                        Edit Ticket
                    </a>

                        <a href="#confirm-close-{{ $ticket->id }}" class="btn btn-ghost text-error font-bold btn-sm text-sm uppercase rounded-xl tracking-widest hover:bg-error/10">
                            Close Ticket
                        </a>

                        <div id="confirm-close-{{ $ticket->id }}" class="modal-overlay">
                            <div class="modal-content rounded-3xl p-8 max-w-sm dark:bg-slate-900">
                                <h3 class="text-2xl font-black tracking-tighter mb-2 dark:text-white">Close Ticket?</h3>
                                <p class="text-slate-500 dark:text-slate-400 mb-6 text-sm">Are you sure you want to close this ticket? This action cannot be undone.</p>

                                <form action="{{ route('tickets.close', $ticket) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="flex flex-col gap-2">
                                        <button type="submit" class="btn btn-error rounded-2xl text-white shadow-lg shadow-error/20">Yes, Close Ticket</button>
                                        <a href="#" class="btn btn-ghost rounded-2xl dark:text-slate-300">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @error('error')
            <div class="mt-4">
                <span class="p-4 bg-error/10 text-error rounded-2xl text-xs font-bold block">{{ $message }}</span>
            </div>
        @enderror
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</x-layout>
