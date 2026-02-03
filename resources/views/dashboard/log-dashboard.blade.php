<x-dashboard-layout>
    <x-slot:title>Activity Logs</x-slot:title>

    <div class="p-6 bg-[#f8fafc] dark:bg-[#0e0d0d] min-h-screen rounded-3xl transition-all duration-300">
        <div class="max-w-6xl mx-auto">

            <div class="mb-8 border-b border-slate-200 dark:border-slate-800 pb-5">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Activity History</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Review your recent account actions and security
                    events.</p>
            </div>
            <div class="flex gap-2">
                <div
                    class="stat bg-white dark:bg-[#000000] border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-sm">
                    <div class="stat-title text-xs uppercase font-bold text-slate-400">Total Events</div>
                    <div class="stat-value text-2xl uppercase font-bold text-slate-400">{{ $userLogs->total() }}</div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-[#000000] shadow-sm dark:shadow-none rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table w-full border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 uppercase text-[11px] tracking-widest border-b border-slate-200 dark:border-slate-800">
                                <th class="py-4 px-6 font-semibold">Activity</th>
                                <th class="py-4 px-6 font-semibold">description</th>
                                <th class="py-4 px-6 font-semibold text-left">IP</th>
                                <th class="py-4 px-6 font-semibold text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($userLogs as $log)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-2 h-2 rounded-full {{ $log->action == 'login' ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]' : 'bg-blue-500' }}">
                                            </div>
                                            <span
                                                class="font-bold text-slate-700 dark:text-slate-200 capitalize text-sm">{{ $log->action }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                            <span
                                                class="text-sm text-slate-600 dark:text-slate-300">{{ $log->description }}</span>
                                    </td>

                                    <td class="px-6 py-4 text-left">
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 font-mono">
                                            {{ $log->ip_address }}</span>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <span class="text-xs text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                            {{ $log->created_at->format('M d, Y • H:i') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="py-12 text-center text-slate-400 dark:text-slate-600 italic">No
                                        activities recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-md p-1">
                    {{ $userLogs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
