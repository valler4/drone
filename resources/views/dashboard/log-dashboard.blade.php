<x-dashboard-layout>
    <x-slot:title>Dashboard</x-slot:title>

    @forelse ($userLogs as $log)
        <div class="log-entry">
            <p>{{ $log->user_id ?? 'no user id' }}</p>
            <p>{{ $log->action ?? 'no action'  }}</p>
            <p>{{ $log->description ??'no description' }}</p>
            <p>{{ $log->ip_address ?? 'no ip address'  }}</p>
            <p>{{ $log->created_at ?? 'no created at'  }}</p>
            <br>
        </div>
    @empty
        <p>No logs available.</p>
    @endforelse


    <script src="{{ asset('js/main.js') }}"></script>
</x-dashboard-layout>
