<x-layout>
    <x-slot:title>لوحة التحكم - Admin</x-slot:title>

    <div class="space-y-8 p-2 md:p-0">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="card bg-base-100 shadow-xl border border-base-200 dark:border-white/5">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-base-content/60 uppercase">Total Users</p>
                            <h3 class="text-3xl font-black mt-1">{{ number_format($totalUsers) }}</h3>
                        </div>
                        <div class="bg-primary/10 p-3 rounded-2xl text-2xl">👥</div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl border border-base-200 dark:border-white/5">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-base-content/60 uppercase">Total Deposits</p>
                            <h3 class="text-3xl font-black mt-1 text-success">${{ number_format($totalDeposits, 2) }}</h3>
                        </div>
                        <div class="bg-success/10 p-3 rounded-2xl text-2xl">💰</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-base-100 rounded-[2rem] border border-base-200 dark:border-white/5 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-base-200 dark:border-white/5 flex justify-between items-center bg-base-200/30">
                <h2 class="text-lg font-black uppercase tracking-widest">Recent Transactions</h2>
                <a href="#" class="btn btn-sm btn-ghost rounded-xl">View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="text-base-content/50 uppercase text-xs border-b border-base-200 dark:border-white/5">
                            <th>Transaction ID</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($recentTransactions as $transaction)
                            <tr class="hover:bg-base-200/50 transition-colors border-b border-base-200 dark:border-white/5">
                                <td class="font-mono opacity-60 text-xs">{{ $transaction->payment_id }}</td>
                                <td>
                                    <div class="font-bold">{{ $transaction->user->name ?? 'Unknown' }}</div>
                                    <div class="text-[10px] opacity-50">{{ $transaction->created_at->format('Y-m-d H:i') }}</div>
                                </td>
                                <td class="font-black text-success">+${{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    <span class="badge badge-sm font-bold uppercase tracking-tighter">{{ $transaction->method }}</span>
                                </td>
                                <td>
                                    <div @class([
                                        'badge badge-sm font-bold',
                                        'badge-success' => $transaction->status === 'COMPLETED',
                                        'badge-warning' => $transaction->status === 'PENDING',
                                        'badge-error' => $transaction->status === 'FAILED',
                                    ])>
                                        {{ $transaction->status }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-20 opacity-40 italic">No recent activity detected.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>0
</x-layout>
