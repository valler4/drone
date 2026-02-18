<x-layout>
    <x-slot:title>Ticket: {{ Str::limit($ticket->title, 30) }}</x-slot:title>

    <div class="w-full mx-auto px-1 py-1">
        <header class="mb-8">
            <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('tickets.index') }}"
                        class="flex items-center text-sm font-bold hover:opacity-70 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
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

            <h1 class="text-4xl font-black tracking-tighter">{{ $ticket->title }}</h1>
            <p class="text-slate-500 mt-2">Submitted on {{ $ticket->created_at->format('M d, Y \a\t H:i') }}</p>
        </header>

        <div class="bg-base-100 rounded-3xl border border-base-300 overflow-hidden shadow-sm">
            <div class="p-8 space-y-6">
                <div class="space-y-2">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Description</h2>
                    <div class="text-slate-800 leading-relaxed whitespace-pre-wrap text-lg">
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


</x-layout>
