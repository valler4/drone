<x-layout>
    <x-slot:title>الإشعارات</x-slot:title>
    <div class="notifications-container" style="max-width: 400px; margin: 20px auto; font-family: sans-serif;">
        <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="margin: 0;">الإشعارات 🔔</h3>
            @if($unread->count() > 0)
                <span class="badge" style="background: #ff4d4d; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;">
                    {{ $unread->count() }} جديد
                </span>
            @endif
        </div>

        @forelse ($unread as $notification)
            <div class="notification-item" style="background: #f9f9f9; border-left: 4px solid #4CAF50; padding: 15px; margin-bottom: 10px; border-radius: 8px; position: relative; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <div style="color: #333; margin-bottom: 5px;">
                    {{ $notification->data['message'] }}
                </div>
                <small style="color: #888; font-size: 0.75rem;">
                    {{ $notification->created_at->diffForHumans() }}
                </small>

                {{-- رابط لتحديد الإشعار كمقروء --}}
                {{-- <a href="{{ route('notifications.read', $notification->id) }}" style="position: absolute; top: 10px; left: 10px; text-decoration: none; font-size: 1.2rem; color: #ccc;">×</a> --}}
            </div>
        @empty
            <div style="text-align: center; color: #999; padding: 20px;">
                لا توجد إشعارات جديدة حالياً.. القمر هادئ! 🌕
            </div>
        @endforelse
    </div>


</x-layout>
