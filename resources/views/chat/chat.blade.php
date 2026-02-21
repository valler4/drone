<x-slot:title>{{ $selectedUser->name  }}'s Chat</x-slot:title>
<div
    class="flex h-[90vh] bg-white dark:bg-zinc-900 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-zinc-800">
    <div class="w-1/3 flex flex-col border-r border-slate-200 dark:border-zinc-800 bg-slate-50 dark:bg-zinc-950">
        <div
            class="p-4 border-b border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex justify-between items-center">
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tighter">المحادثات</h2>
            <span
                class="bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-bold px-2 py-1 rounded-full uppercase">متصل</span>
        </div>

        <div class="flex-1 overflow-y-auto">
            @foreach ($users as $user)
                <div wire:click="selectUser({{ $user->id }})"
                    class="flex items-center p-4 border-b border-slate-100 dark:border-zinc-800/50 hover:bg-blue-50 dark:hover:bg-zinc-800 cursor-pointer transition
                    {{ $selectedUser->id === $user->id ? 'bg-blue-50 dark:bg-zinc-800 border-l-4 border-l-blue-600' : '' }}">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                            class="w-12 h-12 rounded-full border border-slate-200 dark:border-zinc-700">
                        <div
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-zinc-900 rounded-full">
                        </div>
                    </div>
                    <div class="ml-3 flex-1 overflow-hidden">
                        <div class="flex justify-between items-baseline">
                            <h3 class="font-bold text-slate-900 dark:text-slate-200 truncate">{{ $user->name }}</h3>
                            <span class="text-[10px] text-slate-400 uppercase">12:45 PM</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">انقر لبدء المحادثة...</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="w-2/3 flex flex-col bg-white dark:bg-zinc-900">
        <div
            class="p-4 border-b border-slate-200 dark:border-zinc-800 flex items-center bg-white dark:bg-zinc-900 shadow-sm z-10">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedUser->name) }}&background=random"
                class="w-10 h-10 rounded-full">
            <div class="ml-3">
                <h3 class="font-bold text-slate-900 dark:text-white">{{ $selectedUser->name }}</h3>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    <p class="text-xs text-green-600 dark:text-green-400 font-medium">متصل الآن</p>
                </div>
                <p id="typing" class="hidden text-xs text-slate-400 italic">typing...</p>
            </div>
        </div>

        <div id="selectedUserId" data-id="{{ $selectedUser->id }}" class="hidden" aria-hidden="true"></div>

        <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50 dark:bg-zinc-950/50">
            <div id="load-more-trigger" style="height: 1px;"></div>
            @foreach ($messages as $message)
                <div wire:key="msg-{{ $message->id }}"
                    class="flex {{ $message->sender->id === auth()->id() ? 'justify-end' : 'justify-start' }} mb-2">
                    <div
                        class=" {{ $message->sender->id === auth()->id()
                            ? 'bg-emerald-600 p-3 rounded-lg rounded-tr-none shadow-sm max-w-[75%] md:max-w-md'
                            : 'bg-gray-200 border dark:bg-zinc-800 text-slate-900 dark:text-slate-200 p-3 rounded-lg rounded-tl-none shadow-sm max-w-[75%] md:max-w-md' }}">

                        {{-- الإضافة هنا: break-words تضمن عدم خروج النص --}}
                        <p class="text-sm text-white break-words whitespace-pre-wrap leading-relaxed">
                            {{ $message->message }}</p>

                        <div class="flex items-center justify-end mt-1 gap-1">
                            <span class="text-[10px] text-white">{{ $message->created_at->format('g:i A') }}</span>
                            @if ($message->sender->id === auth()->id())
                                <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                                    </path>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="p-4 bg-white dark:bg-zinc-900 border-t border-slate-200 dark:border-zinc-800">
            <form wire:submit="submit" class="flex items-center gap-3">
                <button type="button" class="text-slate-400 hover:text-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </button>

                <input id="newMessageInput" wire:model="newMessage" type="text" placeholder="اكتب رسالة..."
                    class="flex-1 border border-slate-200 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none rounded-full px-5 py-2.5 text-sm transition-all" />

                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white p-2.5 rounded-full shadow-lg transition-all transform active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:initialized', function() {
        const container = document.getElementById('messages-container');
        const trigger = document.getElementById('load-more-trigger');
        const input = document.getElementById('newMessageInput');
        let shouldScroll = true; // نتحكم من خلاله هل ينزل السكرول تلقائياً أم يثبت

        // دالة النزول لأسفل المحادثة
        const scrollToBottom = (force = false) => {
            if (container && (shouldScroll || force)) {
                container.scrollTop = container.scrollHeight;
            }
        };

        // 1. مراقبة وصول المستخدم لأعلى القائمة (Infinite Scroll)
        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                // إذا وصل للأعلى، نوقف السكرول التلقائي مؤقتاً لنحمل القديم
                shouldScroll = false;

                const oldScrollHeight = container.scrollHeight;

                // استدعاء دالة loadMore الموجودة في ملف الـ PHP
                @this.loadMore().then(() => {
                    // بعد انتهاء التحميل، نحافظ على موضع الرؤية لكي لا يقفز السكرول
                    setTimeout(() => {
                        container.scrollTop = container.scrollHeight - oldScrollHeight;
                    }, 50);
                });
            }
        }, {
            threshold: 0.5
        });

        if (trigger) observer.observe(trigger);

        // 2. التعامل مع تحديثات Livewire (مثل تبديل المحادثة أو إرسال رسالة)
        Livewire.hook('morph.updated', (el, component) => {
            if (shouldScroll) {
                scrollToBottom();
            }
        });

        // تنفيذ السكرول عند تحميل الصفحة لأول مرة
        scrollToBottom(true);

        // 3. كود الـ Typing (إرسال إشارة "جاري الكتابة")
        if (input) {
            input.addEventListener('input', function() {
                const selectedEl = document.getElementById('selectedUserId');
                const selectedUserId = selectedEl ? selectedEl.dataset.id : null;
                if (selectedUserId) {
                    try {
                        window.Echo.private(`chat.${selectedUserId}`).whisper('typing', {
                            userID: {{ $loginId }},
                            userName: "{{ addslashes(auth()->user()->name ?? '') }}"
                        });
                    } catch (e) {
                        console.debug('Echo whisper failed', e);
                    }
                }
            });
        }

        // 4. استقبال إشارة "جاري الكتابة" من الطرف الآخر
        window.Echo.private(`chat.{{ $loginId }}`).listenForWhisper('typing', (event) => {
            var t = document.getElementById('typing');
            if (!t) return;
            t.classList.remove('hidden');
            t.innerText = `${event.userName} is typing...`;
            if (t._typingTimeout) clearTimeout(t._typingTimeout);
            t._typingTimeout = setTimeout(() => {
                t.classList.add('hidden');
            }, 2000);
        });

        // 5. استقبال الرسائل الجديدة عبر Laravel Echo
        window.Echo.private(`chat.{{ $loginId }}`).listen('MessageSent', (data) => {
            console.log('MessageSent received:', data);

            // بما أنها رسالة جديدة، نفعل السكرول لكي يراها المستخدم
            shouldScroll = true;

            Livewire.dispatch('messageReceived', {
                message: data
            });

            setTimeout(() => scrollToBottom(true), 100);
        });

        // 6. عند إرسال المستخدم رسالة (Submit Form)
        const chatForm = document.querySelector('form');
        if (chatForm) {
            chatForm.addEventListener('submit', () => {
                shouldScroll = true; // إجبار السكرول للأسفل عند الإرسال
                setTimeout(() => scrollToBottom(true), 100);
            });
        }
    });
</script>
