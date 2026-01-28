<x-layout>
    <x-slot:title>My Tickets</x-slot:title>

    <div class="w-full mx-auto px-1 py-1">
        <header class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('home') }}"
                    class="text-xs font-bold uppercase tracking-widest text-primary/60 flex items-center gap-2 mb-4 hover:text-primary transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg>
                    Back to Dashboard
                </a>
                <h1 class="text-4xl font-black tracking-tighter">Support Tickets</h1>
            </div>
            <dev>
                <a href="{{ route('tickets.create') }}"
                    class="btn btn-primary rounded-2xl shadow-lg shadow-primary/20 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    Create New Ticket
                </a>
            </dev>
        </header>
        <div class="bg-base-100 p-6 rounded-3xl shadow-sm transition-all group">
            <div class="stat-title text-xs uppercase font-bold text-slate-400">Total tickets</div>
            <div class="stat-value text-2xl uppercase font-bold text-slate-400">{{ $tickets->total() }}</div>
        </div>
        <br>

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

        @if (session('error'))
            <div id="toast-error"
                class="alert alert-error rounded-2xl mb-8 shadow-lg shadow-error/10 border-none bg-error/10 text-error font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="space-y-4">
            @forelse ($tickets as $ticket)
                <div
                    class="bg-base-100 p-6 rounded-3xl shadow-sm border border-base-300 hover:border-primary/30 transition-all group">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center gap-3">
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-lg bg-base-200 text-slate-500">
                                    #{{ $ticket->id }}
                                </span>
                                <span @class([
                                    'text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-lg',
                                    'bg-success/10 text-success' => $ticket->status === 'open',
                                    'bg-slate-100 text-slate-400' => $ticket->status !== 'open',
                                ])>
                                    {{ $ticket->status }}
                                </span>
                            </div>
                            <h3
                                class="text-xl font-bold tracking-tight text-slate-800 dark:text-white group-hover:text-primary transition-colors">
                                <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->title }}</a>
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1">{{ $ticket->subject }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('tickets.show', $ticket) }}"
                                class="btn btn-ghost btn-sm rounded-xl dark:text-white">View</a>

                            @if ($ticket->status == 'open')
                                <a href="{{ route('tickets.edit', $ticket) }}"
                                    class="btn btn-ghost btn-sm rounded-xl text-primary dark:text-white">Edit</a>
                                <a href="#confirm-close-{{ $ticket->id }}"
                                    class="btn btn-ghost text-error font-bold btn-sm text-sm uppercase rounded-xl tracking-widest hover:bg-error/10"
                                    >Close</a>

                                <div id="confirm-close-{{ $ticket->id }}" class="modal-overlay">
                                    <div class="modal-content rounded-3xl p-8 max-w-sm dark:bg-slate-900">
                                        <h3 class="text-2xl font-black tracking-tighter mb-2 dark:text-white">Close
                                            Ticket?</h3>
                                        <p class="text-slate-500 dark:text-slate-400 mb-6 text-sm">Are you sure you want
                                            to close this ticket? This action cannot be undone.</p>

                                        <form action="{{ route('tickets.close', $ticket) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <div class="flex flex-col gap-2">
                                                <button type="submit"
                                                    class="btn btn-error rounded-2xl text-white shadow-lg shadow-error/20">Yes,
                                                    Close Ticket</button>
                                                <a href="#"
                                                    class="btn btn-ghost rounded-2xl dark:text-slate-300">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="text-center py-20 bg-base-200 dark:bg-slate-800/50 rounded-3xl border-2 border-dashed border-base-300 dark:border-slate-700">
                    <div
                        class="bg-base-100 dark:bg-slate-900 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-base-300/50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="text-slate-300 dark:text-slate-600" viewBox="0 0 16 16">
                            <path
                                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 0v2h7V2h-7zM4.5 5v2h7V5h-7zM4.5 8v2h7V8h-7zM4.5 11v2h7v-2h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">No tickets found</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6">You haven't submitted any support tickets yet.
                    </p>
                    <a href="{{ route('tickets.create') }}"
                        class="btn btn-primary rounded-2xl px-8 shadow-lg shadow-primary/20">Create Your First
                        Ticket</a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $tickets->links() }}
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</x-layout>
