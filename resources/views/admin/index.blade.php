<x-layout>
    <x-slot:title>لوحة التحكم - Admin Dashboard</x-slot:title>

    <div class="space-y-8 p-4 md:p-6 bg-base-200/50 min-h-screen">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-base-content">الإحصائيات العامة</h1>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-sm btn-outline">تصدير التقارير 📤</button>
                <button class="btn btn-sm btn-primary">تحديث البيانات 🔄</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">

            <a href="{{ route('admin.users.index') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-all hover:border-blue-500 cursor-pointer group">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-blue-500 uppercase tracking-wider">Total Users</p>
                            <h3 class="text-3xl font-black mt-1 group-hover:scale-105 transition-transform origin-left">{{ number_format($totalUsers) }}</h3>
                        </div>
                        <div class="bg-blue-500/10 p-4 rounded-2xl text-3xl group-hover:bg-blue-500/20 transition-colors">👥</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.deposits.index') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-all hover:border-green-500 cursor-pointer group">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-green-500 uppercase tracking-wider">Total Deposits</p>
                            <h3 class="text-3xl font-black mt-1 group-hover:scale-105 transition-transform origin-left">${{ number_format($totalDeposits, 2) }}</h3>
                        </div>
                        <div class="bg-green-500/10 p-4 rounded-2xl text-3xl group-hover:bg-green-500/20 transition-colors">💰</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.transactions.index') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-all hover:border-indigo-500 cursor-pointer group">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider">Transactions</p>
                            <h3 class="text-3xl font-black mt-1 group-hover:scale-105 transition-transform origin-left">{{ number_format($totalTransactions) }}</h3>
                        </div>
                        <div class="bg-indigo-500/10 p-4 rounded-2xl text-3xl group-hover:bg-indigo-500/20 transition-colors">🔄</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.purchases.index') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-all hover:border-emerald-500 cursor-pointer group">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Total Purchases</p>
                            <h3 class="text-3xl font-black mt-1 group-hover:scale-105 transition-transform origin-left">{{ number_format($totalPurchases) }}</h3>
                        </div>
                        <div class="bg-emerald-500/10 p-4 rounded-2xl text-3xl group-hover:bg-emerald-500/20 transition-colors">📦</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.tickets.index') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-all hover:border-orange-500 cursor-pointer group">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-orange-500 uppercase tracking-wider">Support Tickets</p>
                            <h3 class="text-3xl font-black mt-1 group-hover:scale-105 transition-transform origin-left">{{ number_format($totalTickets) }}</h3>
                        </div>
                        <div class="bg-orange-500/10 p-4 rounded-2xl text-3xl group-hover:bg-orange-500/20 transition-colors">🎫</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.products.index') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-all hover:border-purple-500 cursor-pointer group">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-purple-500 uppercase tracking-wider">Active Products</p>
                            <h3 class="text-3xl font-black mt-1 group-hover:scale-105 transition-transform origin-left">{{ number_format($totalProducts) }}</h3>
                        </div>
                        <div class="bg-purple-500/10 p-4 rounded-2xl text-3xl group-hover:bg-purple-500/20 transition-colors">✨</div>
                    </div>
                </div>
            </a>
        </div>

    </div>
</x-layout>
